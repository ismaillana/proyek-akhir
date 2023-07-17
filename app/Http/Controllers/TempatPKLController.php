<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TempatPkl;
use App\Http\Requests\TempatPklRequest;
use Illuminate\Support\Facades\Crypt;

class TempatPKLController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tempatPKL = TempatPkl::latest()
            ->get();

        return view ('admin.tempat-pkl.index',[
            'tempatPKL' => $tempatPKL,
            'title'     => 'Tempat PKL'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('admin.tempat-pkl.form', [
            'title'     => 'Tempat PKL'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TempatPklRequest $request)
    {
        TempatPkl::create([
            'name'      => $request->name,
            'alamat'    => $request->alamat,
            'telepon'   => $request->telepon,
            'web'       => $request->web
        ]);

        return redirect()->route('tempat-pkl.index')->with('success', 'Data Berhasil Ditambah');
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

        $tempatPkl = TempatPkl::findOrFail($id);

        return view ('admin.tempat-pkl.detail', [
            'tempatPkl' => $tempatPkl,
            'title'     => 'Detail Tempat PKL'
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
        
        $tempatPKL = TempatPkl::find($id);

        return view ('admin.tempat-pkl.form', [
            'tempatPKL' => $tempatPKL,
            'title'     => 'Tempat PKL'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TempatPklRequest $request, string $id)
    {
        $data = [
            'name'      => $request->name,
            'alamat'    => $request->alamat,
            'telepon'   => $request->telepon,
            'web'       => $request->web
        ];

        TempatPkl::where('id', $id)->update($data);

        return redirect()->route('tempat-pkl.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tempatPKL = TempatPkl::find($id);

        $tempatPKL->delete();

        return response()->json(['status' => 'Data Berhasil Dihapus']);
    }
}
