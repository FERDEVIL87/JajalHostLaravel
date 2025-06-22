<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'checkouts';

    // Kolom yang bisa diisi
protected $fillable = [
    'transaction_id', 'product_name', 'quantity', 'unit_price', 'total_price',
    'customer_name', 'customer_address', 'customer_phone', 'purchase_date', 'status_order'
];

    /**
     * Nama kolom untuk created_at dan updated_at.
     * Karena kita hanya punya 'purchase_date', kita bisa menonaktifkan timestamps otomatis
     * atau menimpa nama kolomnya. Untuk kesederhanaan, kita nonaktifkan saja.
     */
    public $timestamps = false;
}