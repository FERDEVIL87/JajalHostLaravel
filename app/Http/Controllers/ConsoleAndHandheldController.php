<?php

namespace App\Http\Controllers;

use App\Models\ConsoleAndHandheld;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConsoleAndHandheldController extends Controller
{
    /**
     * Daftar kategori yang tersedia.
     */
    private $categories = [
        "PlayStation Powerhouse",
        "Xbox Universe",
        "Nintendo Magic",
        "Handheld PC Heroes",
        "Explore More Consoles",
    ];

    public function index()
    {
        $consoles = ConsoleAndHandheld::latest()->get();
        return view('console_and_handhelds.index', compact('consoles'));
    }

    public function create()
    {
        // Kirim daftar kategori ke view
        return view('console_and_handhelds.create', ['categories' => $this->categories]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'brand' => 'required|string|max:255',
            'category' => 'required|in:' . implode(',', $this->categories),
            'specs' => 'required|string',
            'stock' => 'required|string',
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image' => 'nullable|url|required_without:image_upload',
        ], [
            'image.required_without' => 'Anda harus mengisi URL Gambar atau mengunggah file gambar.'
        ]);

        $imagePath = null;
        if ($request->hasFile('image_upload')) {
            $path = $request->file('image_upload')->store('consoles', 'public');
            $imagePath = Storage::url($path);
        } else {
            $imagePath = $validated['image'];
        }

        $dataToStore = $validated;
        $dataToStore['image'] = $imagePath;
        $dataToStore['specs'] = array_filter(array_map('trim', explode("\n", $validated['specs'])));

        ConsoleAndHandheld::create($dataToStore);

        return redirect()->route('console-and-handhelds.index')->with('success', 'Data konsol berhasil ditambahkan.');
    }

    public function edit(ConsoleAndHandheld $consoleAndHandheld)
    {
        $console = $consoleAndHandheld;
        // Kirim daftar kategori dan data konsol ke view
        return view('console_and_handhelds.edit', [
            'console' => $console,
            'categories' => $this->categories
        ]);
    }

    public function update(Request $request, ConsoleAndHandheld $consoleAndHandheld)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'brand' => 'required|string|max:255',
            'category' => 'required|in:' . implode(',', $this->categories),
            'specs' => 'required|string',
            'stock' => 'required|string',
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image' => 'nullable|url',
        ]);

        $imagePath = $consoleAndHandheld->image;
        if ($request->hasFile('image_upload')) {
            if ($consoleAndHandheld->image && str_starts_with($consoleAndHandheld->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $consoleAndHandheld->image));
            }
            $path = $request->file('image_upload')->store('consoles', 'public');
            $imagePath = Storage::url($path);
        } elseif (!empty($validated['image'])) {
            $imagePath = $validated['image'];
        }

        $dataToUpdate = $validated;
        $dataToUpdate['image'] = $imagePath;
        $dataToUpdate['specs'] = array_filter(array_map('trim', explode("\n", $validated['specs'])));

        $consoleAndHandheld->update($dataToUpdate);

        return redirect()->route('console-and-handhelds.index')->with('success', 'Data konsol berhasil diperbarui.');
    }

    public function destroy(ConsoleAndHandheld $consoleAndHandheld)
    {
        if ($consoleAndHandheld->image && str_starts_with($consoleAndHandheld->image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $consoleAndHandheld->image));
        }
        $consoleAndHandheld->delete();
        return redirect()->route('console-and-handhelds.index')->with('success', 'Data konsol berhasil dihapus.');
    }
}