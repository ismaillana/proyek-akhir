<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use App\Http\Requests\ProfilRequest;
use App\Http\Requests\PasswordRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class ProfilController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function profil()
    {
        $user    =   auth()->user();
        
        return view ('admin.profil.index', [
            'user'   =>  $user,
            'title'     => 'Profil'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProfil(ProfilRequest $request, $id)
    {
        $data = [
            'name'        => $request->name,
            'wa'          => 62 . $request->wa,
            'nomor_induk' => $request->nomor_induk,
            'email'       => $request->email,
        ];

        $image = User::saveImage($request);

        if ($image) {
            $data['image'] = $image;

            User::deleteImage($id);
        }

        User::where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Data Berhasil Diedit');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function password()
    {
        $user    =   auth()->user();
        
        return view ('admin.password.index', [
            'user'   =>  $user,
            'title'     => 'Password'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePassword(PasswordRequest $request, $id)
    {
        $data = [
            'password'    => Hash::make($request->password)
        ];

        User::where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Data Berhasil Diedit');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function profilMahasiswa()
    {
        $user    =   auth()->user();
        
        return view ('user.profil.profil-mahasiswa', [
            'user'   =>  $user,
            'title'     => 'Profil'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function profilInstansi()
    {
        $user    =   auth()->user();
        
        return view ('user.profil.profil-instansi', [
            'user'   =>  $user,
            'title'     => 'Profil'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function passwordUser()
    {
        $user    =   auth()->user();
        
        return view ('user.profil.password', [
            'user'   =>  $user,
            'title'     => 'Password'
        ]);
    }
    
}
