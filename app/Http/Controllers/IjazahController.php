<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Ijazah;
use App\Models\User;

use App\Http\Requests\IjazahRequest;

class IjazahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ijazah = Ijazah::get();
        return view ('admin.ijazah.index',[
            'ijazah' => $ijazah
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alumni = Mahasiswa::where('status', 'Alumni')
        ->get();
        // $user = User::where($alumni)->get();
        // $user = User::get();
        

        return view ('admin.ijazah.form', [
            'alumni' => $alumni,
            // 'user'   => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IjazahRequest $request)
    {
        Ijazah::create([
            'mahasiswa_id' => $request->mahasiswa_id,
            'no_ijazah'    => $request->no_ijazah,
            'tahun_lulus'  => $request->tahun_lulus
        ]);

        return redirect()->route('ijazah.index')->with('success', 'Data Berhasil Ditambah');
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
        $ijazah = Ijazah::find($id);
        $alumni = Mahasiswa::Oldest('status', 'Alumni')
        ->where('status', 'Alumni')
        ->get();

        return view ('admin.ijazah.form', [
            'ijazah' => $ijazah,
            'alumni' => $alumni
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IjazahRequest $request, string $id)
    {
        $data = [
            'mahasiswa_id' => $request->mahasiswa_id,
            'no_ijazah'    => $request->no_ijazah,
            'tahun_lulus'  => $request->tahun_lulus
        ];

        Ijazah::where('id', $id)->update($data);
        return redirect()->route('ijazah.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ijazah = Ijazah::find($id);

        $ijazah->delete();

        return response()->json(['status' => 'Data Berhasil Dihapus']);
    }
}
