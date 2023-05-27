<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Legalisir extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    protected $appends = ['jenis_legalisir'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'jenis_legalisir_id' => 'array',
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
     * Get the user that owns the Mahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ijazah()
    {
        return $this->belongsTo(Ijazah::class);
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
            $file->storeAs('public/dokumen/legalisir/', $filename);
        }

        return $filename;
    }

    public function getJenisLegalisirAttribute()
    {
        $data = JenisLegalisir::whereIn('id', $this->jenis_legalisir_id)->get();
        if ($data->isEmpty()) {
            return null;
        }

        // dd($data->isEmpty());

        return $data->implode('name', ',');
    }

}
