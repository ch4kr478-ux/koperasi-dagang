<?php

namespace App\Http\Controllers;

use App\Biaya;
use App\Exports\BiayaTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;

class BiayaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (\Auth::user()->can('manage-biaya')) {
            if ($request->ajax()) {
                $biaya = Biaya::with('divisi')->select();
                return DataTables::of($biaya)
                    ->editColumn('jenis_biaya', function ($biaya) {
                        if ($biaya->jenis_biaya == '1') {
                            return 'Debet';
                        }

                        if ($biaya->jenis_biaya == '2') {
                            return 'Kredit';
                        }

                        return '-';
                    })
                    ->addColumn('action', function ($biaya) {
                        return view('datatable._action-biaya', [
                            'edit_url' => route('biaya.edit', $biaya->id),
                            'form_url' => route('biaya.destroy', $biaya->id),
                            'confirm_message' => 'Yakin ingin menghapus biaya ini?'
                        ]);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('biaya.index');
        } else {
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
        //
        if (\Auth::user()->can('create-biaya')) {
            return view('biaya.create');
        } else {
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
        //
        if (\Auth::user()->can('create-biaya')) {
            $this->validate($request, [
                'name' => 'required|string|max:255|unique:biayas,name',
                'divisi_id' => 'required|exists:divisis,id',
                'jenis_biaya' => 'required|in:1,2'
            ]);
            Biaya::create($request->only('name', 'divisi_id', 'jenis_biaya'));

            return redirect()->route('biaya.index')->with('success', 'Data biaya berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function show(Biaya $biaya)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function edit(Biaya $biaya)
    {
        if (\Auth::user()->can('manage-biaya')) {
            return view('biaya.edit', compact('biaya'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Biaya $biaya)
    {
        if (\Auth::user()->can('manage-biaya')) {
            $validated = $this->validate($request, [
                'name' => 'required|string|max:255|unique:biayas,name,' . $biaya->id,
                'divisi_id' => 'required|exists:divisis,id',
                'jenis_biaya' => 'required|in:1,2'
            ]);

            $biaya->update($validated);
            return redirect()->route('biaya.index')->with('success', 'Data biaya berhasil diubah.');
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function destroy(Biaya $biaya)
    {
        if (!\Auth::user()->can('manage-biaya')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        if ($biaya->id <= 8) {
            return redirect()->route('biaya.index')
                ->with('error', 'Biaya standar sistem tidak dapat dihapus karena digunakan oleh modul transaksi.');
        }

        if (DB::table('transaksi_harian_biayas')->where('biaya_id', $biaya->id)->exists()) {
            return redirect()->route('biaya.index')
                ->with('error', 'Biaya tidak dapat dihapus karena sudah digunakan pada transaksi.');
        }

        $biaya->delete();
        return redirect()->route('biaya.index')->with('success', 'Data biaya berhasil dihapus.');
    }

    public function downloadTemplate()
    {
        if (!\Auth::user()->can('manage-biaya')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return Excel::download(new BiayaTemplate(), 'template-biaya.xlsx');
    }

    public function checkBiayaDebet($divisi)
    {
        $biaya = Biaya::select()->where('divisi_id', $divisi)
            ->where('jenis_biaya', '1')
            ->first();
        return response()->json($biaya);
    }

    public function checkBiayaKredit($divisi)
    {
        $biaya = Biaya::select()->where('divisi_id', $divisi)
            ->where('jenis_biaya', '2')
            ->first();
        return response()->json($biaya);
    }
}
