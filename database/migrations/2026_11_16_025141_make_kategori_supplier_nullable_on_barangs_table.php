
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropForeign(['supplier_id']);
        });

        Schema::table('barangs', function (Blueprint $table) {
            $table->foreignId('kategori_id')
                ->nullable()
                ->change();

            $table->foreignId('supplier_id')
                ->nullable()
                ->change();

            $table->foreign('kategori_id')
                ->references('id')->on('kategoris')
                ->nullOnDelete();

            $table->foreign('supplier_id')
                ->references('id')->on('suppliers')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        // Tidak otomatis mengembalikan kolom menjadi wajib.
    }
};
