<?php

namespace App\Http\Controllers;

use App\Anggota;
use Illuminate\Http\Request;
use DataTables;
use Tanggal;
use App\User;
use Illuminate\Support\Facades\DB;
use App\UserAnggota;
use App\Periode;
use App\Exports\AnggotaExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Illuminate\Support\Facades\Auth;


class AnggotaController extends Controller
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
        //
        if (\Auth::user()->can('manage-anggota')) {
            if ($request->ajax()) {
                $periode = Periode::select()->where('status', 1)->first();
                $anggota = Anggota::select();
                return DataTables::of($anggota)
                    ->editColumn('status', function ($anggota) {
                        if ($anggota->status == '0') {
                            return '<span class="badge badge-danger badge-pill">Non Aktif</span>';
                        } else {
                            return '<span class="badge badge-gradient badge-pill">Aktif</span>';
                        }
                    })
                    ->editColumn('tgl_daftar', function ($anggota) {
                        return Tanggal::tanggal_id($anggota->tgl_daftar);
                    })
                    ->addColumn('action', function ($anggota) {
                        return view('datatable._action-anggota', [
                            'edit_url' => route('anggota.edit', $anggota->id),
                            'form_url' => route('anggota.destroy', $anggota->id),
                            'can_edit' => 'edit-anggota',
                            'can_delete' => 'delete-anggota',
                            'confirm_message' => 'Yakin ingin menghapus anggota ' . $anggota->nama . '? Akun login terkait akan dihapus jika hanya digunakan untuk member.'
                        ]);
                    })
                    ->editColumn('is_close', function ($anggota) {
                        if ($anggota->status == '0') {
                            return 'Status Tidak Aktif';
                        }
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            }
            return view('anggota.index');
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
        if (\Auth::user()->can('create-anggota')) {

            return view('anggota.create');
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
        if (\Auth::user()->can('create-anggota')) {
            $this->validate($request, [
                'nik' => 'required|unique:anggotas',
                'nama' => 'required',
                'jabatan' => 'required',
                'status' => 'required',
                'tgl_daftar' => 'required',
                'homebase' => 'required'
            ]);
            $anggota = new Anggota();
            $anggota->nik = $request->nik;
            $anggota->nama = $request->nama;
            $anggota->jabatan = $request->jabatan;
            $anggota->tgl_daftar = Tanggal::convert_tanggal($request->tgl_daftar);
            $anggota->status = $request->status;
            $anggota->homebase = $request->homebase;
            $anggota->save();

            $user = new User();
            $user->email = $request->nik;
            $user->password = bcrypt('Kopkar2019');
            $user->name = $request->nama;
            $user->save();

            DB::table('role_user')->insert([
                'user_id' => $user->id,
                'role_id' => '2',
                'user_type' => 'App\User'
            ]);

            $userAnggota = new UserAnggota();
            $userAnggota->anggota_id = $anggota->id;
            $userAnggota->user_id = $user->id;
            $userAnggota->save();
            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Data Berhasil ditambah !!!"
            ]);
            return redirect()->route('anggota.index');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function show(Anggota $anggota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Auth::user()->can('edit-anggota')) {
            $anggota = Anggota::find($id);
            $anggota->tgl_daftar = date('d-m-Y', strtotime($anggota->tgl_daftar));
            return view('anggota.edit')->with(compact('anggota'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit-anggota')) {
            $this->validate($request, [
                'nik' => 'required|unique:anggotas,nik,' . $id,
                'nama' => 'required',
                'jabatan' => 'required',
                'status' => 'required',
                'tgl_daftar' => 'required',
                'homebase' => 'required'
            ]);
            $anggota = Anggota::find($id);
            $anggota->nik = $request->nik;
            $anggota->nama = $request->nama;
            $anggota->jabatan = $request->jabatan;
            $anggota->status = $request->status;
            $anggota->tgl_daftar = Tanggal::convert_tanggal($request->tgl_daftar);
            $anggota->homebase = $request->homebase;
            $anggota->update();

            $userAnggota = UserAnggota::where('anggota_id', $id)->first();

            $user = User::find($userAnggota->user_id);
            $user->email = $request->nik;
            $user->name = $request->nama;
            $user->save();
            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Data Berhasil diubah !!!"
            ]);
            return redirect()->route('anggota.index');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Anggota $anggota)
    {
        abort_unless(Auth::user()->can('delete-anggota'), 403);

        $deleted = DB::transaction(function () use ($anggota) {
            $lockedAnggota = Anggota::whereKey($anggota->id)->lockForUpdate()->firstOrFail();
            $hasTransactions = DB::table('transaksi_harian_anggotas')
                ->where('anggota_id', $lockedAnggota->id)
                ->exists();
            $hasLoanApplications = DB::table('pengajuan_pinjaman_kredit')
                ->where('anggota_id', $lockedAnggota->id)
                ->exists();

            if ($hasTransactions || $hasLoanApplications) {
                return false;
            }

            $userAnggota = UserAnggota::where('anggota_id', $lockedAnggota->id)->first();
            $linkedUser = $userAnggota ? User::find($userAnggota->user_id) : null;

            if ($linkedUser) {
                $memberRole = $linkedUser->roles()->whereRaw('LOWER(name) = ?', ['member'])->first();
                if ($memberRole && $linkedUser->roles()->count() === 1) {
                    DB::table('permission_user')->where('user_id', $linkedUser->id)->delete();
                    DB::table('role_user')->where('user_id', $linkedUser->id)->delete();
                    $linkedUser->delete();
                } elseif ($memberRole) {
                    DB::table('role_user')
                        ->where('user_id', $linkedUser->id)
                        ->where('role_id', $memberRole->id)
                        ->delete();
                }
            }

            UserAnggota::where('anggota_id', $lockedAnggota->id)->delete();
            $lockedAnggota->delete();

            return true;
        });

        if (!$deleted) {
            Session::flash('flash_notification', [
                'level' => 'warning',
                'message' => 'Anggota tidak dapat dihapus karena memiliki riwayat transaksi atau pengajuan pinjaman. Ubah status anggota menjadi Non Aktif jika tidak lagi digunakan.'
            ]);

            return redirect()->route('anggota.index');
        }

        Session::flash('flash_notification', [
            'level' => 'success',
            'message' => 'Data anggota berhasil dihapus.'
        ]);

        return redirect()->route('anggota.index');
    }

    public function export()
    {
        $anggota = Anggota::select()->get();
        activity()->log('Mendowload Data Anggota');
        return Excel::download(new AnggotaExport($anggota), 'Anggota-Koperasi.xlsx');
    }
}
