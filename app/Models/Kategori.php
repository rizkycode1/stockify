<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\LogsActivity;

class Kategori extends Model
{
    use LogsActivity;

    protected $fillable = [
        'company_id',
        'nama_kategori',
        'deskripsi',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
}
