<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispensasi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['get_mahasiswa'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'nama_mahasiswa' => 'array',
    ];
    
    /**
     * Get the user that owns the Mahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    /**
     * Save dokumen.
     *
     * @param  $request
     * @return string
     */
    public static function saveDokumen($request)
    {
        $filename = null;

        if ($request->dokumen) {
            $file = $request->dokumen;

            $ext = $file->getClientOriginalExtension();
            $filename = date('YmdHis') . uniqid() . '.' . $ext;
            $file->storeAs('public/dokumen/dispensasi/', $filename);
        }

        return $filename;
    }

    public function getGetMahasiswaAttribute()
    {
        $data = User::whereIn('id', $this->nama_mahasiswa)->get();
        // dd($data);
        if ($data->isEmpty()) {
            return null;
        }

        // dd($data->isEmpty());

        return $data->implode('name', ',');
    }
}
