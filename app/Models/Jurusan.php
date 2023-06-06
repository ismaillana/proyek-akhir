<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * Get all of the comments for the Jurusan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programStudi()
    {
        return $this->hasMany(ProgramStudi::class);
    }

    /**
     * Get all of the comments for the Jurusan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mahasiswa(): HasMany
    {
        return $this->hasMany(Mahasiswa::class);
    }

    /**
     * Get all of the comments for the Jurusan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adminJurusan(): HasMany
    {
        return $this->hasMany(AdminJurusan::class);
    }

    /**
     * Get all of the comments for the Jurusan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function koorPKL(): HasMany
    {
        return $this->hasMany(koorPkl::class);
    }
}
