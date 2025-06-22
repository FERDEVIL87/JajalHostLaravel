<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model {
    use HasFactory;
    protected $fillable = [
        'brand', 'name', 'slogan', 'imageSrc', 'features', 'is_active', 'order_column'
    ];
    // Otomatis konversi 'features' antara array PHP dan string JSON
    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
    ];
}