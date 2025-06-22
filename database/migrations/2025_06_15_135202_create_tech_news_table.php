<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tech_news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('excerpt');
            $table->date('date'); // Menggunakan tipe data date
            $table->string('source');
            $table->string('imageUrl', 2048)->nullable(); // URL bisa panjang
            $table->string('readMoreUrl', 2048)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('tech_news'); }
};