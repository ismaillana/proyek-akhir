<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\BagianAkademik;
use App\Models\User;

use App\Http\Requests\BagianAkademikRequest;
use App\Http\Requests\BagianAkademikUpdateRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class BagianAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bagianAkademik = BagianAkademik::get();

        return view ('admin.bagian-akademik.index', [
            'bagianAkademik'  => $bagianAkademik,
            'title'         => 'Bagian Akademik'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('admin.bagian-akademik.form', [
            'title'     => 'Form Tambah Bagian Akademik'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BagianAkademikRequest $request)
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

            $user->assignRole('bagian-akademik');

            $data = [
                'user_id'           => $user->id,
                'name'              => $user->name,
                'nip'               => $user->nomor_induk,
            ];
            
            $image = BagianAkademik::saveImage($request);

            $data['image'] = $image;

            $bagianAkademik = BagianAkademik::create($data);

            DB::commit();

            return redirect()->route('bagianAkademik.index')->with('success', 'Data Berhasil Ditambah');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withError('Bagian Akademik Gagal Ditambah');
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

        $bagianAkademik = BagianAkademik::findOrFail($id);

        return view ('admin.bagian-akademik.detail', [
            'bagianAkademik' => $bagianAkademik,
            'title'         => 'Detail Bagian Akademik'
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

        $bagianAkademik = BagianAkademik::findOrFail($id);

        return view ('admin.bagian-akademik.form', [
            'bagianAkademik' => $bagianAkademik,
            'title'         => 'Form Edit Bagian Akademik'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BagianAkademikUpdateRequest $request, BagianAkademik $bagianAkademik)
    {
        $data = [
            'nip'               => $request->nomor_induk,
            'name'               => $request->name,
        ];

        $image = BagianAkademik::saveImage($request);

        if ($image) {
            $data['image'] = $image;

            $param = (object) [
                'type'  => 'image',
                'id'    => $bagianAkademik->id
            ];

            BagianAkademik::deleteImage($param);
        }

        BagianAkademik::where('id', $bagianAkademik->id)->update($data);
        
        User::whereId($bagianAkademik->user_id)->update([
            'name'        => $request->name,
            'nomor_induk' => $request->nomor_induk,
            'email'       => $request->email,
            'wa'          => 62 . $request->wa,
            // 'password'    => Hash::make($request->nomor_induk)
        ]);

        return redirect()->route('bagianAkademik.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bagianAkademik = BagianAkademik::find($id);

        $param = (object) [
            'type'  => 'image',
            'id'    => $bagianAkademik->id
        ];

        BagianAkademik::deleteImage($param);

        $bagianAkademik->delete();

        User::where('id', $bagianAkademik->user_id)->update(['status' => '0']);

        return response()->json(['status' => 'Data Berhasil Dihapus']);
    }
}
