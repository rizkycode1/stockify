<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\LogsActivity;

class Barang extends Model
{
    use LogsActivity;

    protected $fillable = [
        'company_id',
        'nama_barang',
        'kategori_id',
        'supplier_id',
        'harga',
        'stok',
        'foto',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

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

    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class);
    }
}
