<?php

namespace App\Models\Concerns;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @method static void created(\Closure $callback)
 * @method static void updated(\Closure $callback)
 * @method static void deleted(\Closure $callback)
 */
trait LogsActivity
{
    protected static function bootLogsActivity(): void
    {
        static::created(function (Model $model) {
            self::record($model, 'Menambahkan');
        });

        static::updated(function (Model $model) {
            self::record($model, 'Mengubah');
        });

        static::deleted(function (Model $model) {
            self::record($model, 'Menghapus');
        });
    }

    protected static function record(Model $model, string $action): void
    {
        $nama = $model->getAttribute('nama_barang')
            ?? $model->getAttribute('nama_kategori')
            ?? $model->getAttribute('nama_supplier')
            ?? 'Barang Masuk';

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => "$action data: $nama",
            'subject_type' => get_class($model),
            'subject_id' => $model->getKey(),
        ]);
    }
}
