<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\ProgramStudi;
use App\Http\Requests\ProdiRequest;
use Illuminate\Support\Facades\Crypt;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prodi = ProgramStudi::all();

        return view ('admin.prodi.index', [
            'prodi' => $prodi,
            'title'     => 'Program Studi'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusan = Jurusan::all();
        return view ('admin.prodi.form', [
            'jurusan'   => $jurusan,
            'title'     => 'Program Studi'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdiRequest $request)
    {
        ProgramStudi::create([
            'jurusan_id'    =>  $request->jurusan_id,
            'name'          =>  $request->name
        ]);

        return redirect()->route('prodi.index')->with('success', 'Data Berhasil Ditambahkan');
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

        $prodi = ProgramStudi::find($id);
        $jurusan = Jurusan::oldest('name')->get();
        
        return view ('admin.prodi.form', [
            'prodi'     =>  $prodi,
            'jurusan'   =>  $jurusan,
            'title'     => 'Program Studi'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdiRequest $request, string $id)
    {
        $data = [
            'jurusan_id'    =>  $request->jurusan_id,
            'name'          =>  $request->name
        ];

        ProgramStudi::where('id', $id)->update($data);
        return redirect()->route('prodi.index')->with('success', 'Data Berhasil Diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prodi = ProgramStudi::find($id);

        $prodi->delete();

        return response()->json(['status' => 'Data Berhasil Dihapus']);
    }
}
