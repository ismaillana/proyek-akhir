<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Http\Requests\JurusanRequest;
use Illuminate\Support\Facades\Crypt;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurusan = Jurusan::all();

        return view ('admin.jurusan.index',[
            'jurusan' => $jurusan,
            'title' => 'Jurusan'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('admin.jurusan.form', [
            'title'    => 'Jurusan'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JurusanRequest $request)
    {
        Jurusan::create([
            'name'  =>  $request->name
        ]);

        return redirect()->route('jurusan.index')->with('success', 'Data Berhasil Ditambahkan');
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

        $jurusan = Jurusan::find($id);
        return view ('admin.jurusan.form', [
            'jurusan'   =>  $jurusan,
            'title'    => 'Jurusan'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JurusanRequest $request, string $id)
    {
        $data = [
            'name'  =>  $request->name
        ];

        Jurusan::where('id', $id)->update($data);

        return redirect()->route('jurusan.index')->with('success', 'Data Berhasil Diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jurusan = Jurusan::find($id);

        $jurusan->delete();

        return response()->json(['status' => 'Data Berhasil Dihapus']);
    }
}
