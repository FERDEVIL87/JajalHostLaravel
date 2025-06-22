<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConsoleAndHandheld; // Pastikan model di-import
use Illuminate\Http\Request;

class ConsoleAndHandheldController extends Controller
{
    /**
     * Mengembalikan daftar semua konsol dan handheld.
     * Ini adalah endpoint yang akan dipanggil oleh Vue.js.
     */
    public function index()
    {
        // Ambil semua data dari model
        $consoles = ConsoleAndHandheld::all();

        // Laravel akan secara otomatis mengubah koleksi ini menjadi JSON
        return response()->json($consoles);
    }
}