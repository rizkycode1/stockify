<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\LogsActivity;

class Kategori extends Model
{
    use LogsActivity;

    protected $fillable = [
        'nama_kategori',
        'deskripsi'
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
}
