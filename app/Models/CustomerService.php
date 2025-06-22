<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerService extends Model
{
    use HasFactory;

    protected $table = 'customer_services';

    protected $fillable = [
        'nama',      // <-- DIUBAH
        'email',     // <-- DIUBAH
        'pesan',     // <-- DIUBAH
    ];
}