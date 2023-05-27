<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\koorPkl;
use App\Models\Jurusan;

use App\Http\Requests\KoorPklRequest;
use App\Http\Requests\KoorPklUpdateRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class KoorPKLController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $koorPkl = KoorPkl::get();

        return view ('admin.koor-pkl.index', [
            'koorPkl'  => $koorPkl,
            'title'    => 'Koor-Pkl'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusan    =   Jurusan::get();
        
        return view ('admin.koor-pkl.form', [
            'jurusan'   =>  $jurusan,
            'title'    => 'Koor-Pkl'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KoorPklRequest $request)
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

            $user->assignRole('koor-pkl');

            $data = [
                'user_id'           => $user->id,
                'nip'               => $user->nomor_induk,
                'jurusan_id'        => $request->jurusan_id,
            ];

            $image = KoorPkl::saveImage($request);

            $data['image'] = $image;

            $koorPkl = KoorPkl::create($data);

            DB::commit();

            return redirect()->route('koorPkl.index')->with('success', 'Data Berhasil Ditambah');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withError('Koordinator PKL Gagal Ditambah');
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

        $koorPkl = KoorPkl::findOrFail($id);
        $jurusan = Jurusan::oldest('name')->get();

        return view ('admin.koor-pkl.form', [
            'koorPkl' => $koorPkl,
            'jurusan'   => $jurusan,
            'title'    => 'Koor-Pkl'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KoorPKLUpdateRequest $request, KoorPkl $koorPkl)
    {
        
        $data = [
            'nip'               => $request->nomor_induk,
            'jurusan_id'        => $request->jurusan_id,
        ];
        
        $image = KoorPkl::saveImage($request);
        
        if ($image) {
            $data['image'] = $image;

            KoorPkl::deleteImage($koorPkl);
        }

        KoorPkl::where('id', $koorPkl->id)->update($data);

        User::whereId($koorPkl->user_id)->update([
            'name'        => $request->name,
            'nomor_induk' => $request->nomor_induk,
            'email'       => $request->email,
            'wa'          => 62 . $request->wa,
            // 'password'    => Hash::make($request->nomor_induk)
        ]);
        // return dd($request->all());
        return redirect()->route('koorPkl.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $koorPkl = KoorPkl::find($id);

        // $resellerOrder =  ResellerOrder::where('reseller_id', $id)
        //     ->whereNotIn('order_status_id', [8, 9])
        //     ->first();

        // if ($resellerOrder) {
        //     return response()->json(['message' => 'Gagal hapus, masih ada transaksi yang berjalan', 'status' => 'error', 'code' => '500']);
        // }

        $param = (object) [
            'type'  => 'image',
            'id'    => $koorPkl->id
        ];

        KoorPkl::deleteImage($param);

        // $this->deleteMahasiswa($id);

        $koorPkl->delete();

        User::where('id', $koorPkl->user_id)->update(['status' => '0']);

        return response()->json(['status' => 'Data Berhasil Dihapus']);
    }
}
