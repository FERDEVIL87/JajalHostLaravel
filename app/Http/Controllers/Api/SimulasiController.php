<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\PcPart;

class SimulasiController extends Controller
{
    public function getPcParts()
    {
        // 1. Definisikan semua kategori yang akan menjadi baris di tabel simulasi
        $simulationCategories = [
            'CPU',
            'MAINBOARD',
            'MEMORY',
            'VGA',
            'HDD',
            'SSD',
            'PSU',
            'CASE',
        ];

        // 2. Ambil semua data dari database
        $allParts = PcPart::all();

        // 3. Siapkan hasil akhir, dimulai dengan semua kategori berisi array kosong
        $result = array_fill_keys($simulationCategories, []);

        // 4. Proses dan kelompokkan data secara manual
        foreach ($allParts as $part) {
            $category = $part->category;

            // PENGGABUNGAN: Jika kategori adalah INTEL atau AMD, masukkan ke dalam 'CPU'
            if ($category === 'PROCESSOR INTEL' || $category === 'PROCESSOR AMD') {
                $result['CPU'][] = $part;
            }
            // Jika kategori ada di daftar standar kita, masukkan ke grup yang sesuai
            elseif (in_array($category, $simulationCategories)) {
                $result[$category][] = $part;
            }
        }
        
        return response()->json($result);
    }
}