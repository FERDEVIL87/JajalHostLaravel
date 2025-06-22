<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create akan membuat query "CREATE TABLE pc_parts (...)" di MySQL
        Schema::create('pc_parts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->unsignedBigInteger('price')->default(0); // Gunakan integer untuk harga agar presisi
            $table->string('brand', 100);
            $table->string('category', 100);
            $table->text('image')->nullable(); // text untuk URL yang mungkin panjang
            
            // ==========================================================
            // PERUBAHAN DI SINI: json() diubah menjadi longText()
            // ==========================================================
            $table->json('specs')->nullable();
            // ==========================================================
            
            $table->integer('stock')->default(0);
            // Kita tidak menambahkan timestamps() jika tabel aslinya tidak punya created_at/updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pc_parts');
    }
};