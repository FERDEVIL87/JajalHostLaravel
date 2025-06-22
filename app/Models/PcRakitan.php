<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcRakitan extends Model {
    use HasFactory;
    protected $table = 'pc_rakitans';
    protected $fillable = [
        'name', 'category', 'price', 'image', 'description', 'specs'
    ];
    // Otomatis konversi kolom 'specs' antara object/array PHP dan string JSON
    protected $casts = [
        'specs' => 'array',
    ];
}