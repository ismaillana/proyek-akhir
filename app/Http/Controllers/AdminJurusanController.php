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
            $image = User::saveImage($request);

            $user = User::create([
                'name'        => $request->name,
                'nomor_induk' => $request->nomor_induk,
                'email'       => $request->email,
                'wa'          => 62 . $request->wa,
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
    public function update(AdminJurusanUpdateRequest $request, $id)
    {
        $data = [
            'name'        => $request->name,
            'wa'          => 62 . $request->wa,
            'jurusan_id'        => $request->jurusan_id,
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
