@extends('layouts.admin')
@section('title', 'Tambah Konsol & Handheld')
@section('content')
    <h2 class="section-title-bs">Tambah Data Konsol & Handheld</h2>
    @if ($errors->any())
        <div class="errors"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <form class="admin-card-bs p-4" action="{{ route('console-and-handhelds.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- Nama --}}
        <div class="mb-3"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
        {{-- Harga --}}
        <div class="mb-3"><label class="form-label">Harga</label><input type="number" name="price" class="form-control" value="{{ old('price') }}" required></div>
        {{-- Brand --}}
        <div class="mb-3"><label class="form-label">Brand</label><input type="text" name="brand" class="form-control" value="{{ old('brand') }}" required></div>
        {{-- Kategori --}}
        <div class="mb-3">
        <label for="category" class="form-label">Kategori</label>
    <select name="category" id="category" class="form-control" required>
        <option value="" disabled selected>-- Pilih Kategori --</option>
        @foreach($categories as $category)
        <option value="{{ $category }}" @if(old('category') == $category) selected @endif>
        {{ $category }}
        </option>
        @endforeach
    </select>
</div>
        <!-- ========================================================== -->
        <!-- BAGIAN GAMBAR YANG DIPERBARUI -->
        <!-- ========================================================== -->
        <div class="mb-3">
            <label class="form-label">Sumber Gambar</label>
            <div class="form-check"><input class="form-check-input" type="radio" name="image_source_type" id="source_url" value="url" checked><label class="form-check-label" for="source_url">Gunakan Link (URL)</label></div>
            <div class="form-check"><input class="form-check-input" type="radio" name="image_source_type" id="source_upload" value="upload"><label class="form-check-label" for="source_upload">Upload dari Komputer</label></div>
        </div>
        <div id="image-url-group" class="mb-3">
            <label for="image" class="form-label">URL Gambar</label>
            <input type="text" name="image" id="image" class="form-control" value="{{ old('image') }}">
        </div>
        <div id="image-upload-group" class="mb-3" style="display: none;">
            <label for="image_upload" class="form-label">Upload File Gambar</label>
            <input type="file" name="image_upload" id="image_upload" class="form-control" accept="image/*">
        </div>
        <!-- ========================================================== -->
        {{-- Specs --}}
        <div class="mb-3">
            <label class="form-label">Spesifikasi (Satu per Baris)</label>
            <textarea name="specs" class="form-control" rows="3" required>{{ old('specs') }}</textarea>
        </div>
        {{-- Stok --}}
        <div class="mb-3"><label class="form-label">Stok</label><input type="text" name="stock" class="form-control" value="{{ old('stock') }}" required></div>
        <button type="submit" class="login-btn-bs w-100">Simpan</button>
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