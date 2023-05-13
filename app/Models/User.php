<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all of the mahasiswa for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mahasiswa(): HasMany
    {
        return $this->hasMany(Mahasiswa::class);
    }

    /**
     * Get all of the Instansi for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function instansi(): HasMany
    {
        return $this->hasMany(Instansi::class);
    }

    /**
     * Get all of the Admin Jurusan for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adminJurusan(): HasMany
    {
        return $this->hasMany(AdminJurusan::class);
    }

    /**
     * Get all of the Admin Jurusan for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function koorPKL(): HasMany
    {
        return $this->hasMany(koorPkl::class);
    }
}
