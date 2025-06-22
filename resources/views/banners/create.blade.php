@extends('layouts.admin')

@section('title', 'Tambah Banner Baru')

@section('content')
    <h2 class="section-title-bs">Tambah Banner Baru</h2>

    @if ($errors->any())
        <div class="errors" style="margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- PENTING: Tambahkan enctype="multipart/form-data" untuk upload file --}}
    <form class="admin-card-bs p-4" action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3"><label class="form-label">Brand</label><input type="text" name="brand" class="form-control" value="{{ old('brand') }}" required></div>
        <div class="mb-3"><label class="form-label">Nama Produk</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
        <div class="mb-3"><label class="form-label">Slogan</label><input type="text" name="slogan" class="form-control" value="{{ old('slogan') }}" required></div>
        <!-- ========================================================== -->
        <!-- BAGIAN GAMBAR YANG DIPERBARUI -->
        <!-- ========================================================== -->
        <div class="mb-3">
            <label class="form-label">Sumber Gambar</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="image_source_type" id="source_url" value="url" checked>
                <label class="form-check-label" for="source_url">Gunakan Link (URL)</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="image_source_type" id="source_upload" value="upload">
                <label class="form-check-label" for="source_upload">Upload dari Komputer</label>
            </div>
        </div>

        <div id="image-url-group" class="mb-3">
            <label for="imageSrc" class="form-label">URL Gambar</label>
            <input type="text" name="imageSrc" id="imageSrc" class="form-control" value="{{ old('imageSrc') }}">
        </div>

        <div id="image-upload-group" class="mb-3" style="display: none;">
            <label for="image_upload" class="form-label">Upload File Gambar</label>
            <input type="file" name="image_upload" id="image_upload" class="form-control" accept="image/*">
        </div>
        <!-- ========================================================== -->
        <div class="mb-3">
            <label class="form-label">Fitur Unggulan (Satu per Baris)</label>
            <textarea name="features" class="form-control" rows="3" required>{{ old('features') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Urutan Tampil</label>
            <input type="number" name="order_column" class="form-control" value="{{ old('order_column', 0) }}" required>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
            <label class="form-check-label" for="is_active">
                Aktifkan Banner ini
            </label>
        </div>
        
        <button type="submit" class="login-btn-bs w-100">Simpan Banner</button>
    </form>

    {{-- Script untuk beralih input --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlRadio = document.getElementById('source_url');
            const uploadRadio = document.getElementById('source_upload');
            const urlGroup = document.getElementById('image-url-group');
            const uploadGroup = document.getElementById('image-upload-group');
            const urlInput = document.getElementById('imageSrc');
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
        });
    </script>
@endsection