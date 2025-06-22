<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PcPart;

class PcPartSeeder extends Seeder
{
    public function run(): void
    {
        PcPart::create([
            'name' => 'Wandaba Keyboard',
            'price' => 12000,
            'brand' => 'Rexus',
            'category' => 'KEYBOARD',
            'image' => 'url_gambar_keyboard.jpg',
            'specs' => ['Tipe: RGB', 'Layout: TKL'], // Model akan otomatis mengubahnya menjadi JSON
            'stock' => 15,
        ]);

        PcPart::create([
            'name' => 'Asuwasuwa Processor',
            'price' => 20000,
            'brand' => 'asdasf',
            'category' => 'PROCESSOR INTEL',
            'image' => 'url_gambar_processor.jpg',
            'specs' => ['Cores: 2', 'Threads: 4'],
            'stock' => 3,
        ]);
    }
}