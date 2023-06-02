<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Jurusan;
use App\Models\ProgramStudi;
use Spatie\Permission\Models\Role;

use App\Http\Requests\AlumniUpdateRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alumni = Mahasiswa::latest()
        ->where('status', 'Alumni')
        ->get();

        return view ('admin.alumni.index', [
            'alumni' => $alumni,
            'title'         => 'Alumni'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        
        $alumni = Mahasiswa::findOrFail($id);
        $user = User::with(['roles'])->where('id', $alumni->user_id)->first();
        $jurusan = Jurusan::oldest('name')->get();
        $prodi = ProgramStudi::oldest('name')->get();
        $roles     =   Role::oldest('name')->get();
// dd($user);
        return view ('admin.alumni.detail', [
            'user'      => $user,
            'alumni'    => $alumni,
            'jurusan'   => $jurusan,
            'prodi'     => $prodi,
            'roles'     => $roles,
            'title'     => 'Alumni'
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

        $alumni = Mahasiswa::findOrFail($id);
        $jurusan = Jurusan::oldest('name')->get();
        $prodi = ProgramStudi::oldest('name')->get();
        $roles     =   Role::oldest('name')->get();

        return view ('admin.alumni.form', [
            'alumni' => $alumni,
            'jurusan'   => $jurusan,
            'prodi'     => $prodi,
            'roles'     =>  $roles,
            'title'         => 'Alumni'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AlumniUpdateRequest $request, $id)
    { 
       $alumni = Mahasiswa::find($id);
       $checkEmail = Mahasiswa::whereNotIn('id', [$id])
       ->whereHas('user', function ($q)use($request)
       {
        $q->where('email', $request->email);
       })
       ->first();
      if ($checkEmail) {
        return redirect()->back()->withErrors(['email' => 'email sudah ada'])->withInput();
      }
        $data = [
            'angkatan'          => $request->angkatan,
            'jurusan_id'        => $request->jurusan_id,
            'program_studi_id'  => $request->program_studi_id,
            'status'            => $request->status,
        ];

        $image = Mahasiswa::saveImage($request);

        if ($image) {
            $data['image'] = $image;

            $param = (object) [
                'type'  => 'image',
                'id'    => $alumni->id
            ];

            Mahasiswa::deleteImage($param);
        }

        Mahasiswa::where('id', $alumni->id)->update($data);

        $roles = Role::findOrFail($request->roles);

        User::whereId($alumni->user_id)->update([
            'name'        => $request->name,
            'nomor_induk' => $request->nomor_induk,
            'wa'          => 62 . $request->wa,
            'password'    => Hash::make($request->nomor_induk)
        ]);

        $user = User::where('id',$alumni->user_id)->first();

        $user->syncRoles($roles);
       
        return redirect()->route('alumni.index')->with('success', 'Data Berhasil Diubah');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $alumni = Mahasiswa::find($id);

        // $resellerOrder =  ResellerOrder::where('reseller_id', $id)
        //     ->whereNotIn('order_status_id', [8, 9])
        //     ->first();

        // if ($resellerOrder) {
        //     return response()->json(['message' => 'Gagal hapus, masih ada transaksi yang berjalan', 'status' => 'error', 'code' => '500']);
        // }

        $param = (object) [
            'type'  => 'image',
            'id'    => $alumni->id
        ];

        Mahasiswa::deleteImage($param);

        // $this->deleteMahasiswa($id);

        $alumni->delete();

        User::where('id', $alumni->user_id)->update(['status' => '0']);

        return response()->json(['status' => 'Data Berhasil Dihapus']);
    }
}
