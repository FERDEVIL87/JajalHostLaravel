@extends('layouts.admin')

@section('title', 'Edit Laptop')

@section('content')
    <h2 class="section-title-bs">Edit Data: {{ $laptop->name }}</h2>

    {{-- Tampilkan error validasi jika ada --}}
    @if ($errors->any())
        <div class="errors" style="margin-bottom: 20px;">
            <strong>Whoops! Ada beberapa masalah dengan input Anda.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="admin-card-bs p-4" action="{{ route('laptops.update', $laptop->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Penting untuk memberitahu Laravel ini adalah request UPDATE --}}

        {{-- Field Nama --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama Laptop</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $laptop->name) }}" required>
        </div>

        {{-- Field Brand --}}
        <div class="mb-3">
            <label for="brand" class="form-label">Brand</label>
            <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand', $laptop->brand) }}" required>
        </div>
        
        {{-- Field Kategori dengan Dropdown --}}
        @php $selectedCategory = old('category', $laptop->category); @endphp
        <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <select name="category" id="category" class="form-control" required>
                <option value="" disabled @if($selectedCategory == '') selected @endif>-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" @if($selectedCategory == $category) selected @endif>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
        </div>
        
        {{-- Field Harga --}}
        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $laptop->price) }}" required min="0">
        </div>

        {{-- Field Stok --}}
        <div class="mb-3">
            <label for="stock" class="form-label">Stok</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $laptop->stock) }}" required min="0">
        </div>

        {{-- Field Deskripsi --}}
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi / Spesifikasi</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $laptop->description) }}</textarea>
        </div>

        {{-- Menampilkan Gambar Saat Ini --}}
        <div class="mb-3">
            <p><strong>Gambar Saat Ini:</strong></p>
            <img src="{{ $laptop->image }}" alt="Current Image" style="max-width: 200px; border-radius: 8px;">
        </div>

        {{-- Pilihan Sumber Gambar Baru --}}
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

        {{-- Input URL Gambar Baru --}}
        <div id="image-url-group" class="mb-3">
            <label for="image" class="form-label">Ganti dengan URL Gambar Baru</label>
            <input type="text" name="image" id="image" class="form-control">
            <small>Kosongkan jika tidak ingin mengganti gambar.</small>
        </div>

        {{-- Upload File Gambar Baru --}}
        <div id="image-upload-group" class="mb-3" style="display: none;">
            <label for="image_upload" class="form-label">Ganti dengan Upload File Baru</label>
            <input type="file" name="image_upload" id="image_upload" class="form-control" accept="image/*">
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