@extends('layouts.admin')

@section('title', 'Edit Paket Rakitan')

@section('content')
    <h2 class="section-title-bs">Edit Paket: {{ $pcRakitan->name }}</h2>

    @if ($errors->any())
        <div class="errors" style="margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="admin-card-bs p-4" action="{{ route('pc-rakitans.update', $pcRakitan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Paket</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $pcRakitan->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <select name="category" id="category" class="form-control" required>
                <option value="" disabled>-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    @php $selectedCategory = old('category', $pcRakitan->category); @endphp
                    <option value="{{ $category }}" @if($selectedCategory == $category) selected @endif>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $pcRakitan->price) }}" required min="0">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Singkat</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $pcRakitan->description) }}</textarea>
        </div>

        <div class="mb-3">
            <p><strong>Gambar Saat Ini:</strong></p>
            <img src="{{ $pcRakitan->image }}" alt="Current Image" style="max-width: 200px; border-radius: 8px;">
        </div>
        <div class="mb-3">
            <label class="form-label">Sumber Gambar Baru</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="image_source_type" id="source_url" value="url" checked>
                <label class="form-check-label" for="source_url">Ganti dengan Link (URL)</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="image_source_type" id="source_upload" value="upload">
                <label class="form-check-label" for="source_upload">Ganti dengan Upload File</label>
            </div>
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

        <div class="mb-3">
            <label for="specs" class="form-label">Spesifikasi (Format JSON)</label>
            <textarea name="specs" id="specs" class="form-control" rows="6" required>{{ old('specs', json_encode($pcRakitan->specs, JSON_PRETTY_PRINT)) }}</textarea>
            <small class="form-text text-muted">Gunakan format JSON key-value.</small>
        </div>
        
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