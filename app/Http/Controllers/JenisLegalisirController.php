<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisLegalisir;

use App\Http\Requests\JenisLegalisirRequest;

use Illuminate\Support\Facades\Crypt;

class JenisLegalisirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $legalisir = JenisLegalisir::all();

        return view ('admin.jenis-legalisir.index',[
            'legalisir' => $legalisir,
            'title'    => 'Jenis Legalisir'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('admin.jenis-legalisir.form', [
            'title'    => 'Jenis Legalisir'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JenisLegalisirRequest $request)
    {
        JenisLegalisir::create([
            'name' => $request->name
        ]);

        return redirect()->route('jenis-legalisir.index')->with('success', 'Data Berhasil Ditambah');
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

        $legalisir = JenisLegalisir::find($id);
        
        return view ('admin.jenis-legalisir.form',[
            'legalisir' => $legalisir,
            'title'    => 'Jenis Legalisir'
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JenisLegalisirRequest $request, string $id)
    {
        $data = [
            'name' => $request->name
        ];

        JenisLegalisir::where('id', $id)->update($data);

        return redirect()->route('jenis-legalisir.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $legalisir = JenisLegalisir::find($id);

        $legalisir->delete();

        return response()->json(['status' => 'Data Berhasil Dihapus']);
    }
}
