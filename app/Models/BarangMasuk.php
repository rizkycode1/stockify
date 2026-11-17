<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\LogsActivity;

class BarangMasuk extends Model
{
    use LogsActivity;

    protected $fillable = [
        'company_id',
        'barang_id',
        'jumlah',
        'tanggal',
        'keterangan',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
