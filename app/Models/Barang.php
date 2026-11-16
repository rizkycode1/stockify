<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\LogsActivity;

class Barang extends Model
{
    use LogsActivity;

    protected $fillable = [
        'nama_barang',
        'kategori_id',
        'supplier_id',
        'harga',
        'stok'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class);
    }
}
