<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anggota;
use App\Divisi;
use Illuminate\Support\Facades\DB;
use Options;
use Auth;
use App\Periode;
use App\TransaksiHarian;
use App\ActivityLog;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $roleNames = $user->roles->pluck('name')
            ->map(function ($roleName) {
                return strtolower(trim($roleName));
            });
        $periode = Periode::select()->where('status', 1)->first();
        $anggota_aktif = Anggota::select()->where('status', 1)->count();
        $anggota_disable = Anggota::select()->where('status', 0)->count();
        $status_anggota = [$anggota_aktif, $anggota_disable];
        if ($roleNames->intersect(['admin', 'ketua', 'ketua koperasi', 'operator'])->isNotEmpty())
        {
            if (!$periode) {
                return redirect()->route('periode.index')->with('flash_notification', [
                    'level' => 'warning',
                    'message' => 'Belum ada periode aktif. Silakan buat periode atau aktifkan periode yang tersedia sebelum membuka dashboard.'
                ]);
            }

            $transaksi_harian = TransaksiHarian::with(['sumKreditAll', 'sumDebitAll'])
                ->with(['divisi', 'nama_anggota.anggota'])
                ->orderBy('tgl', 'DESC')
                ->orderBy('id', 'DESC')
                ->limit(15)
                ->get();
            $aktivitas_transaksi = DB::table('transaksi_harians')
                ->leftJoin('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                ->whereIn('transaksi_harians.jenis_transaksi', [1, 2])
                ->select(
                    'transaksi_harians.jenis_transaksi',
                    DB::raw('COUNT(DISTINCT transaksi_harians.id) as jumlah_transaksi'),
                    DB::raw('COALESCE(SUM(transaksi_harian_biayas.nominal), 0) as total_nominal')
                )
                ->groupBy('transaksi_harians.jenis_transaksi')
                ->get()
                ->keyBy('jenis_transaksi');
            $total_debet_semua = $aktivitas_transaksi->get(1)->total_nominal ?? 0;
            $total_kredit_semua = $aktivitas_transaksi->get(2)->total_nominal ?? 0;
            $jumlah_debet_semua = $aktivitas_transaksi->get(1)->jumlah_transaksi ?? 0;
            $jumlah_kredit_semua = $aktivitas_transaksi->get(2)->jumlah_transaksi ?? 0;
            $arus_transaksi = DB::table('transaksi_harians as th')
                ->leftJoin('transaksi_harian_biayas as thb', 'th.id', '=', 'thb.transaksi_harian_id')
                ->leftJoin('biayas as b', 'thb.biaya_id', '=', 'b.id')
                ->leftJoin('divisis as d', 'th.divisi_id', '=', 'd.id')
                ->whereIn('th.jenis_transaksi', [1, 2])
                ->select(
                    'th.divisi_id',
                    'th.jenis_transaksi',
                    'b.id as biaya_id',
                    DB::raw("COALESCE(d.name, 'Tanpa divisi') as nama_divisi"),
                    DB::raw("COALESCE(b.name, 'Tanpa rincian') as nama_biaya"),
                    DB::raw('COUNT(DISTINCT th.id) as jumlah_transaksi'),
                    DB::raw('COALESCE(SUM(thb.nominal), 0) as total_nominal')
                )
                ->groupBy('th.divisi_id', 'd.name', 'th.jenis_transaksi', 'b.id', 'b.name')
                ->orderBy('th.jenis_transaksi')
                ->orderBy('d.name')
                ->orderBy('b.name')
                ->get();
            $sum_pokok = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode->open_date, $periode->close_date])
                        ->where('transaksi_harian_biayas.biaya_id', '1')
                        ->where('divisi_id', '1')
                        ->sum('transaksi_harian_biayas.nominal');
            $sum_wajib = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode->open_date, $periode->close_date])
                        ->where('transaksi_harian_biayas.biaya_id', '2')
                        ->where('divisi_id', '1')
                        ->sum('transaksi_harian_biayas.nominal');
            $sum_sukarela = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode->open_date, $periode->close_date])
                        ->where('transaksi_harian_biayas.biaya_id', '3')
                        ->where('divisi_id', '1')
                        ->sum('transaksi_harian_biayas.nominal');
            $kredit_simpanan = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode->open_date, $periode->close_date])
                        ->where('transaksi_harian_biayas.biaya_id', '4')
                        ->where('divisi_id', '1')
                        ->sum('transaksi_harian_biayas.nominal');
            $debet_pinjaman = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode->open_date, $periode->close_date])
                        ->where('transaksi_harian_biayas.biaya_id', '6')
                        ->where('divisi_id', '2')
                        ->sum('transaksi_harian_biayas.nominal');
            $bunga_pinjaman = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode->open_date, $periode->close_date])
                        ->where('transaksi_harian_biayas.biaya_id', '7')
                        ->where('divisi_id', '2')
                        ->sum('transaksi_harian_biayas.nominal');
            $kredit_pinjaman = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode->open_date, $periode->close_date])
                        ->where('transaksi_harian_biayas.biaya_id', '8')
                        ->where('divisi_id', '2')
                        ->sum('transaksi_harian_biayas.nominal');
            $saldo_kredit = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode->open_date, $periode->close_date])
                        ->where('transaksi_harians.jenis_transaksi', 2)
                        ->sum('transaksi_harian_biayas.nominal');
            $saldo_debit = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode->open_date, $periode->close_date])
                        ->where('transaksi_harians.jenis_transaksi', 1)
                        ->sum('transaksi_harian_biayas.nominal');
            $countAnggota = Anggota::select()->count();
            $countDivisi = Divisi::select()->count();
            $activity_log = ActivityLog::with('user')->latest('created_at')->limit(10)->get();
            $result = TransaksiHarian::where('periode_id', $periode->id)
                        ->selectRaw('year(tgl) year, monthname(tgl) month, count(*) data, month(tgl) mon')
                        ->groupBy('year', 'month', 'mon')
                        ->orderBy('year', 'Asc')
                        ->orderBy('mon', 'Asc')
                        ->get();

            $tr_debits = DB::table('transaksi_harians')
                            ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                            ->where('transaksi_harians.jenis_transaksi', 1)
                            ->where('periode_id', $periode->id)
                            ->select(
                                DB::raw('sum(transaksi_harian_biayas.nominal) as sums'),
                                DB::raw("month(transaksi_harians.tgl) as mon"),
                                DB::raw("year(transaksi_harians.tgl) year")
                            )
                            ->groupBy('year')
                            ->groupBy('mon')
                            ->orderBy('year', 'Asc')
                            ->orderBy('mon', 'Asc')
                            ->get();
            $tr_kredits = DB::table('transaksi_harians')
                            ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                            ->where('transaksi_harians.jenis_transaksi', 2)
                            ->where('periode_id', $periode->id)
                            ->select(
                                DB::raw('sum(transaksi_harian_biayas.nominal) as sums'),
                                DB::raw("month(transaksi_harians.tgl) as mon"),
                                DB::raw("year(transaksi_harians.tgl) year")
                            )
                            ->groupBy('year')
                            ->groupBy('mon')
                            ->orderBy('year', 'Asc')
                            ->orderBy('mon', 'Asc')
                            ->get();
            $debitAll = [];
            foreach($tr_debits as $tr_debit)
            {
                array_push($debitAll, $tr_debit->sums);
            }
            $months = [];
            $kreditAll = [];
            foreach($result as $item){
                array_push($months, $item->month.' '.$item->year);
            }
            foreach($tr_kredits as $tr_kredit)
            {
                array_push($kreditAll, $tr_kredit->sums);
            }
            return view('dashboard.admin')->with(compact('countAnggota', 'countDivisi', 'periode', 'sum_pokok', 'sum_wajib', 'sum_sukarela', 'kredit_simpanan',
                    'debet_pinjaman', 'bunga_pinjaman', 'kredit_pinjaman', 'transaksi_harian', 'activity_log', 'saldo_kredit', 'saldo_debit', 'status_anggota',
                'months', 'debitAll', 'kreditAll', 'total_debet_semua', 'total_kredit_semua', 'jumlah_debet_semua', 'jumlah_kredit_semua', 'arus_transaksi'));
        }
        elseif ($user->hasMemberRole())
        {
            return view('dashboard.member');
        }else {
            return view('dashboard.member');
        }
    }
}
