<?php
namespace App\Http\Controllers;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- Impor Storage

class BannerController extends Controller {
    public function index() {
        $banners = Banner::orderBy('order_column')->get();
        return view('banners.index', compact('banners'));
    }

    public function create() {
        return view('banners.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'slogan' => 'required|string',
            // Gunakan aturan 'file' untuk upload, dan 'url' untuk link. 'required_without' berarti salah satu wajib diisi.
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Upload file, maks 2MB
            'imageSrc' => 'nullable|url|required_without:image_upload', // Link URL
            'features' => 'required|string',
            'order_column' => 'required|integer',
            'is_active' => 'sometimes|boolean',
        ], [
            'imageSrc.required_without' => 'Anda harus mengisi URL Gambar atau mengunggah file gambar.'
        ]);

        $imagePath = null;

        // LOGIKA BARU: Cek apakah ada file yang di-upload
        if ($request->hasFile('image_upload')) {
            // Simpan file ke storage/app/public/banners dan dapatkan path-nya
            $path = $request->file('image_upload')->store('banners', 'public');
            // Dapatkan URL yang bisa diakses publik
            $imagePath = Storage::url($path);
        } else {
            // Jika tidak ada upload, gunakan URL dari input teks
            $imagePath = $validated['imageSrc'];
        }
        
        // Siapkan data untuk disimpan
        $dataToStore = $validated;
        $dataToStore['imageSrc'] = $imagePath;
        $dataToStore['features'] = array_filter(array_map('trim', explode("\n", $validated['features'])));
        $dataToStore['is_active'] = $request->has('is_active');

        Banner::create($dataToStore);
        return redirect()->route('banners.index')->with('success', 'Banner berhasil ditambahkan.');
    }

    public function edit(Banner $banner) {
        return view('banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner) {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'slogan' => 'required|string',
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'imageSrc' => 'nullable|url',
            'features' => 'required|string',
            'order_column' => 'required|integer',
            'is_active' => 'sometimes|boolean',
        ]);
        
        $imagePath = $banner->imageSrc; // Gunakan gambar lama sebagai default

        if ($request->hasFile('image_upload')) {
            // Hapus gambar lama jika ada dan jika itu bukan URL eksternal
            if ($banner->imageSrc && str_starts_with($banner->imageSrc, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $banner->imageSrc));
            }
            // Simpan gambar baru
            $path = $request->file('image_upload')->store('banners', 'public');
            $imagePath = Storage::url($path);
        } elseif (!empty($validated['imageSrc'])) {
            // Jika pengguna mengisi URL baru, gunakan itu
            $imagePath = $validated['imageSrc'];
        }
        
        $dataToUpdate = $validated;
        $dataToUpdate['imageSrc'] = $imagePath;
        $dataToUpdate['features'] = array_filter(array_map('trim', explode("\n", $validated['features'])));
        $dataToUpdate['is_active'] = $request->has('is_active');
        
        $banner->update($dataToUpdate);
        return redirect()->route('banners.index')->with('success', 'Banner berhasil diperbarui.');
    }

    public function destroy(Banner $banner) {
        $banner->delete();
        return redirect()->route('banners.index')->with('success', 'Banner berhasil dihapus.');
    }
}