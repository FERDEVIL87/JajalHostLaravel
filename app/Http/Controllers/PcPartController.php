<?php

namespace App\Http\Controllers;

use App\Models\PcPart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- Impor Storage

class PcPartController extends Controller
{
    /**
     * Menampilkan daftar semua PC Parts. (Halaman utama PC Parts)
     */
    public function index()
    {
        // Ganti latest() dengan orderBy('id', 'desc') untuk menghindari error 'created_at' not found
        $pcParts = PcPart::orderBy('id', 'desc')->get();

        // Kirim data ke view 'pc_parts.index'
        return view('pc_parts.index', compact('pcParts'));
    }

    /**
     * Menampilkan form untuk membuat PC Part baru.
     */
    public function create()
    {
        // Cukup tampilkan view form
        return view('pc_parts.create');
    }

    /**
     * Menyimpan PC Part baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'brand' => 'required|string|max:100',
            'category' => 'required|string',
            'specs' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            // Aturan validasi baru untuk gambar
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image' => 'nullable|url|required_without:image_upload',
        ], [
            'image.required_without' => 'Anda harus mengisi URL Gambar atau mengunggah file gambar.'
        ]);

        $imagePath = null;
        if ($request->hasFile('image_upload')) {
            $path = $request->file('image_upload')->store('pc-parts', 'public');
            $imagePath = Storage::url($path);
        } else {
            $imagePath = $validated['image'];
        }

        $dataToStore = $validated;
        $dataToStore['image'] = $imagePath;
        // Kita asumsikan specs disimpan sebagai array JSON
        $dataToStore['specs'] = array_filter(array_map('trim', explode("\n", $validated['specs'] ?? '')));

        // Simpan ke database menggunakan Model
        PcPart::create($dataToStore);

        // Arahkan kembali ke halaman daftar dengan pesan sukses
        return redirect()->route('pc-parts.index')->with('success', 'PC Part berhasil ditambahkan!');
    }


    /**
     * Menampilkan form untuk mengedit PC Part.
     */
    public function edit(PcPart $pcPart) // Laravel akan otomatis mencari PcPart berdasarkan ID
    {
        return view('pc_parts.edit', compact('pcPart'));
    }

    /**
     * Memperbarui data PC Part di database.
     */
    public function update(Request $request, PcPart $pcPart)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'brand' => 'required|string|max:100',
            'category' => 'required|string',
            'specs' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image' => 'nullable|url',
        ]);

        $imagePath = $pcPart->image;
        if ($request->hasFile('image_upload')) {
            if ($pcPart->image && str_starts_with($pcPart->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $pcPart->image));
            }
            $path = $request->file('image_upload')->store('pc-parts', 'public');
            $imagePath = Storage::url($path);
        } elseif (!empty($validated['image'])) {
            $imagePath = $validated['image'];
        }

        $dataToUpdate = $validated;
        $dataToUpdate['image'] = $imagePath;
        $dataToUpdate['specs'] = array_filter(array_map('trim', explode("\n", $validated['specs'] ?? '')));

        // Update data pada model yang ditemukan
        $pcPart->update($dataToUpdate);

        // Arahkan kembali ke halaman daftar dengan pesan sukses
        return redirect()->route('pc-parts.index')->with('success', 'PC Part berhasil diperbarui!');
    }

    /**
     * Menghapus PC Part dari database.
     */
    public function destroy(PcPart $pcPart)
    {
        if ($pcPart->image && str_starts_with($pcPart->image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $pcPart->image));
        }
        // Hapus data
        $pcPart->delete();

        // Arahkan kembali ke halaman daftar dengan pesan sukses
        return redirect()->route('pc-parts.index')->with('success', 'PC Part berhasil dihapus!');
    }
}