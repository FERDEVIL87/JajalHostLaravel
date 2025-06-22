<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsoleAndHandheld extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda (opsional, praktik baik)
    protected $table = 'console_and_handhelds';

    // Kolom yang boleh diisi
    protected $fillable = [
        'name',
        'price',
        'brand',
        'category',
        'image',
        'specs',
        'stock',
    ];

    /**
     * Otomatis konversi kolom 'specs' antara array PHP dan string JSON.
     */
    protected $casts = [
        'specs' => 'array',
    ];
}