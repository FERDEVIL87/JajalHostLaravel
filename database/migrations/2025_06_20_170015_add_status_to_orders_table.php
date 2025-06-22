<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('orders', function (Blueprint $table) {
            // Tambahkan kolom status setelah payment_status
            $table->string('status')->default('Diproses')->after('payment_status');
        });
    }
    public function down(): void {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};