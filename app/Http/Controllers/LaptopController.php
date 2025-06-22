<?php

namespace App\Http\Controllers;

use App\Models\Laptop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- Impor Storage

class LaptopController extends Controller
{
    /**
     * Daftar kategori laptop yang tersedia.
     */
    private $categories = [
        "Low-End",
        "Mid-Range",
        "High-End",
    ];

    /**
     * Menampilkan daftar semua laptop di admin panel.
     */
    public function index()
    {
        $laptops = Laptop::latest()->get();
        return view('laptops.index', compact('laptops'));
    }

    /**
     * Menampilkan form untuk membuat data laptop baru.
     */
    public function create()
    {
        // Kirim daftar kategori ke view create
        return view('laptops.create', ['categories' => $this->categories]);
    }

    /**
     * Menyimpan data laptop baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi, pastikan kategori ada di dalam daftar yang kita buat
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:'.implode(',', $this->categories),
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'brand' => 'required|string|max:255',
            // Aturan validasi baru untuk gambar
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image' => 'nullable|url|required_without:image_upload',
        ], [
            'image.required_without' => 'Anda harus mengisi URL Gambar atau mengunggah file gambar.'
        ]);

        $imagePath = null;
        if ($request->hasFile('image_upload')) {
            $path = $request->file('image_upload')->store('laptops', 'public');
            $imagePath = Storage::url($path);
        } else {
            $imagePath = $validated['image'];
        }

        $dataToStore = $validated;
        $dataToStore['image'] = $imagePath;

        Laptop::create($dataToStore);
        return redirect()->route('laptops.index')->with('success', 'Data laptop berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data laptop.
     */
    public function edit(Laptop $laptop)
    {
        // Kirim data laptop dan daftar kategori ke view edit
        return view('laptops.edit', [
            'laptop' => $laptop,
            'categories' => $this->categories,
        ]);
    }

    /**
     * Memperbarui data laptop di database.
     */
    public function update(Request $request, Laptop $laptop)
    {
        // Validasi, pastikan kategori ada di dalam daftar yang kita buat
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:'.implode(',', $this->categories),
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'brand' => 'required|string|max:255',
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image' => 'nullable|url',
        ]);

        $imagePath = $laptop->image;
        if ($request->hasFile('image_upload')) {
            if ($laptop->image && str_starts_with($laptop->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $laptop->image));
            }
            $path = $request->file('image_upload')->store('laptops', 'public');
            $imagePath = Storage::url($path);
        } elseif (!empty($validated['image'])) {
            $imagePath = $validated['image'];
        }

        $dataToUpdate = $validated;
        $dataToUpdate['image'] = $imagePath;

        $laptop->update($dataToUpdate);
        return redirect()->route('laptops.index')->with('success', 'Data laptop berhasil diperbarui.');
    }

    /**
     * Menghapus data laptop dari database.
     */
    public function destroy(Laptop $laptop)
    {
        if ($laptop->image && str_starts_with($laptop->image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $laptop->image));
        }
        $laptop->delete();
        return redirect()->route('laptops.index')->with('success', 'Data laptop berhasil dihapus.');
    }
}