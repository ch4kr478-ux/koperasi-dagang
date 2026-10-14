<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\TransaksiHarian;
use Tanggal;
use App\Periode;
use App\TransaksiHarianAnggota;
use App\TransaksiHarianBiaya;
use App\TransaksiPinjaman;
use App\TransaksiPinjamanCicilan;
use Money;
use App\Imports\PinjamanDebet;
use App\Support\PinjamanCalculator;
use Session;
use Illuminate\Support\Facades\DB;
use Excel;
use File;
use App\Anggota;
use Illuminate\Validation\ValidationException;


class PinjamanDebetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $user = \Auth::user();
        $isMember = $user->hasMemberRole();
        if ($user->can('manage-debet-pinjaman') || $isMember) {
            # code...
            if ($request->ajax()) {
                $transaksiHarian = TransaksiHarian::with([
                    'divisi', 'nama_anggota' => function ($sql) {
                        $sql->with('anggota');
                    }, 'sumBunga', 'sumCicilan', 'cicilanPinjaman'
                ])
                    ->withDisplayNumber(2, 1)
                    ->where('divisi_id', '2')
                    ->where('jenis_transaksi', '1')
                    ->orderBy('transaksi_harians.id', 'asc');
                if ($isMember) {
                    $transaksiHarian->forMember($user);
                }
                return DataTables::of($transaksiHarian)
                    ->editColumn('tgl', function ($transaksiHarian) {
                        return Tanggal::tanggal_id($transaksiHarian->tgl);
                    })
                    ->editColumn('jenis_pembayaran', function ($transaksiHarian) {
                        if ($transaksiHarian->jenis_pembayaran == '1') {
                            return '<span class="badge badge-success badge-pill">Cash</span>';
                        } else {
                            return '<span class="badge badge-danger badge-pill">Bank</span>';
                        }
                    })
                    ->editColumn('jenis_transaksi', function ($transaksiHarian) {
                        return '<span class="badge badge-info badge-pill">Debet</span>';
                    })
                    ->addColumn('action', function ($transaksiHarian) use ($isMember) {
                        if ($isMember) {
                            return '';
                        }

                        return view('datatable._action-transaction', [
                            'model' => $transaksiHarian,
                            'form_url' => route('pinjaman-debet.destroy', $transaksiHarian->id),
                            'edit_url' => route('pinjaman-debet.edit', $transaksiHarian->id),
                            'can_edit' => 'edit-debet-pinjaman',
                            'can_delete' => 'delete-debet-pinjaman',
                            'confirm_message' => 'Apakah anda yakin mau Transaksi'
                        ]);
                    })
                    ->editColumn('sumBunga', function ($transaksiHarian) {
                        return Money::stringToRupiah($transaksiHarian->sumBunga->sum('nominal'));
                    })
                    ->editColumn('sumCicilan', function ($transaksiHarian) {
                        return Money::stringToRupiah($transaksiHarian->sumCicilan->sum('nominal'));
                    })
                    ->addColumn('angsuran_kredit', function ($transaksiHarian) {
                        return $transaksiHarian->cicilanPinjaman
                            ? 'Angsuran ke-' . $transaksiHarian->cicilanPinjaman->angsuran_ke
                            : '-';
                    })
                    ->addColumn('tabungan_cicilan', function ($transaksiHarian) {
                        return $transaksiHarian->cicilanPinjaman
                            ? Money::stringToRupiah($transaksiHarian->cicilanPinjaman->tabungan)
                            : '-';
                    })
                    ->editColumn('is_close', function ($transaksiHarian) {
                        if ($transaksiHarian->is_close == '0') {
                            return '<p class="text-primary">Aktif</p>';
                        } else {
                            return '<p class="text-danger">None Aktif</p>';
                        }
                    })
                    ->rawColumns(['jenis_pembayaran', 'jenis_transaksi', 'action', 'is_close'])
                    ->make(true);
            }
            return view('pinjaman-debet.index', compact('isMember'));
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(!\Auth::user()->hasMemberRole(), 403);
        //
        if (\Auth::user()->can('create-debet-pinjaman')) {
            # code...
            $cicilanTersedia = $this->availableInstallments();
            return view('pinjaman-debet.create', compact('cicilanTersedia'));
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_unless(!\Auth::user()->hasMemberRole(), 403);
        //
        if (\Auth::user()->can('create-debet-pinjaman')) {
            $validated = $this->validate($request, [
                'tgl' => 'required',
                'jenis_pembayaran' => 'required|in:1,2',
                'anggota_id' => 'required|exists:anggotas,id',
                'keterangan' => 'nullable|string',
                'transaksi_pinjaman_id' => 'nullable|integer|exists:transaksi_pinjamen,id',
                'angsuran_ke' => 'nullable|integer|min:1',
            ]);

            $isInstallmentPayment = !empty($validated['transaksi_pinjaman_id']);
            if (!$isInstallmentPayment) {
                $this->validate($request, [
                    'nominal_pinjaman' => 'required|string',
                    'nominal_bunga' => 'required|string',
                ]);
            }

            DB::transaction(function () use ($request, $validated, $isInstallmentPayment) {
                $installment = $isInstallmentPayment
                    ? $this->resolveNextInstallment(
                        $validated['transaksi_pinjaman_id'],
                        $validated['anggota_id'],
                        true
                    )
                    : null;

                if ($installment && isset($validated['angsuran_ke'])
                    && (int) $installment['bulan'] !== (int) $validated['angsuran_ke']) {
                    throw ValidationException::withMessages([
                        'angsuran_ke' => 'Cicilan ini sudah dibayar atau bukan cicilan berikutnya.',
                    ]);
                }

                $periode = Periode::where('status', '1')->firstOrFail();
                $tgl = Tanggal::convert_tanggal($request->tgl);
                $transaksiHarian = TransaksiHarian::create([
                    'tgl' => $tgl,
                    'divisi_id' => '2',
                    'jenis_pembayaran' => $validated['jenis_pembayaran'],
                    'jenis_transaksi' => '1',
                    'keterangan' => $request->keterangan ?: ($installment
                        ? 'Pembayaran angsuran pinjaman ke-' . $installment['angsuran_ke']
                        : null),
                    'periode_id' => $periode->id,
                ]);
                TransaksiHarianAnggota::create([
                    'transaksi_harian_id' => $transaksiHarian->id,
                    'anggota_id' => $validated['anggota_id'],
                ]);

                $pokok = $installment
                    ? $installment['pokok']
                    : (int) Money::rupiahToString($request->nominal_pinjaman);
                $bunga = $installment
                    ? $installment['bunga']
                    : (int) Money::rupiahToString($request->nominal_bunga);

                TransaksiHarianBiaya::create([
                    'transaksi_harian_id' => $transaksiHarian->id,
                    'biaya_id' => '6',
                    'nominal' => $pokok,
                ]);
                TransaksiHarianBiaya::create([
                    'transaksi_harian_id' => $transaksiHarian->id,
                    'biaya_id' => '7',
                    'nominal' => $bunga,
                ]);

                if ($installment) {
                    $savingTransaction = TransaksiHarian::create([
                        'tgl' => $tgl,
                        'divisi_id' => '1',
                        'jenis_pembayaran' => $validated['jenis_pembayaran'],
                        'jenis_transaksi' => '1',
                        'keterangan' => 'Simpanan wajib angsuran pinjaman ke-' . $installment['angsuran_ke'],
                        'periode_id' => $periode->id,
                    ]);
                    TransaksiHarianAnggota::create([
                        'transaksi_harian_id' => $savingTransaction->id,
                        'anggota_id' => $validated['anggota_id'],
                    ]);
                    TransaksiHarianBiaya::create([
                        'transaksi_harian_id' => $savingTransaction->id,
                        'biaya_id' => '2',
                        'nominal' => $installment['tabungan'],
                    ]);

                    TransaksiPinjamanCicilan::create([
                        'transaksi_pinjaman_id' => $validated['transaksi_pinjaman_id'],
                        'transaksi_harian_id' => $transaksiHarian->id,
                        'simpanan_transaksi_harian_id' => $savingTransaction->id,
                        'angsuran_ke' => $installment['angsuran_ke'],
                        'jatuh_tempo' => $installment['jatuh_tempo']->format('Y-m-d'),
                        'pokok' => $installment['pokok'],
                        'bunga' => $installment['bunga'],
                        'tabungan' => $installment['tabungan'],
                    ]);
                }
            });

            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Berhasil Menambah Data Transaksi !!!"
            ]);
            activity()->log('Menambahkan Data Pinjaman Debet');
            return redirect()->route('pinjaman-debet.index');
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(!\Auth::user()->hasMemberRole(), 403);
        //
        if (\Auth::user()->can('edit-debet-pinjaman')) {
            # code...
            $transaksiHarian = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harian_biayas.transaksi_harian_id', '=', 'transaksi_harians.id')
                ->join('transaksi_harian_anggotas', 'transaksi_harian_anggotas.transaksi_harian_id', '=', 'transaksi_harians.id')
                ->where('transaksi_harians.id', $id)
                ->first();
            $nominal_pinjaman = DB::table('transaksi_harian_biayas')
                ->where('transaksi_harian_id', $id)
                ->where('biaya_id', '6')
                ->sum('nominal');
            $nominal_bunga = DB::table('transaksi_harian_biayas')
                ->where('transaksi_harian_id', $id)
                ->where('biaya_id', '7')
                ->sum('nominal');
            $nominal_pinjaman = Money::stringToRupiah($nominal_pinjaman);
            $nominal_bunga = Money::stringToRupiah($nominal_bunga);
            $transaksiHarian->nominal = Money::stringToRupiah($transaksiHarian->nominal);
            $transaksiHarian->tgl = date('d-m-Y', strtotime($transaksiHarian->tgl));
            $memberLink = TransaksiHarianAnggota::where('transaksi_harian_id', $id)->first();
            $transaksiHarian->anggota_id = $memberLink ? $memberLink->anggota_id : null;
            $transaksiHarian->nama_anggota = $memberLink && $memberLink->anggota
                ? $memberLink->anggota->nama
                : '';
            $installmentPayment = TransaksiPinjamanCicilan::where('transaksi_harian_id', $id)->first();
            return view('pinjaman-debet.edit')->with(compact(
                'transaksiHarian',
                'nominal_pinjaman',
                'nominal_bunga',
                'installmentPayment'
            ));
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_unless(!\Auth::user()->hasMemberRole(), 403);
        //
        if (\Auth::user()->can('edit-debet-pinjaman')) {
            # code...
            $validated = $this->validate($request, [
                'tgl' => 'required',
                'jenis_pembayaran' => 'required|in:1,2',
                'anggota_id' => 'required|exists:anggotas,id',
                'keterangan' => 'nullable|string',
            ]);

            $installmentPayment = TransaksiPinjamanCicilan::where('transaksi_harian_id', $id)->first();
            if (!$installmentPayment) {
                $this->validate($request, [
                    'nominal_pinjaman' => 'required|string',
                    'nominal_bunga' => 'required|string',
                ]);
            }

            DB::transaction(function () use ($request, $id, $validated, $installmentPayment) {
                $transaksiHarian = TransaksiHarian::findOrFail($id);
                $memberLink = TransaksiHarianAnggota::where('transaksi_harian_id', $id)->firstOrFail();
                if ($installmentPayment && (int) $validated['anggota_id'] !== (int) $memberLink->anggota_id) {
                    throw ValidationException::withMessages([
                        'anggota_id' => 'Anggota pembayaran cicilan tidak dapat diubah.',
                    ]);
                }

                $transaksiHarian->tgl = Tanggal::convert_tanggal($request->tgl);
                $transaksiHarian->jenis_pembayaran = $validated['jenis_pembayaran'];
                $transaksiHarian->keterangan = $request->keterangan;
                $transaksiHarian->save();

                if (!$installmentPayment) {
                    $memberLink->anggota_id = $validated['anggota_id'];
                    $memberLink->save();
                }

                $pokok = $installmentPayment
                    ? $installmentPayment->pokok
                    : (int) Money::rupiahToString($request->nominal_pinjaman);
                $bunga = $installmentPayment
                    ? $installmentPayment->bunga
                    : (int) Money::rupiahToString($request->nominal_bunga);
                TransaksiHarianBiaya::where('transaksi_harian_id', $id)
                    ->where('biaya_id', '6')->firstOrFail()->update(['nominal' => $pokok]);
                TransaksiHarianBiaya::where('transaksi_harian_id', $id)
                    ->where('biaya_id', '7')->firstOrFail()->update(['nominal' => $bunga]);

                if ($installmentPayment) {
                    $savingTransaction = TransaksiHarian::findOrFail($installmentPayment->simpanan_transaksi_harian_id);
                    $savingTransaction->tgl = $transaksiHarian->tgl;
                    $savingTransaction->jenis_pembayaran = $transaksiHarian->jenis_pembayaran;
                    $savingTransaction->keterangan = 'Simpanan wajib angsuran pinjaman ke-' . $installmentPayment->angsuran_ke;
                    $savingTransaction->save();
                }
            });

            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Berhasil Merubah Data Transaksi !!!"
            ]);
            activity()->log('Merubah Data Pinjaman Debet');
            return redirect()->route('pinjaman-debet.index');
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(!\Auth::user()->hasMemberRole(), 403);
        abort_unless(\Auth::user()->can('delete-debet-pinjaman'), 403);
        DB::transaction(function () use ($id) {
            $installmentPayment = TransaksiPinjamanCicilan::where('transaksi_harian_id', $id)->first();
            if ($installmentPayment) {
                TransaksiPinjamanCicilan::whereKey($installmentPayment->id)->delete();
                TransaksiHarianAnggota::where(
                    'transaksi_harian_id',
                    $installmentPayment->simpanan_transaksi_harian_id
                )->delete();
                TransaksiHarianBiaya::where(
                    'transaksi_harian_id',
                    $installmentPayment->simpanan_transaksi_harian_id
                )->delete();
                TransaksiHarian::whereKey($installmentPayment->simpanan_transaksi_harian_id)->delete();
            }
            TransaksiHarianAnggota::where('transaksi_harian_id', $id)->delete();
            TransaksiHarianBiaya::where('transaksi_harian_id', $id)->delete();
            TransaksiHarian::findOrFail($id)->delete();
        });
        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Berhasil Menghapus Transaksi !!!"
        ]);
        activity()->log('Menghapus Data Pinjaman Debet');

        return redirect()->route('pinjaman-debet.index');
    }

    public function upload()
    {
        abort_unless(!\Auth::user()->hasMemberRole(), 403);
        if (\Auth::user()->can('upload-debet-pinjaman')) {
            # code...
            return view('pinjaman-debet.upload');
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function doUpload(Request $request)
    {
        abort_unless(!\Auth::user()->hasMemberRole(), 403);
        $this->validate($request, [
			'file' => 'required'
		]);
        $periode = Periode::where('status', '1')->first();

        try {
            Excel::import(new PinjamanDebet($periode), request()->file('file'));
            activity()->log('Upload Data Pinjaman Debet');
            return redirect()->route('pinjaman-debet.index')->with('success', __('Data Pinjaman Debet Telah Sukses Di Tambahkan'));
        }catch(\Maatwebsite\Excel\Validators\ValidationException $e){
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                foreach($failure->errors() as $key)
                {
                    return redirect()->route('pinjaman-debet.index')->with('error', $key);
                }
                $failure->values(); // The values of the row that has failed.
            }
        }
    }

    private function availableInstallments($anggotaId = null)
    {
        $loans = TransaksiPinjaman::with([
            'transaksi_harian_biaya.transaksi_harian.transaksi_harian_anggota.anggota',
        ])->get();
        $installments = [];

        foreach ($loans as $loan) {
            $cost = $loan->transaksi_harian_biaya;
            $creditTransaction = $cost ? $cost->transaksi_harian : null;
            $memberLink = $creditTransaction ? $creditTransaction->transaksi_harian_anggota : null;
            $member = $memberLink ? $memberLink->anggota : null;

            if (!$cost || !$creditTransaction || !$member
                || (int) $creditTransaction->divisi_id !== 2
                || (int) $creditTransaction->jenis_transaksi !== 2
                || ($anggotaId && (int) $member->id !== (int) $anggotaId)) {
                continue;
            }

            $nextInstallment = $this->nextUnpaidSchedule($loan, (int) $cost->nominal);
            if (!$nextInstallment) {
                continue;
            }

            $installments[] = array_merge($nextInstallment, [
                'transaksi_pinjaman_id' => $loan->id,
                'anggota_id' => $member->id,
                'anggota_nama' => $member->nama,
                'produk' => $loan->produk_pinjaman_nama ?: 'Produk lama',
                'nominal_pinjaman' => (int) $cost->nominal,
                'tgl_pinjaman' => date('d-m-Y', strtotime($creditTransaction->tgl)),
            ]);
        }

        usort($installments, function ($first, $second) {
            return [$first['anggota_nama'], $first['tgl_pinjaman'], $first['transaksi_pinjaman_id']]
                <=> [$second['anggota_nama'], $second['tgl_pinjaman'], $second['transaksi_pinjaman_id']];
        });

        return $installments;
    }

    private function resolveNextInstallment($loanId, $anggotaId, $lockForUpdate = false)
    {
        $query = TransaksiPinjaman::with([
            'transaksi_harian_biaya.transaksi_harian.transaksi_harian_anggota',
        ])->whereKey($loanId);
        if ($lockForUpdate) {
            $query->lockForUpdate();
        }
        $loan = $query->firstOrFail();
        $cost = $loan->transaksi_harian_biaya;
        $creditTransaction = $cost ? $cost->transaksi_harian : null;
        $memberLink = $creditTransaction ? $creditTransaction->transaksi_harian_anggota : null;

        if (!$cost || !$creditTransaction || !$memberLink
            || (int) $creditTransaction->divisi_id !== 2
            || (int) $creditTransaction->jenis_transaksi !== 2
            || (int) $memberLink->anggota_id !== (int) $anggotaId) {
            throw ValidationException::withMessages([
                'transaksi_pinjaman_id' => 'Pinjaman kredit tidak ditemukan untuk anggota yang dipilih.',
            ]);
        }

        $nextInstallment = $this->nextUnpaidSchedule($loan, (int) $cost->nominal);
        if (!$nextInstallment) {
            throw ValidationException::withMessages([
                'transaksi_pinjaman_id' => 'Semua cicilan pinjaman ini sudah dibayar.',
            ]);
        }

        return $nextInstallment;
    }

    private function nextUnpaidSchedule(TransaksiPinjaman $loan, $amount)
    {
        $creditTransaction = $loan->transaksi_harian_biaya
            ? $loan->transaksi_harian_biaya->transaksi_harian
            : null;
        if (!$creditTransaction) {
            return null;
        }

        $schedule = PinjamanCalculator::schedule(
            $amount,
            $loan->lama_cicilan,
            $creditTransaction->tgl,
            $loan->bunga_persen ?: 1,
            $loan->tabungan_persen ?: 0.5
        );
        $paidNumbers = TransaksiPinjamanCicilan::where('transaksi_pinjaman_id', $loan->id)
            ->pluck('angsuran_ke')
            ->map(function ($number) {
                return (int) $number;
            })
            ->all();

        foreach ($schedule as $installment) {
            if (!in_array((int) $installment['bulan'], $paidNumbers, true)) {
                $installment['angsuran_ke'] = (int) $installment['bulan'];
                return $installment;
            }
        }

        return null;
    }

    public function closeBook()
    {
        abort_unless(!\Auth::user()->hasMemberRole(), 403);
        $periode = Periode::where('status', '1')->first();
        $want_close = Periode::where('status', 2)->first();
        $anggota = Anggota::select()->where('status', 1)->get();
        foreach ($anggota as $row) {
            $transaksiHarian = new TransaksiHarian();
            $transaksiHarian->tgl = Tanggal::convert_tanggal($periode->open_date);
            $transaksiHarian->divisi_id = '2';
            $transaksiHarian->jenis_pembayaran = '1';
            $transaksiHarian->jenis_transaksi = '1';
            $transaksiHarian->keterangan = 'Saldo Awal Periode ' . $periode->name;
            $transaksiHarian->periode_id = $periode->id;
            $transaksiHarian->save();
            //SUMP SIMPANAN KREDIT
            $sum_angsuran = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                ->whereBetween('transaksi_harians.tgl', [$want_close->open_date, $want_close->close_date])
                ->where('transaksi_harian_anggotas.anggota_id', $row->id)
                ->where('transaksi_harian_biayas.biaya_id', '6')
                ->where('divisi_id', '2')
                ->sum('transaksi_harian_biayas.nominal');
            $sum_bunga = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                ->whereBetween('transaksi_harians.tgl', [$want_close->open_date, $want_close->close_date])
                ->where('transaksi_harian_anggotas.anggota_id', $row->id)
                ->where('transaksi_harian_biayas.biaya_id', '7')
                ->where('divisi_id', '2')
                ->sum('transaksi_harian_biayas.nominal');
            //Store Saldo Pinjaman
            $transaksi_biaya = new TransaksiHarianBiaya();
            $transaksi_biaya->biaya_id = '6';
            $transaksi_biaya->transaksi_harian_id = $transaksiHarian->id;
            $transaksi_biaya->nominal = $sum_angsuran;
            $transaksi_biaya->save();

            //Store Bunga Pinjaman
            $transaksi_biaya = new TransaksiHarianBiaya();
            $transaksi_biaya->biaya_id = '7';
            $transaksi_biaya->transaksi_harian_id = $transaksiHarian->id;
            $transaksi_biaya->nominal = $sum_bunga;
            $transaksi_biaya->save();

            //Save Transation Member Kopkar
            $transaksi_harian_anggota = new TransaksiHarianAnggota();
            $transaksi_harian_anggota->transaksi_harian_id = $transaksiHarian->id;
            $transaksi_harian_anggota->anggota_id = $row->id;
            $transaksi_harian_anggota->save();

            //Update Simpanan All
            $transaksi_harian = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                ->whereBetween('transaksi_harians.tgl', [$want_close->open_date, $want_close->close_date])
                ->where('transaksi_harian_anggotas.anggota_id', $row->id)
                ->where('divisi_id', '2')
                ->whereIn('transaksi_harian_biayas.biaya_id', ['6', '7'])
                ->select('transaksi_harians.id as id')
                ->get();

            foreach ($transaksi_harian as $item) {
                $transaksi_harian = TransaksiHarian::find($item->id);
                $transaksi_harian->is_close = '1';
                $transaksi_harian->update();
            }
        }
        activity()->log('Tutup Buku Data Pinjaman Debet');
        return redirect()->route('pinjaman-debet.index');
    }
}
