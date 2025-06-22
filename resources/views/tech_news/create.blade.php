{{-- /resources/views/tech_news/create.blade.php --}}
@extends('layouts.admin')
@section('title', 'Tambah Berita Baru')
@section('content')
    <h2 class="section-title-bs">Tambah Berita Baru</h2>

    <!-- ========================================================== -->
    <!-- TAMBAHKAN BLOK INI UNTUK MENAMPILKAN ERROR -->
    <!-- ========================================================== -->
    @if ($errors->any())
        <div class="errors" style="margin-bottom: 20px; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 1rem; border-radius: 8px;">
            <strong style="color: #721c24;">Whoops! Ada beberapa masalah dengan input Anda.</strong>
            <ul style="color: #721c24; margin-top: 0.5rem; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- ========================================================== -->

    {{-- PENTING: Tambahkan enctype="multipart/form-data" --}}
    <form class="admin-card-bs p-4" action="{{ route('tech-news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3"><label class="form-label">Judul</label><input type="text" name="title" class="form-control" value="{{ old('title') }}" required></div>
        <div class="mb-3"><label class="form-label">Kutipan (Excerpt)</label><textarea name="excerpt" class="form-control" rows="3" required>{{ old('excerpt') }}</textarea></div>
        <div class="mb-3"><label class="form-label">Tanggal</label><input type="date" name="date" class="form-control" value="{{ old('date') }}" required></div>
        <div class="mb-3"><label class="form-label">Sumber</label><input type="text" name="source" class="form-control" value="{{ old('source') }}" required></div>
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
            <label for="imageUrl" class="form-label">URL Gambar</label>
            <input type="text" name="imageUrl" id="imageUrl" class="form-control" value="{{ old('imageUrl') }}">
        </div>
        <div id="image-upload-group" class="mb-3" style="display: none;">
            <label for="image_upload" class="form-label">Upload File Gambar</label>
            <input type="file" name="image_upload" id="image_upload" class="form-control" accept="image/*">
        </div>
        <!-- ========================================================== -->
        <div class="mb-3"><label class="form-label">URL Baca Selengkapnya</label><input type="text" name="readMoreUrl" class="form-control" value="{{ old('readMoreUrl') }}"></div>
        <button type="submit" class="login-btn-bs w-100">Simpan</button>
    </form>
    {{-- Script untuk beralih input --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlRadio = document.getElementById('source_url');
            const uploadRadio = document.getElementById('source_upload');
            const urlGroup = document.getElementById('image-url-group');
            const uploadGroup = document.getElementById('image-upload-group');
            const urlInput = document.getElementById('imageUrl');
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
            toggleInputs(); // Panggil saat halaman dimuat
        });
    </script>
@endsection