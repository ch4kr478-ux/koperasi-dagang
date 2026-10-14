<?php

namespace App\Http\Controllers;

use App\ProdukPinjaman;
use App\TransaksiPinjaman;
use App\Exports\ProdukPinjamanTemplate;
use App\Imports\ProdukPinjamanImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;

class ProdukPinjamanController extends Controller
{
    public function downloadTemplate()
    {
        abort_unless(Auth::user()->can('download-produk-pinjaman'), 403);

        return Excel::download(new ProdukPinjamanTemplate(), 'template-produk-pinjaman.xlsx');
    }

    public function upload()
    {
        abort_unless(Auth::user()->can('upload-produk-pinjaman'), 403);

        return view('produk-pinjaman.upload');
    }

    public function doUpload(Request $request)
    {
        abort_unless(Auth::user()->can('upload-produk-pinjaman'), 403);

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {
            DB::transaction(function () use ($request) {
                Excel::import(new ProdukPinjamanImport(), $request->file('file'));
            });
        } catch (ExcelValidationException $exception) {
            $errors = [];
            foreach ($exception->failures() as $failure) {
                foreach ($failure->errors() as $error) {
                    $errors[] = $error;
                }
            }

            return back()->withErrors($errors)->withInput();
        }

        activity()->log('Upload Data Produk Pinjaman');

        return redirect()->route('produk-pinjaman.index')
            ->with('success', 'Produk pinjaman berhasil diimpor.');
    }

    public function index()
    {
        abort_unless(Auth::user()->can('manage-produk-pinjaman'), 403);

        $produkPinjaman = ProdukPinjaman::with('tenors')
            ->orderBy('name')
            ->paginate(15);

        return view('produk-pinjaman.index', compact('produkPinjaman'));
    }

    public function create()
    {
        abort_unless(Auth::user()->can('create-produk-pinjaman'), 403);

        return view('produk-pinjaman.create');
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->can('create-produk-pinjaman'), 403);
        $validated = $this->validateProduct($request);

        DB::transaction(function () use ($validated) {
            $product = ProdukPinjaman::create([
                'name' => $validated['name'],
                'nominal' => $validated['nominal'],
                'description' => $validated['description'] ?? null,
                'is_active' => isset($validated['is_active']),
            ]);

            foreach ($validated['tenors'] as $months) {
                $product->tenors()->create([
                    'lama_cicilan' => $months,
                    'is_active' => true,
                ]);
            }
        });

        return redirect()->route('produk-pinjaman.index')
            ->with('success', 'Produk pinjaman berhasil ditambahkan.');
    }

    public function edit($id)
    {
        abort_unless(Auth::user()->can('edit-produk-pinjaman'), 403);

        $produkPinjaman = ProdukPinjaman::with('tenors')->findOrFail($id);

        return view('produk-pinjaman.edit', compact('produkPinjaman'));
    }

    public function update(Request $request, $id)
    {
        abort_unless(Auth::user()->can('edit-produk-pinjaman'), 403);
        $validated = $this->validateProduct($request, $id);
        $product = ProdukPinjaman::with('tenors')->findOrFail($id);

        DB::transaction(function () use ($product, $validated) {
            $product->update([
                'name' => $validated['name'],
                'nominal' => $validated['nominal'],
                'description' => $validated['description'] ?? null,
                'is_active' => isset($validated['is_active']),
            ]);

            $months = array_map('intval', $validated['tenors']);
            $product->tenors()->whereNotIn('lama_cicilan', $months)->delete();

            foreach ($months as $month) {
                $product->tenors()->updateOrCreate(
                    ['lama_cicilan' => $month],
                    ['is_active' => true]
                );
            }
        });

        return redirect()->route('produk-pinjaman.index')
            ->with('success', 'Produk pinjaman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        abort_unless(Auth::user()->can('delete-produk-pinjaman'), 403);

        $product = ProdukPinjaman::findOrFail($id);
        if (TransaksiPinjaman::where('produk_pinjaman_id', $product->id)->exists()) {
            return redirect()->route('produk-pinjaman.index')
                ->with('error', 'Produk tidak dapat dihapus karena sudah digunakan dalam transaksi. Nonaktifkan produk sebagai gantinya.');
        }

        $product->delete();

        return redirect()->route('produk-pinjaman.index')
            ->with('success', 'Produk pinjaman berhasil dihapus.');
    }

    private function validateProduct(Request $request, $id = null)
    {
        $tenors = preg_split('/[,;\s]+/', trim((string) $request->input('tenor_list')), -1, PREG_SPLIT_NO_EMPTY);
        $request->merge(['tenors' => $tenors]);

        return $this->validate($request, [
            'name' => 'required|string|max:255|unique:produk_pinjaman,name' . ($id ? ',' . $id : ''),
            'nominal' => 'required|integer|min:1|max:999999999999999999',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'tenors' => 'required|array|min:1',
            'tenors.*' => 'required|integer|min:1|max:600|distinct',
        ]);
    }
}
