<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Image;

class koorPkl extends Model
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
     * Get the user that owns the Mahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that owns the Mahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
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
            $file->storeAs('public/image/koor-pkl/', $filename);
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
            return asset('storage/public/image/koor-pkl/' . $this->image);
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
        $koorPkl = KoorPkl::firstWhere('id', $param->id);
        // dd($koorPkl);
        // if ($param->type == 'image') {
            if ($koorPkl->image != null) {
                $path = 'public/image/koor-pkl/' . $koorPkl->image;

                if (Storage::exists($path)) {
                    Storage::delete('public/image/koor-pkl/' . $koorPkl->image);
                }
            }
        // }
    }
}
