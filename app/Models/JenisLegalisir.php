<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisLegalisir extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * Get all of the comments for the Aktif Kuliah
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function legalisir(): HasMany
    {
        return $this->hasMany(Legalisir::class);
    }
}
