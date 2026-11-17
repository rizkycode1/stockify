<?php

namespace App\Models\Concerns;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

trait LogsActivity
{
    protected static function bootLogsActivity(): void
    {
        Event::listen('eloquent.created: ' . static::class, function (Model $model) {
            self::record($model, 'Menambahkan');
        });

        Event::listen('eloquent.updated: ' . static::class, function (Model $model) {
            self::record($model, 'Mengubah');
        });

        Event::listen('eloquent.deleted: ' . static::class, function (Model $model) {
            self::record($model, 'Menghapus');
        });
    }

    protected static function record(Model $model, string $action): void
    {
        $nama = $model->getAttribute('nama_barang')
            ?? $model->getAttribute('nama_kategori')
            ?? $model->getAttribute('nama_supplier')
            ?? 'Barang Masuk';

        $companyId = $model->getAttribute('company_id')
            ?? Auth::user()?->company_id;

        ActivityLog::create([
            'company_id' => $companyId,
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => "$action data: $nama",
            'subject_type' => get_class($model),
            'subject_id' => $model->getKey(),
        ]);
    }
}
