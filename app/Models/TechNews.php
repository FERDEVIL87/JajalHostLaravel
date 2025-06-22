<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechNews extends Model
{
    use HasFactory;

    protected $table = 'tech_news';

    /**
     * Pastikan semua nama kolom dari form ada di sini.
     */
    protected $fillable = [
        'title',
        'excerpt',
        'date',
        'source',
        'imageUrl',
        'readMoreUrl'
    ];

    /**
     * Casting untuk tanggal
     */
    protected $casts = [
        'date' => 'date:Y-m-d',
    ];
}