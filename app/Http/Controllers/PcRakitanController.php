<?php

namespace App\Http\Controllers;

use App\Models\PcRakitan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- Impor Storage

class PcRakitanController extends Controller
{
    /**
     * Daftar kategori paket rakitan yang tersedia.
     */
    private $categories = [
        "Gaming",
        "Office",
        "Editing",
        "Streaming",
        "Mining",
        "Warnet",
    ];

    public function index()
    {
        $pakets = PcRakitan::latest()->get();
        return view('pc_rakitans.index', compact('pakets'));
    }

    public function create()
    {
        // Kirim daftar kategori ke view create
        return view('pc_rakitans.create', ['categories' => $this->categories]);
    }

    public function store(Request $request)
    {
        // Perbarui validasi untuk kategori
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:'.implode(',', $this->categories),
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'specs' => 'required|string',
            // Aturan validasi baru untuk gambar
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image' => 'nullable|url|required_without:image_upload',
        ], [
            'image.required_without' => 'Anda harus mengisi URL Gambar atau mengunggah file gambar.'
        ]);

        $imagePath = null;
        if ($request->hasFile('image_upload')) {
            $path = $request->file('image_upload')->store('pc-rakitans', 'public');
            $imagePath = Storage::url($path);
        } else {
            $imagePath = $validated['image'];
        }

        $dataToStore = $validated;
        $dataToStore['image'] = $imagePath;
        $dataToStore['specs'] = json_decode($validated['specs'], true) ?? [];
        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->withErrors(['specs' => 'Format JSON untuk spesifikasi tidak valid.'])->withInput();
        }

        PcRakitan::create($dataToStore);
        return redirect()->route('pc-rakitans.index')->with('success', 'Paket Rakitan berhasil ditambahkan.');
    }

    public function edit(PcRakitan $pcRakitan)
    {
        // Kirim data paket dan daftar kategori ke view edit
        return view('pc_rakitans.edit', [
            'pcRakitan' => $pcRakitan,
            'categories' => $this->categories,
        ]);
    }

    public function update(Request $request, PcRakitan $pcRakitan)
    {
        // Perbarui validasi untuk kategori
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:'.implode(',', $this->categories),
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'specs' => 'required|string',
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image' => 'nullable|url',
        ]);

        $imagePath = $pcRakitan->image;
        if ($request->hasFile('image_upload')) {
            if ($pcRakitan->image && str_starts_with($pcRakitan->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $pcRakitan->image));
            }
            $path = $request->file('image_upload')->store('pc-rakitans', 'public');
            $imagePath = Storage::url($path);
        } elseif (!empty($validated['image'])) {
            $imagePath = $validated['image'];
        }

        $dataToUpdate = $validated;
        $dataToUpdate['image'] = $imagePath;
        $dataToUpdate['specs'] = json_decode($validated['specs'], true) ?? [];
        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->withErrors(['specs' => 'Format JSON untuk spesifikasi tidak valid.'])->withInput();
        }

        $pcRakitan->update($dataToUpdate);
        return redirect()->route('pc-rakitans.index')->with('success', 'Paket Rakitan berhasil diperbarui.');
    }

    public function destroy(PcRakitan $pcRakitan)
    {
        if ($pcRakitan->image && str_starts_with($pcRakitan->image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $pcRakitan->image));
        }
        $pcRakitan->delete();
        return redirect()->route('pc-rakitans.index')->with('success', 'Paket Rakitan berhasil dihapus.');
    }
}