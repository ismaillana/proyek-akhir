<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use App\Http\Requests\ProfilRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class ProfilController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function profilSuperAdmin()
    {
        $user    =   auth()->user();
        
        return view ('admin.profil.super-admin', [
            'user'   =>  $user,
            'title'     => 'Profil Super Admin'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateSuperAdmin(ProfilRequest $request, $id)
    {
        $data = [
            'name'        => $request->name,
            'wa'          => 62 . $request->wa,
            'nomor_induk' => $request->nomor_induk,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
        ];

        $image = User::saveImage($request);

        if ($image) {
            $data['image'] = $image;

            User::deleteImage($id);
        }

        User::where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Data Berhasil Diedit');
    }
}
