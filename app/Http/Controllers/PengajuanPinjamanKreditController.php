<?php

namespace App\Http\Controllers;

use App\Anggota;
use App\Periode;
use App\PengajuanPinjamanKredit;
use App\TransaksiHarian;
use App\TransaksiHarianAnggota;
use App\TransaksiHarianBiaya;
use App\TransaksiPinjaman;
use App\UserAnggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Tanggal;

class PengajuanPinjamanKreditController extends Controller
{
    private $approvalStages = [
        'menunggu_admin' => [
            'permission' => 'approve-pengajuan-pinjaman-admin',
            'role' => 'Admin',
            'user_column' => 'admin_user_id',
            'note_column' => 'admin_catatan',
            'date_column' => 'admin_diproses_pada',
            'next_status' => 'menunggu_bendahara',
        ],
        'menunggu_bendahara' => [
            'permission' => 'approve-pengajuan-pinjaman-bendahara',
            'role' => 'Bendahara',
            'user_column' => 'bendahara_user_id',
            'note_column' => 'bendahara_catatan',
            'date_column' => 'bendahara_diproses_pada',
            'next_status' => 'menunggu_ketua',
        ],
        'menunggu_ketua' => [
            'permission' => 'approve-pengajuan-pinjaman-ketua',
            'role' => 'Ketua',
            'user_column' => 'ketua_user_id',
            'note_column' => 'ketua_catatan',
            'date_column' => 'ketua_diproses_pada',
            'next_status' => 'disetujui',
        ],
    ];

