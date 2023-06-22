<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $bagianAkademik = User::latest()
            ->role('bagian-akademik') 
            ->get();

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
        return view ('admin.bagian-akademik.tambah', [
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
            $image = User::saveImage($request);

            $user = User::create([
                'name'        => $request->name,
                'nomor_induk' => $request->nomor_induk,
                'email'       => $request->email,
                'wa'          => 62 . $request->wa,
                'password'    => Hash::make($request->nomor_induk),
                'image'       => $image
            ]);

            $user->assignRole('bagian-akademik');

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

        $user = User::findOrFail($id);

        return view ('admin.bagian-akademik.detail', [
            'user' => $user,
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

        $bagianAkademik = User::findOrFail($id);

        return view ('admin.bagian-akademik.edit', [
            'bagianAkademik' => $bagianAkademik,
            'title'         => 'Form Edit Bagian Akademik'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BagianAkademikUpdateRequest $request, $id)
    {
        $data = [
            'name'        => $request->name,
            'wa'          => 62 . $request->wa,
            'password'    => Hash::make($request->nomor_induk)
        ];

        $image = User::saveImage($request);

        if ($image) {
            $data['image'] = $image;

            User::deleteImage($id);
        }

        User::where('id', $id)->update($data);

        return redirect()->route('bagianAkademik.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bagianAkademik = User::find($id);

        User::deleteImage($id);

        $bagianAkademik->delete();

        return response()->json(['status' => 'Data Berhasil Dihapus']);
    }
}
