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
        // Perintah ini akan membuat tabel dengan semua kolom di dalamnya
        Schema::create('customer_services', function (Blueprint $table) {
            $table->id();
            $table->string('nama');      // <-- KOLOM INI AKAN DIBUAT
            $table->string('email');     // <-- KOLOM INI AKAN DIBUAT
            $table->text('pesan');       // <-- KOLOM INI AKAN DIBUAT
            $table->timestamps();        // Ini membuat created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_services');
    }
};