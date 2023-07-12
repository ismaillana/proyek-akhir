<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Image;

class Mahasiswa extends Model
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
    protected $appends = ['image_url'];

    /**
     * Get the user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that owns the Program Studi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    /**
     * Get all of the comments for the Pengajuan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class);
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
            $file->storeAs('public/image/mahasiswa/', $filename);
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
            return asset('storage/public/image/mahasiswa/' . $this->image);
        }
        
        return null;
    }

    /**
     * Delete image.
     *
     * @param  $id
     * @return void
     */
    public static function deleteImage(object $param)
    {
        $mahasiswa = Mahasiswa::firstWhere('id', $param->id);
        if ($mahasiswa->image != null) {
            $path = 'public/image/mahasiswa/' . $mahasiswa->image;
            if (Storage::exists($path)) {
                Storage::delete('public/image/mahasiswa/' . $mahasiswa->image);
            }
        }
    }

    /**
     * Scope Filter.
     *
     * @return scope
     */
    public function scopeFilter($query, $param)
    {
        // If filter by status produk exist
        $query->when($param->status ?? false, fn ($query, $status) => $query->where('status', $status));
    }
}
