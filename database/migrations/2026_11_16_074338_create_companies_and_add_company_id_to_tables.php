
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Membuat tabel perusahaan
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        // 2. Membuat perusahaan awal untuk data Stockify lama
        $now = now();

        $companyId = DB::table('companies')->insertGetId([
            'name' => 'Stockify Workspace',
            'slug' => 'stockify-workspace',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 3. Menambahkan company_id dan role ke users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('company_id')
                ->nullable()
                ->constrained('companies')
                ->restrictOnDelete();

            $table->string('role')->default('admin');
        });

        // 4. Menambahkan company_id ke tabel inventaris
        $tables = [
            'kategoris',
            'suppliers',
            'barangs',
            'barang_masuks',
            'barang_keluars',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('company_id')
                    ->nullable()
                    ->constrained('companies')
                    ->restrictOnDelete();
            });
        }

        // 5. Menambahkan company_id ke riwayat aktivitas
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->foreignId('company_id')
                ->nullable()
                ->constrained('companies')
                ->nullOnDelete();
        });

        // 6. Memindahkan semua data lama ke perusahaan awal
        $tablesToUpdate = [
            'users',
            'kategoris',
            'suppliers',
            'barangs',
            'barang_masuks',
            'barang_keluars',
            'activity_logs',
        ];

        foreach ($tablesToUpdate as $tableName) {
            DB::table($tableName)->update([
                'company_id' => $companyId,
            ]);
        }

        // 7. Company wajib dimiliki setiap user
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('company_id')
                ->nullable(false)
                ->change();
        });

        // 8. Data inventaris wajib memiliki perusahaan
        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('company_id')
                    ->nullable(false)
                    ->change();
            });
        }
    }

    public function down(): void
    {
        // Menghapus foreign key dan kolom tambahan
        $tables = [
            'users',
            'kategoris',
            'suppliers',
            'barangs',
            'barang_masuks',
            'barang_keluars',
            'activity_logs',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropForeign(['company_id']);
                $table->dropColumn('company_id');
            });
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::dropIfExists('companies');
    }
};