    public function index()
    {
        $user = Auth::user();
        abort_unless($user->can('view-pengajuan-pinjaman-kredit'), 403);

        $applications = PengajuanPinjamanKredit::with(['anggota', 'user'])
            ->when($user->hasMemberRole(), function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->get();

        return view('pengajuan-pinjaman.index', compact('applications'));
    }

    public function create()
    {
        abort_unless(Auth::user()->hasMemberRole() && Auth::user()->can('create-pengajuan-pinjaman-kredit'), 403);

        return view('pengajuan-pinjaman.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        abort_unless($user->hasMemberRole() && $user->can('create-pengajuan-pinjaman-kredit'), 403);

        $validated = $request->validate([
            'nominal' => 'required|integer|min:1|max:9999999999',
            'lama_cicilan' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:2000',
        ]);

        $anggotaId = UserAnggota::where('user_id', $user->id)->value('anggota_id');
        if (!$anggotaId) {
            throw ValidationException::withMessages([
                'nominal' => 'Akun Anda belum terhubung dengan data anggota. Hubungi administrator.',
            ]);
        }

        PengajuanPinjamanKredit::create([
            'user_id' => $user->id,
            'anggota_id' => $anggotaId,
            'nominal' => $validated['nominal'],
            'lama_cicilan' => $validated['lama_cicilan'],
            'keterangan' => $validated['keterangan'] ?? null,
            'status' => 'menunggu_admin',
        ]);

        return redirect()->route('pengajuan-pinjaman.index')
            ->with('success', 'Pengajuan pinjaman berhasil dikirim untuk persetujuan Admin.');
    }

    public function show(PengajuanPinjamanKredit $pengajuanPinjaman)
    {
        $this->authorizeApplication($pengajuanPinjaman);
        $pengajuanPinjaman->load([
            'anggota',
            'user',
            'transaksiHarian',
            'adminApprover',
            'bendaharaApprover',
            'ketuaApprover',
        ]);

        $stage = $this->approvalStages[$pengajuanPinjaman->status] ?? null;
        $canApprove = $stage && Auth::user()->can($stage['permission']);

        return view('pengajuan-pinjaman.show', compact('pengajuanPinjaman', 'stage', 'canApprove'));
    }

    public function decide(Request $request, PengajuanPinjamanKredit $pengajuanPinjaman)
    {
        $stage = $this->approvalStages[$pengajuanPinjaman->status] ?? null;
        abort_unless($stage && Auth::user()->can($stage['permission']), 403);

        $rules = [
            'decision' => 'required|in:approve,reject',
            'catatan' => 'nullable|string|max:2000',
        ];
        if ($pengajuanPinjaman->status === 'menunggu_ketua' && $request->input('decision') === 'approve') {
            $rules['tgl_pencairan'] = 'required|date_format:d-m-Y';
            $rules['jenis_pembayaran'] = 'required|in:1,2';
        }
        if ($request->input('decision') === 'reject') {
            $rules['catatan'] = 'required|string|max:2000';
        }
        $validated = $request->validate($rules);

        DB::transaction(function () use ($pengajuanPinjaman, $stage, $validated) {
            $application = PengajuanPinjamanKredit::whereKey($pengajuanPinjaman->id)
                ->lockForUpdate()
                ->firstOrFail();
            if ($application->status !== $pengajuanPinjaman->status) {
                abort(409, 'Tahap persetujuan pengajuan sudah berubah.');
            }

            $application->{$stage['user_column']} = Auth::id();
            $application->{$stage['note_column']} = $validated['catatan'] ?? null;
            $application->{$stage['date_column']} = now();

            if ($validated['decision'] === 'reject') {
                $application->status = 'ditolak';
                $application->save();
                return;
            }

            if ($application->status !== 'menunggu_ketua') {
                $application->status = $stage['next_status'];
                $application->save();
                return;
            }

            $periode = Periode::where('status', '1')->first();
            if (!$periode) {
                throw ValidationException::withMessages([
                    'tgl_pencairan' => 'Tidak ada periode buku yang aktif untuk pencairan pinjaman.',
                ]);
            }

            $transaksiHarian = new TransaksiHarian();
            $transaksiHarian->tgl = Tanggal::convert_tanggal($validated['tgl_pencairan']);
            $transaksiHarian->divisi_id = '2';
            $transaksiHarian->jenis_pembayaran = $validated['jenis_pembayaran'];
            $transaksiHarian->jenis_transaksi = '2';
            $transaksiHarian->keterangan = $application->keterangan;
            $transaksiHarian->periode_id = $periode->id;
            $transaksiHarian->save();

            $transaksiAnggota = new TransaksiHarianAnggota();
            $transaksiAnggota->transaksi_harian_id = $transaksiHarian->id;
            $transaksiAnggota->anggota_id = $application->anggota_id;
            $transaksiAnggota->save();

            $transaksiBiaya = new TransaksiHarianBiaya();
            $transaksiBiaya->transaksi_harian_id = $transaksiHarian->id;
            $transaksiBiaya->biaya_id = '8';
            $transaksiBiaya->nominal = $application->nominal;
            $transaksiBiaya->save();

            $transaksiPinjaman = new TransaksiPinjaman();
            $transaksiPinjaman->transaksi_harian_biaya_id = $transaksiBiaya->id;
            $transaksiPinjaman->lama_cicilan = $application->lama_cicilan;
            $transaksiPinjaman->save();

            $application->jenis_pembayaran = $validated['jenis_pembayaran'];
            $application->tgl_pencairan = Tanggal::convert_tanggal($validated['tgl_pencairan']);
            $application->transaksi_harian_id = $transaksiHarian->id;
            $application->status = 'disetujui';
            $application->save();
        });

        return redirect()->route('pengajuan-pinjaman.show', $pengajuanPinjaman->id)
            ->with('success', $validated['decision'] === 'approve'
                ? 'Persetujuan berhasil disimpan.'
                : 'Pengajuan ditolak.');
    }

    private function authorizeApplication(PengajuanPinjamanKredit $application)
    {
        $user = Auth::user();
        if ($user->hasMemberRole()) {
            abort_unless(
                $user->can('view-pengajuan-pinjaman-kredit') && (int) $application->user_id === (int) $user->id,
                404
            );

            return;
        }

        abort_unless($user->can('view-pengajuan-pinjaman-kredit'), 403);
    }
}
