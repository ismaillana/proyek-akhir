<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Instansi;

use App\Http\Requests\InstansiRequest;
use App\Http\Requests\InstansiUpdateRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;


class InstansiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instansi = Instansi::get();

        return view ('admin.instansi.index', [
            'instansi' => $instansi,
            'title'    => 'Instansi'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('admin.instansi.form', [
            'title'    => 'Instansi'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InstansiRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name'        => $request->name,
                'email'       => $request->email,
                'wa'          => 62 . $request->wa,
                'password'    => Hash::make('123456')
            ]);

            $user->assignRole('instansi');

            $data = [
                'user_id'           => $user->id,
                'nama_perusahaan'   => $user->name,
                'alamat'            => $request->alamat,
            ];

            $image = Instansi::saveImage($request);

            $data['image'] = $image;

            $instansi = Instansi::create($data);

            DB::commit();

            return redirect()->route('instansi.index')->with('success', 'Data Berhasil Ditambah');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withError('Instansi Gagal Ditambah');
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
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            abort(404);
        }

        $instansi = Instansi::find($id);

        return view ('admin.instansi.form', [
            'instansi'  => $instansi,
            'title'    => 'Instansi'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InstansiUpdateRequest $request, Instansi $instansi)
    {
        $data = [
            'nama_perusahaan'   => $request->name,
            'alamat'            => $request->alamat,
        ];

        $image = Instansi::saveImage($request);

        if ($image) {
            $data['image'] = $image;

            $param = (object) [
                'type'  => 'image',
                'id'    => $instansi->id
            ];

            Instansi::deleteImage($param);
        }

        Instansi::where('id', $instansi->id)->update($data);

        User::whereId($instansi->user_id)->update([
            'name'        => $request->name,
            'email'       => $request->email,
            'wa'          => 62 . $request->wa,
            // 'password'    => Hash::make($request->nomor_induk)
        ]);

        return redirect()->route('instansi.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $instansi = Instansi::find($id);

        // $resellerOrder =  ResellerOrder::where('reseller_id', $id)
        //     ->whereNotIn('order_status_id', [8, 9])
        //     ->first();

        // if ($resellerOrder) {
        //     return response()->json(['message' => 'Gagal hapus, masih ada transaksi yang berjalan', 'status' => 'error', 'code' => '500']);
        // }

        $param = (object) [
            'type'  => 'image',
            'id'    => $instansi->id
        ];

        Instansi::deleteImage($param);

        // $this->deleteinstansi($id);

        $instansi->delete();

        User::where('id', $instansi->user_id)->update(['status' => '0']);

        return response()->json(['status' => 'Data Berhasil Dihapus']);
    }
}
