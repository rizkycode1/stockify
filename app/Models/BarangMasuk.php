<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\LogsActivity;

class BarangMasuk extends Model
{
    use LogsActivity;

    protected $fillable = [
        'barang_id',
        'jumlah',
        'tanggal',
        'keterangan'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
