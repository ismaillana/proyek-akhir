<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Image;

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
     * Get all of the Log for the Riwayat
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

    /**
     * Save dokumen.
     *
     * @param  $request
     * @return string
     */
    public static function saveDokumenPermohonan($request)
    {
        $filename = null;

        if ($request->dokumen_permohonan) {
            $file = $request->dokumen_permohonan;

            $ext = $file->getClientOriginalExtension();
            $filename = date('YmdHis') . uniqid() . '.' . $ext;
            $file->storeAs('public/dokumen/dokumen-permohonan', $filename);
        }

        return $filename;
    }

    /**
     * Save dokumen.
     *
     * @param  $request
     * @return string
     */
    public static function saveDokumenHasil($request)
    {
        $filename = null;

        if ($request->dokumen_hasil) {
            $file = $request->dokumen_hasil;

            $ext = $file->getClientOriginalExtension();
            $filename = date('YmdHis') . uniqid() . '.' . $ext;
            $file->storeAs('public/dokumen/dokumen-hasil', $filename);
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

    /**
     * Save image.
     *
     * @param  $request
     * @return string
     */
    public static function saveImage($request)
    {
        $filename = null;

        if ($request->image) {
            $file = $request->image;

            $ext = $file->getClientOriginalExtension();
            $filename = date('YmdHis') . uniqid() . '.' . $ext;
            $file->storeAs('public/image/bukti-penolakan/', $filename);
        }

        return $filename;
    }

    /**
     * Save image.
     *
     * @param  $request
     * @return string
     */
    public static function saveBukti($request)
    {
        $filename = null;

        if ($request->bukti_selesai) {
            $file = $request->bukti_selesai;

            $ext = $file->getClientOriginalExtension();
            $filename = date('YmdHis') . uniqid() . '.' . $ext;
            $file->storeAs('public/image/bukti-selesai/', $filename);
        }

        return $filename;
    }

    /**
     * Get the image .
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/public/image/bukti-penolakan/' . $this->image);
        }
        
        return null;
    }

}
