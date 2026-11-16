<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\LogsActivity;

class Supplier extends Model
{
    use LogsActivity;

    protected $fillable = [
        'nama_supplier',
        'telepon',
        'alamat'
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
}
