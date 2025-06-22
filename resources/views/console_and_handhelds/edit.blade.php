@extends('layouts.admin')
@section('title', 'Edit Konsol & Handheld')
@section('content')
    <h2 class="section-title-bs">Edit Data: {{ $console->name }}</h2>
    @if ($errors->any())
        <div class="errors"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <form class="admin-card-bs p-4" action="{{ route('console-and-handhelds.update', $console->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        {{-- Nama --}}
        <div class="mb-3"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" value="{{ old('name', $console->name) }}" required></div>
        {{-- Harga --}}
        <div class="mb-3"><label class="form-label">Harga</label><input type="number" name="price" class="form-control" value="{{ old('price', $console->price) }}" required></div>
        {{-- Brand --}}
        <div class="mb-3"><label class="form-label">Brand</label><input type="text" name="brand" class="form-control" value="{{ old('brand', $console->brand) }}" required></div>
        {{-- Kategori --}}
        <div class="mb-3"><label class="form-label">Kategori</label><input type="text" name="category" class="form-control" value="{{ old('category', $console->category) }}" required></div>
        {{-- Gambar --}}
        <div class="mb-3">
            <p><strong>Gambar Saat Ini:</strong></p>
            <img src="{{ $console->image }}" alt="Current Image" style="max-width: 200px; border-radius: 8px;">
        </div>
        <div class="mb-3">
            <label class="form-label">Sumber Gambar Baru</label>
            <div class="form-check"><input class="form-check-input" type="radio" name="image_source_type" id="source_url" value="url" checked><label class="form-check-label" for="source_url">Ganti dengan Link (URL)</label></div>
            <div class="form-check"><input class="form-check-input" type="radio" name="image_source_type" id="source_upload" value="upload"><label class="form-check-label" for="source_upload">Ganti dengan Upload File</label></div>
        </div>
        <div id="image-url-group" class="mb-3">
            <label for="image" class="form-label">Ganti dengan URL Gambar Baru</label>
            <input type="text" name="image" id="image" class="form-control">
            <small>Kosongkan jika tidak ingin mengganti gambar.</small>
        </div>
        <div id="image-upload-group" class="mb-3" style="display: none;">
            <label for="image_upload" class="form-label">Ganti dengan Upload File Baru</label>
            <input type="file" name="image_upload" id="image_upload" class="form-control" accept="image/*">
        </div>
        {{-- Specs --}}
        <div class="mb-3">
            <label class="form-label">Spesifikasi (Satu per Baris)</label>
            <textarea name="specs" class="form-control" rows="3" required>{{ old('specs', implode("\n", $console->specs)) }}</textarea>
        </div>
        {{-- Stok --}}
        <div class="mb-3"><label class="form-label">Stok</label><input type="text" name="stock" class="form-control" value="{{ old('stock', $console->stock) }}" required></div>
        <button type="submit" class="login-btn-bs w-100">Simpan Perubahan</button>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlRadio = document.getElementById('source_url');
            const uploadRadio = document.getElementById('source_upload');
            const urlGroup = document.getElementById('image-url-group');
            const uploadGroup = document.getElementById('image-upload-group');
            const urlInput = document.getElementById('image');
            const uploadInput = document.getElementById('image_upload');
            function toggleInputs() {
                if (urlRadio.checked) {
                    urlGroup.style.display = 'block';
                    uploadGroup.style.display = 'none';
                    uploadInput.value = '';
                } else {
                    urlGroup.style.display = 'none';
                    uploadGroup.style.display = 'block';
                    urlInput.value = '';
                }
            }
            urlRadio.addEventListener('change', toggleInputs);
            uploadRadio.addEventListener('change', toggleInputs);
            toggleInputs();
        });
    </script>
@endsection