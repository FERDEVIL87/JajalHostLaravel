<?php
namespace App\Http\Controllers;
use App\Models\TechNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- Impor Storage

class TechNewsController extends Controller
{
    public function index() {
        $newsItems = TechNews::latest('date')->get();
        return view('tech_news.index', compact('newsItems'));
    }

    public function create() {
        return view('tech_news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'date' => 'required|date',
            'source' => 'required|string|max:255',
            'readMoreUrl' => 'nullable|url',
            // Aturan validasi baru untuk gambar
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'imageUrl' => 'nullable|url|required_without:image_upload',
        ], [
            'imageUrl.required_without' => 'Anda harus mengisi URL Gambar atau mengunggah file gambar.'
        ]);

        $imagePath = null;

        // Logika untuk menangani upload file atau link
        if ($request->hasFile('image_upload')) {
            $path = $request->file('image_upload')->store('tech-news', 'public');
            $imagePath = Storage::url($path);
        } else {
            $imagePath = $validated['imageUrl'];
        }
        
        // Siapkan data untuk disimpan
        $dataToStore = $validated;
        $dataToStore['imageUrl'] = $imagePath; // Timpa imageUrl dengan path yang benar

        TechNews::create($dataToStore);
        return redirect()->route('tech-news.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(TechNews $techNews)
    {
        return view('tech_news.edit', compact('techNews'));
    }

    public function update(Request $request, TechNews $techNews)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'date' => 'required|date',
            'source' => 'required|string|max:255',
            'readMoreUrl' => 'nullable|url',
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'imageUrl' => 'nullable|url',
        ]);

        $imagePath = $techNews->imageUrl; // Gunakan gambar lama sebagai default

        if ($request->hasFile('image_upload')) {
            // Hapus gambar lama jika ada dan jika itu file lokal
            if ($techNews->imageUrl && str_starts_with($techNews->imageUrl, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $techNews->imageUrl));
            }
            // Simpan gambar baru
            $path = $request->file('image_upload')->store('tech-news', 'public');
            $imagePath = Storage::url($path);
        } elseif (!empty($validated['imageUrl'])) {
            // Jika pengguna mengisi URL baru, gunakan itu
            $imagePath = $validated['imageUrl'];
        }

        $dataToUpdate = $validated;
        $dataToUpdate['imageUrl'] = $imagePath;
        
        $techNews->update($dataToUpdate);
        return redirect()->route('tech-news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(TechNews $techNews)
    {
        // Jangan lupa hapus gambar saat berita dihapus
        if ($techNews->imageUrl && str_starts_with($techNews->imageUrl, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $techNews->imageUrl));
        }
        $techNews->delete();
        return redirect()->route('tech-news.index')->with('success', 'Berita berhasil dihapus.');
    }
}