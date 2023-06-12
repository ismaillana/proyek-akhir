<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPengajuan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * Get all of the comments for the Pengajuan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class);
    }
}
