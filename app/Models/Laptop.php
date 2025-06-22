<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laptop extends Model {
    use HasFactory;
    protected $fillable = [
        'name', 'category', 'price', 'image', 'description', 'stock', 'brand'
    ];
}