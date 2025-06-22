<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcPart extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'pc_parts';

    // Kolom yang bisa diisi secara massal
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
     * Aktifkan kembali casting untuk 'specs'.
     */
    protected $casts = [
        'specs' => 'array',
    ];
    
    public $timestamps = false; // Nonaktifkan jika tabel tidak punya created_at/updated_at
}