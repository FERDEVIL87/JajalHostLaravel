<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('name');
            $table->string('slogan');
            $table->string('imageSrc', 2048); // Path atau URL gambar
            $table->json('features'); // Fitur akan disimpan sebagai JSON array
            $table->boolean('is_active')->default(true); // Untuk mengaktifkan/menonaktifkan banner
            $table->integer('order_column')->default(0); // Untuk mengurutkan banner
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('banners'); }
};