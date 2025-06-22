<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PcPart;
use Illuminate\Http\Request;

class HardwareController extends Controller
{
    public function index()
    {
        // Ambil semua data dari model PcPart
        $hardware = PcPart::all();
        // Laravel otomatis mengonversi ke JSON
        return response()->json($hardware);
    }
}