<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jurusan;

use App\Http\Requests\AdminJurusanRequest;
use App\Http\Requests\AdminJurusanUpdateRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;


class AdminJurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $adminJurusan = User::latest()
            ->role('admin-jurusan')
            ->get();

        return view ('admin.admin-jurusan.index', [
            'adminJurusan'  => $adminJurusan,
            'title'         => 'Admin Jurusan'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusan    =   Jurusan::get();
        
        return view ('admin.admin-jurusan.tambah', [
            'jurusan'   =>  $jurusan,
            'title'     => 'Admin Jurusan'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminJurusanRequest $request)
    {
        DB::beginTransaction();

        try {
            $nomorWa = $request->input('wa');
            
            if (substr($nomorWa, 0, 1) === '0') {
                $wa = '62' . substr($nomorWa, 1);
            } else {
                $wa = 62 . $nomorWa;
            }
            
            $image = User::saveImage($request);

            $user = User::create([
                'name'        => $request->name,
                'nomor_induk' => $request->nomor_induk,
                'email'       => $request->email,
                'wa'          => $wa,
                'jurusan_id'  => $request->jurusan_id,
                'password'    => Hash::make($request->nomor_induk),
                'image'       => $image
            ]);

            $user->assignRole('admin-jurusan');
        
            DB::commit();

            return redirect()->route('adminJurusan.index')->with('success', 'Data Berhasil Ditambah');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withError('Admin Jurusan Gagal Ditambah');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            abort(404);
        }

        $adminJurusan = User::findOrFail($id);
        $jurusan = Jurusan::oldest('name')->get();

        return view ('admin.admin-jurusan.detail', [
            'adminJurusan' => $adminJurusan,
            'jurusan'   => $jurusan,
            'title'         => 'Admin Jurusan'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            abort(404);
        }

        $adminJurusan = User::findOrFail($id);
        $jurusan = Jurusan::oldest('name')->get();

        return view ('admin.admin-jurusan.edit', [
            'adminJurusan' => $adminJurusan,
            'jurusan'   => $jurusan,
            'title'         => 'Admin Jurusan'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'              => 'required',
            'email'             => 'required|email|unique:users,email,' . $id,
            'nomor_induk'       => 'required|unique:users,nomor_induk,' .$id,
            'wa'                => 'required',
            'jurusan_id'        => 'required',
        ], [
            'name.required'         => 'Nama Admin Wajib Diisi',
            'email.required'        => 'Email Wajib Diisi',
            'email.email'           => 'Format Email Harus Sesuai',
            'nomor_induk.required'  => 'NIP Wajib Diisi',
            'nomor_induk.unique'    => 'NIP Sudah Ada',
            'wa.required'           => 'No WhatsApp Wajib Diisi',
            'jurusan_id.required'   => 'Jurusan Wajib Diisi',
            'email.unique'          => 'Email Sudah Digunakan'
        ]);

        $nomorWa = $request->input('wa');
            
        if (substr($nomorWa, 0, 1) === '0') {
            $wa = '62' . substr($nomorWa, 1);
        } else {
            $wa = 62 . $nomorWa;
        }

        $data = [
            'name'        => $request->name,
            'nomor_induk' => $request->nomor_induk,
            'email'       => $request->email,
            'wa'          => $wa,
            'jurusan_id'  => $request->jurusan_id,
            'password'    => Hash::make($request->nomor_induk),
        ];

        $image = User::saveImage($request);

        if ($image) {
            $data['image'] = $image;

            User::deleteImage($id);
        }

        User::where('id', $id)->update($data);

        return redirect()->route('adminJurusan.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $adminJurusan = User::find($id);

        User::deleteImage($id);

        $adminJurusan->delete();

        return response()->json(['status' => 'Data Berhasil Dihapus']);
    }
}
