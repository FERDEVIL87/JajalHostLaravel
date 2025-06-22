<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('console_and_handhelds', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // <-- PASTIKAN BARIS INI ADA
            $table->decimal('price', 15, 2);
            $table->string('brand');
            $table->string('category');
            $table->string('image')->nullable();
            $table->json('specs')->nullable();
            $table->string('stock');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('console_and_handhelds');
    }
};