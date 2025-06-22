<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->index();
            $table->string('product_name');
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2);    // <-- Langsung definisikan di sini
            $table->decimal('total_price', 15, 2);   // <-- Langsung definisikan di sini
            $table->string('customer_name');
            $table->text('customer_address');
            $table->string('customer_phone', 20);
            $table->timestamp('purchase_date')->useCurrent();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};