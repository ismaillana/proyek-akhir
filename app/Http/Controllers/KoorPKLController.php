<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\koorPkl;
use App\Models\Jurusan;

use App\Http\Requests\KoorPKLRequest;
use App\Http\Requests\KoorPKLUpdateRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class KoorPKLController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $koorPKL = koorPkl::get();

        return view ('admin.koor-pkl.index', [
            'koorPKL'  => $koorPKL
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
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KoorPKLRequest $request)
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

            $image = koorPkl::saveImage($request);

            $data['image'] = $image;

            $koorPKL = koorPkl::create($data);

            DB::commit();

            return redirect()->route('koor-pkl.index')->with('success', 'Data Berhasil Ditambah');
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
        $koorPKL = koorPkl::findOrFail($id);
        $jurusan = Jurusan::oldest('name')->get();

        return view ('admin.koor-pkl.form', [
            'koorPKL' => $koorPKL,
            'jurusan'   => $jurusan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KoorPKLUpdateRequest $request, koorPkl $koorPKL)
    {
        $data = [
            'nip'               => $request->nomor_induk,
            'jurusan_id'        => $request->jurusan_id,
            'image'             => $request->image
        ];

        $image = koorPkl::saveImage($request);

        if ($image) {
            $data['image'] = $image;

            // $param = (object) [
            //     'type'  => 'image',
            //     'id'    => $koorPKL->id
            // ];

            KoorPkl::deleteImage($koorPKL);
        }

        koorPkl::where('id', $koorPKL->id)->update($data);

        User::whereId($koorPKL->user_id)->update([
            'name'        => $request->name,
            'nomor_induk' => $request->nomor_induk,
            'email'       => $request->email,
            'wa'          => 62 . $request->wa,
            // 'password'    => Hash::make($request->nomor_induk)
        ]);
        // return dd($request->all());
        return redirect()->route('koor-pkl.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $koorPKL = KoorPkl::find($id);

        // $resellerOrder =  ResellerOrder::where('reseller_id', $id)
        //     ->whereNotIn('order_status_id', [8, 9])
        //     ->first();

        // if ($resellerOrder) {
        //     return response()->json(['message' => 'Gagal hapus, masih ada transaksi yang berjalan', 'status' => 'error', 'code' => '500']);
        // }

        $param = (object) [
            'type'  => 'image',
            'id'    => $koorPKL->id
        ];

        KoorPkl::deleteImage($param);

        // $this->deleteMahasiswa($id);

        $koorPKL->delete();

        User::where('id', $koorPKL->user_id)->update(['status' => '0']);

        return response()->json(['status' => 'Data Berhasil Dihapus']);
    }
}
