<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
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
    protected $appends = ['get_mahasiswa', 'jenis_dokumen'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'nama_mahasiswa' => 'array',
        'jenis_legalisir' => 'array',
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
     * Get the user that owns the Instansi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    /**
     * Get the user that owns the JenisPengajuan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenisPengajuan()
    {
        return $this->belongsTo(JenisPengajuan::class);
    }

    /**
     * Get the user that owns the TempatPkl
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tempatPkl()
    {
        return $this->belongsTo(TempatPkl::class);
    }
    
    /**
     * Get all of the Log for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function riwayat()
    {
        return $this->hasMany(Riwayat::class);
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
            $file->storeAs('public/dokumen/', $filename);
        }

        return $filename;
    }

    public function getGetMahasiswaAttribute()
    {
        $data = User::whereIn('id', $this->nama_mahasiswa)->get();
        if ($data->isEmpty()) {
            return null;
        }

        return $data->implode('name', ',');
    }

}
