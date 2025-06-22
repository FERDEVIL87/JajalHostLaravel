<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\TechNews;

class TechNewsController extends Controller {
    public function index() {
        // Ambil berita, urutkan dari yang terbaru
        $news = TechNews::latest('date')->get();
        return response()->json($news);
    }
}