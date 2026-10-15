<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\TransaksiHarian;
use Tanggal;
use App\Periode;
use App\TransaksiHarianAnggota;
use App\TransaksiHarianBiaya;
use Money;
use App\TransaksiPinjaman;
use App\TransaksiPinjamanCicilan;
use App\ProdukPinjaman;
use App\ProdukPinjamanTenor;
use App\Imports\PinjamanKredit;
use App\Exports\PinjamanKreditTemplate;
use App\Support\PinjamanCalculator;
use Maatwebsite\Excel\Facades\Excel;
use File;
use Session;
use Illuminate\Support\Facades\DB;
use App\Anggota;

class PinjamanKreditController extends Controller
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
        if ($user->can('manage-kredit-pinjaman') || $isMember) {
            # code...
            if ($request->ajax()) {
                $transaksiHarian = TransaksiHarian::with([
                    'divisi', 'nama_anggota' => function ($sql) {
                        $sql->with('anggota');
                    }, 'sumKreditPinjaman.transaksi_pinjaman'
                ])
                    ->withDisplayNumber(2, 2)
                    ->where('divisi_id', '2')
                    ->where('jenis_transaksi', '2')
                    ->orderBy('transaksi_harians.id', 'asc');
                if ($isMember) {
                    $transaksiHarian->forMember($user);
                }
                return DataTables::of($transaksiHarian)
                    ->addIndexColumn()
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
                        return '<span class="badge badge-info badge-pill">Kredit</span>';
                    })
                    ->addColumn('action', function ($transaksiHarian) use ($isMember) {
                        if ($isMember) {
                            return '';
                        }

                        return view('datatable._action-transaction', [
                            'model' => $transaksiHarian,
                            'form_url' => route('pinjaman-kredit.destroy', $transaksiHarian->id),
                            'edit_url' => route('pinjaman-kredit.edit', $transaksiHarian->id),
                            'can_edit' => 'edit-kredit-pinjaman',
                            'can_delete' => 'delete-kredit-pinjaman',
                            'confirm_message' => 'Apakah anda yakin mau Transaksi'
                        ]);
                    })
                    ->editColumn('is_close', function ($transaksiHarian) {
                        if ($transaksiHarian->is_close == '0') {
                            return '<p class="text-primary">Aktif</p>';
                        } else {
                            return '<p class="text-danger">None Aktif</p>';
                        }
                    })
                    ->editColumn('sumKreditPinjaman', function ($transaksiHarian) {
                        return Money::stringToRupiah($transaksiHarian->sumKreditPinjaman->sum('nominal'));
                    })
                    ->addColumn('produk_tenor', function ($transaksiHarian) {
                        $pinjaman = $transaksiHarian->sumKreditPinjaman->first();
                        $transaksiPinjaman = $pinjaman ? $pinjaman->transaksi_pinjaman : null;

                        if (!$transaksiPinjaman) {
                            return 'Data tenor tidak tersedia';
                        }

                        return ($transaksiPinjaman->produk_pinjaman_nama ?: 'Produk lama')
                            . ' - ' . $transaksiPinjaman->lama_cicilan . ' bulan';
                    })
                    ->addColumn('angsuran_per_bulan', function ($transaksiHarian) {
                        $pinjaman = $transaksiHarian->sumKreditPinjaman->first();
                        $transaksiPinjaman = $pinjaman ? $pinjaman->transaksi_pinjaman : null;

                        if (!$pinjaman || !$transaksiPinjaman) {
                            return '-';
                        }

                        $schedule = PinjamanCalculator::schedule(
                            $pinjaman->nominal,
                            $transaksiPinjaman->lama_cicilan,
                            $transaksiHarian->tgl,
                            $transaksiPinjaman->bunga_persen,
                            $transaksiPinjaman->tabungan_persen
                        );

                        return $schedule ? Money::stringToRupiah($schedule[0]['total']) : '-';
                    })
                    ->rawColumns(['jenis_pembayaran', 'jenis_transaksi', 'action', 'is_close'])
                    ->make(true);
            }
            return view('pinjaman-kredit.index', compact('isMember'));
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
        if (\Auth::user()->can('create-kredit-pinjaman')) {
            # code...
            $produkPinjaman = $this->productsForForm();
            return view('pinjaman-kredit.create', compact('produkPinjaman'));
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
        if (\Auth::user()->can('create-kredit-pinjaman')) {
            # code...
            $validated = $this->validateTransaction($request);
            $this->validate($request, [
                'tgl' => 'required',
                'divisi_id' => 'required',
                'jenis_transaksi' => 'required'
            ]);

            DB::transaction(function () use ($request, $validated) {
                $periode = Periode::where('status', '1')->firstOrFail();
                $produkPinjaman = ProdukPinjaman::findOrFail($validated['produk_pinjaman_id']);

                $transaksiHarian = new TransaksiHarian();
                $transaksiHarian->tgl = Tanggal::convert_tanggal($request->tgl);
                $transaksiHarian->divisi_id = '2';
                $transaksiHarian->jenis_pembayaran = $request->jenis_pembayaran;
                $transaksiHarian->jenis_transaksi = '2';
                $transaksiHarian->keterangan = $request->keterangan;
                $transaksiHarian->periode_id = $periode->id;
                $transaksiHarian->save();

                $transaksiHarianAnggota = new TransaksiHarianAnggota();
                $transaksiHarianAnggota->transaksi_harian_id = $transaksiHarian->id;
                $transaksiHarianAnggota->anggota_id = $request->anggota_id;
                $transaksiHarianAnggota->save();

                $transaksiBiaya = new TransaksiHarianBiaya();
                $transaksiBiaya->biaya_id = '8';
                $transaksiBiaya->transaksi_harian_id = $transaksiHarian->id;
                $transaksiBiaya->nominal = $validated['nominal_amount'];
                $transaksiBiaya->save();

                $transaksiPinjaman = new TransaksiPinjaman();
                $transaksiPinjaman->transaksi_harian_biaya_id = $transaksiBiaya->id;
                $transaksiPinjaman->lama_cicilan = $validated['lama_cicilan'];
                $this->saveProductSnapshot($transaksiPinjaman, $produkPinjaman);
                $transaksiPinjaman->save();
            });

            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Berhasil Menambah Data Transaksi !!!"
            ]);
            activity()->log('Menambahkan Data Pinjaman Kredit');
            return redirect()->route('pinjaman-kredit.index');
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
        if (\Auth::user()->can('edit-kredit-pinjaman')) {
            # code...
            $transaksiHarian = TransaksiHarian::with('transaksi_harian_anggota')->findOrFail($id);
            $transaksi_biaya = TransaksiHarianBiaya::where('transaksi_harian_id', $id)
                ->where('biaya_id', '8')
                ->firstOrFail();
            $transaksiPinjaman = TransaksiPinjaman::where('transaksi_harian_biaya_id', $transaksi_biaya->id)->first();
            $transaksiHarian->nominal = Money::stringToRupiah($transaksi_biaya->nominal);
            $transaksiHarian->tgl = date('d-m-Y', strtotime($transaksiHarian->tgl));
            $transaksiHarian->anggota_id = $transaksiHarian->transaksi_harian_anggota->anggota_id;
            $transaksiHarian->produk_pinjaman_id = $transaksiPinjaman ? $transaksiPinjaman->produk_pinjaman_id : null;
            $transaksiHarian->lama_cicilan = $transaksiPinjaman ? $transaksiPinjaman->lama_cicilan : null;
            $produkPinjaman = $this->productsForForm(
                $transaksiHarian->produk_pinjaman_id,
                $transaksiHarian->lama_cicilan
            );
            return view('pinjaman-kredit.edit')->with(compact('transaksiHarian', 'produkPinjaman'));
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
        if (\Auth::user()->can('edit-kredit-pinjaman')) {
            # code...
            $transaksiHarian = TransaksiHarian::findOrFail($id);
            $transaksiBiaya = TransaksiHarianBiaya::where('transaksi_harian_id', $id)
                ->where('biaya_id', '8')
                ->firstOrFail();
            $transaksiPinjaman = TransaksiPinjaman::where('transaksi_harian_biaya_id', $transaksiBiaya->id)->first();
            $validated = $this->validateTransaction($request, $transaksiPinjaman, $transaksiBiaya->nominal);
            $this->validate($request, [
                'tgl' => 'required',
                'divisi_id' => 'required',
                'jenis_transaksi' => 'required'
            ]);
            if ($transaksiPinjaman && TransaksiPinjamanCicilan::where(
                'transaksi_pinjaman_id',
                $transaksiPinjaman->id
            )->exists()) {
                $requestedDate = Tanggal::convert_tanggal($request->tgl);
                if ((int) $validated['lama_cicilan'] !== (int) $transaksiPinjaman->lama_cicilan
                    || (int) $validated['produk_pinjaman_id'] !== (int) $transaksiPinjaman->produk_pinjaman_id
                    || date('Y-m-d', strtotime($requestedDate)) !== date('Y-m-d', strtotime($transaksiHarian->tgl))) {
                    throw ValidationException::withMessages([
                        'lama_cicilan' => 'Produk, tenor, dan tanggal pinjaman tidak dapat diubah setelah pembayaran cicilan dicatat.',
                    ]);
                }
            }

            DB::transaction(function () use ($request, $id, $validated, $transaksiHarian, $transaksiBiaya, $transaksiPinjaman) {
                $produkPinjaman = ProdukPinjaman::findOrFail($validated['produk_pinjaman_id']);

                $transaksiHarian->tgl = Tanggal::convert_tanggal($request->tgl);
                $transaksiHarian->jenis_pembayaran = $request->jenis_pembayaran;
                $transaksiHarian->keterangan = $request->keterangan;
                $transaksiHarian->save();

                $transaksiHarianAnggota = TransaksiHarianAnggota::where('transaksi_harian_id', $id)->firstOrFail();
                $transaksiHarianAnggota->anggota_id = $request->anggota_id;
                $transaksiHarianAnggota->save();

                $transaksiBiaya->nominal = $validated['nominal_amount'];
                $transaksiBiaya->save();

                $transaksiPinjaman = $transaksiPinjaman ?: new TransaksiPinjaman();
                $transaksiPinjaman->transaksi_harian_biaya_id = $transaksiBiaya->id;
                $transaksiPinjaman->lama_cicilan = $validated['lama_cicilan'];
                $this->saveProductSnapshot($transaksiPinjaman, $produkPinjaman);
                $transaksiPinjaman->save();
            });

            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Berhasil Merubah Data Transaksi !!!"
            ]);
            activity()->log('Merubah Data Pinjaman Kredit');
            return redirect()->route('pinjaman-kredit.index');
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    private function validateTransaction(Request $request, $currentLoan = null, $currentAmount = null)
    {
        $validated = $this->validate($request, [
            'anggota_id' => 'required|exists:anggotas,id',
            'nominal' => 'required|string',
            'produk_pinjaman_id' => 'required|integer|exists:produk_pinjaman,id',
            'lama_cicilan' => 'required|integer|min:1|max:600',
        ]);

        $product = ProdukPinjaman::with('tenors')
            ->findOrFail($validated['produk_pinjaman_id']);
        $isActiveTenor = $product->tenors->contains(function ($tenor) use ($validated) {
            return $tenor->is_active && (int) $tenor->lama_cicilan === (int) $validated['lama_cicilan'];
        });
        $isUnchangedLegacyOption = $currentLoan
            && (int) $currentLoan->produk_pinjaman_id === (int) $product->id
            && (int) $currentLoan->lama_cicilan === (int) $validated['lama_cicilan'];

        if ((!$product->is_active || !$isActiveTenor) && !$isUnchangedLegacyOption) {
            throw ValidationException::withMessages([
                'lama_cicilan' => 'Tenor tersebut tidak aktif untuk produk pinjaman yang dipilih.',
            ]);
        }

        if (!$product->nominal && !$isUnchangedLegacyOption) {
            throw ValidationException::withMessages([
                'produk_pinjaman_id' => 'Nominal produk belum diatur. Lengkapi nominal produk sebelum transaksi.',
            ]);
        }

        $submittedAmount = (int) preg_replace('/\D/', '', $validated['nominal']);
        $amount = $isUnchangedLegacyOption
            ? (int) $currentAmount
            : (int) $product->nominal;
        if ($amount <= 0 && $isUnchangedLegacyOption) {
            $amount = $submittedAmount;
        }
        if ($amount <= 0) {
            throw ValidationException::withMessages([
                'nominal' => 'Jumlah pinjaman harus lebih besar dari Rp 0.',
            ]);
        }
        $validated['nominal_amount'] = $amount;

        return $validated;
    }

    private function saveProductSnapshot(TransaksiPinjaman $loan, ProdukPinjaman $product)
    {
        $loan->produk_pinjaman_id = $product->id;
        $loan->produk_pinjaman_nama = $product->name;
        $loan->bunga_persen = 1;
        $loan->tabungan_persen = 0.5;
    }

    private function productsForForm($selectedProductId = null, $selectedMonths = null)
    {
        $products = ProdukPinjaman::with(['tenors' => function ($query) {
            $query->where('is_active', true)->orderBy('lama_cicilan');
        }])
            ->where(function ($query) use ($selectedProductId) {
                $query->where(function ($activeProducts) {
                    $activeProducts->where('is_active', true)
                        ->whereNotNull('nominal')
                        ->where('nominal', '>', 0);
                });
                if ($selectedProductId) {
                    $query->orWhere('id', $selectedProductId);
                }
            })
            ->orderBy('name')
            ->get();

        if ($selectedProductId && $selectedMonths) {
            $selectedProduct = $products->firstWhere('id', (int) $selectedProductId);
            if ($selectedProduct && !$selectedProduct->tenors->contains('lama_cicilan', (int) $selectedMonths)) {
                $selectedProduct->tenors->push(new ProdukPinjamanTenor([
                    'lama_cicilan' => (int) $selectedMonths,
                    'is_active' => false,
                ]));
            }
        }

        return $products;
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
        //
        $biaya_id = TransaksiHarianBiaya::where('transaksi_harian_id', $id)->firstOrFail();
        $loan = TransaksiPinjaman::where('transaksi_harian_biaya_id', $biaya_id->id)->first();
        if ($loan && TransaksiPinjamanCicilan::where('transaksi_pinjaman_id', $loan->id)->exists()) {
            return redirect()->route('pinjaman-kredit.index')
                ->with('error', 'Pinjaman tidak dapat dihapus karena sudah memiliki pembayaran cicilan.');
        }
        TransaksiHarianAnggota::where('transaksi_harian_id', $id)->delete();
        TransaksiPinjaman::where('transaksi_harian_biaya_id', $biaya_id->id)->delete();
        TransaksiHarianBiaya::where('transaksi_harian_id', $id)->delete();
        TransaksiHarian::find($id)->delete();
        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Berhasil Menghapus Transaksi !!!"
        ]);
        activity()->log('Menghapus Data Pinjaman Kredit');
        return redirect()->route('pinjaman-kredit.index');
    }

    public function upload()
    {
        abort_unless(!\Auth::user()->hasMemberRole(), 403);
        if (\Auth::user()->can('upload-kredit-pinjaman')) {
            # code...
            return view('pinjaman-kredit.upload');
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function downloadTemplate()
    {
        abort_unless(\Auth::user()->can('download-kredit-pinjaman'), 403);

        return Excel::download(new PinjamanKreditTemplate(), 'template-pinjaman-kredit.xlsx');
    }

    public function doUpload(Request $request)
    {
        abort_unless(!\Auth::user()->hasMemberRole(), 403);
        $this->validate($request, [
			'file' => 'required'
		]);
        $periode = Periode::where('status', '1')->first();

        // import data

        try{
            Excel::import(new PinjamanKredit($periode), request()->file('file'));
            activity()->log('Upload Data Pinjaman Kredit');
            return redirect()->route('pinjaman-kredit.index')->with('success', __('Data Pinjaman Kredit Telah Sukses Di Tambahkan'));
        }catch(\Maatwebsite\Excel\Validators\ValidationException $e){
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                foreach($failure->errors() as $key)
                {
                    return redirect()->route('pinjaman-kredit.index')->with('error', $key);
                }
                $failure->values(); // The values of the row that has failed.
            }
        }
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
            $transaksiHarian->jenis_transaksi = '2';
            $transaksiHarian->keterangan = 'Saldo Awal Periode ' . $periode->name;
            $transaksiHarian->periode_id = $periode->id;
            $transaksiHarian->save();
            //SUMP SIMPANAN KREDIT
            $sum_pinjaman = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                ->whereBetween('transaksi_harians.tgl', [$want_close->open_date, $want_close->close_date])
                ->where('transaksi_harian_anggotas.anggota_id', $row->id)
                ->where('transaksi_harian_biayas.biaya_id', '8')
                ->where('divisi_id', '2')
                ->sum('transaksi_harian_biayas.nominal');
            //Store Saldo Pinjaman
            $transaksi_biaya = new TransaksiHarianBiaya();
            $transaksi_biaya->biaya_id = '8';
            $transaksi_biaya->transaksi_harian_id = $transaksiHarian->id;
            $transaksi_biaya->nominal = $sum_pinjaman;
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
                ->where('transaksi_harian_biayas.biaya_id', '8')
                ->select('transaksi_harians.id as id')
                ->get();

            foreach ($transaksi_harian as $item) {
                $transaksi_harian = TransaksiHarian::find($item->id);
                $transaksi_harian->is_close = '1';
                $transaksi_harian->update();
            }
        }
        activity()->log('Tutup Buku Data Pinjaman Kredit');
        return redirect()->route('pinjaman-kredit.index');
    }
}
