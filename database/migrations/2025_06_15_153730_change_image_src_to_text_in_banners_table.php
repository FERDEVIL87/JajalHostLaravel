<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            // Ubah tipe kolom imageSrc menjadi TEXT
            $table->text('imageSrc')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            // Kembalikan ke varchar jika di-rollback
            $table->string('imageSrc', 2048)->nullable()->change();
        });
    }
};