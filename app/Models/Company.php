<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'phone',
        'address',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function kategoris(): HasMany
    {
        return $this->hasMany(Kategori::class);
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }

    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class);
    }

    public function barangMasuks(): HasMany
    {
        return $this->hasMany(BarangMasuk::class);
    }

    public function barangKeluars(): HasMany
    {
        return $this->hasMany(BarangKeluar::class);
    }
}
