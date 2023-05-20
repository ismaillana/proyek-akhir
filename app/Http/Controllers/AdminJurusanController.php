<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdminJurusan;
use App\Models\Jurusan;

use App\Http\Requests\AdminJurusanRequest;
use App\Http\Requests\AdminJurusanUpdateRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class AdminJurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $adminJurusan = AdminJurusan::get();

        return view ('admin.admin-jurusan.index', [
            'adminJurusan'  => $adminJurusan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusan    =   Jurusan::get();
        
        return view ('admin.admin-jurusan.form', [
            'jurusan'   =>  $jurusan,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminJurusanRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name'        => $request->name,
                'nomor_induk' => $request->nomor_induk,
                'email'       => $request->email,
                'wa'          => 62 . $request->wa,
                'password'    => Hash::make($request->nomor_induk)
            ]);

            $user->assignRole('admin-jurusan');

            $data = [
                'user_id'           => $user->id,
                'nip'               => $user->nomor_induk,
                'jurusan_id'        => $request->jurusan_id,
            ];

            $image = AdminJurusan::saveImage($request);

            $data['image'] = $image;

            $adminJurusan = AdminJurusan::create($data);

            DB::commit();

            return redirect()->route('admin-jurusan.index')->with('success', 'Data Berhasil Ditambah');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $adminJurusan = AdminJurusan::findOrFail($id);
        $jurusan = Jurusan::oldest('name')->get();

        return view ('admin.admin-jurusan.form', [
            'adminJurusan' => $adminJurusan,
            'jurusan'   => $jurusan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminJurusanUpdateRequest $request, AdminJurusan $adminJurusan)
    {
        $data = [
            'nip'               => $request->nomor_induk,
            'jurusan_id'        => $request->jurusan_id,
        ];

        $image = AdminJurusan::saveImage($request);

        if ($image) {
            $data['image'] = $image;

            $param = (object) [
                'type'  => 'image',
                'id'    => $adminJurusan->id
            ];

            AdminJurusan::deleteImage($param);
        }

        AdminJurusan::where('id', $adminJurusan->id)->update($data);

        User::whereId($adminJurusan->user_id)->update([
            'name'        => $request->name,
            'nomor_induk' => $request->nomor_induk,
            'email'       => $request->email,
            'wa'          => 62 . $request->wa,
            // 'password'    => Hash::make($request->nomor_induk)
        ]);
        // return dd($request->all());
        return redirect()->route('admin-jurusan.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $adminJurusan = AdminJurusan::find($id);

        // $resellerOrder =  ResellerOrder::where('reseller_id', $id)
        //     ->whereNotIn('order_status_id', [8, 9])
        //     ->first();

        // if ($resellerOrder) {
        //     return response()->json(['message' => 'Gagal hapus, masih ada transaksi yang berjalan', 'status' => 'error', 'code' => '500']);
        // }

        $param = (object) [
            'type'  => 'image',
            'id'    => $adminJurusan->id
        ];

        AdminJurusan::deleteImage($param);

        // $this->deleteMahasiswa($id);

        $adminJurusan->delete();

        User::where('id', $adminJurusan->user_id)->update(['status' => '0']);

        return response()->json(['status' => 'Data Berhasil Dihapus']);
    }
}
