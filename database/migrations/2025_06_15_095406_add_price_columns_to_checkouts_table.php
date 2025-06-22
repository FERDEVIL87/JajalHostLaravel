<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Mengubah tabel 'checkouts' yang sudah ada
        Schema::table('checkouts', function (Blueprint $table) {
            $table->decimal('unit_price', 15, 2)->after('quantity');
            $table->decimal('total_price', 15, 2)->after('unit_price');
        });
    }

    public function down(): void
    {
        Schema::table('checkouts', function (Blueprint $table) {
            $table->dropColumn(['unit_price', 'total_price']);
        });
    }
};