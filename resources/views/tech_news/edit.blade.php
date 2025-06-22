@extends('layouts.admin')
@section('title', 'Edit Berita')
@section('content')
    <h2 class="section-title-bs">Edit Berita</h2>
    @if ($errors->any())
        <div class="errors"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <form class="admin-card-bs p-4" action="{{ route('tech-news.update', $techNews->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3"><label class="form-label">Judul</label><input type="text" name="title" class="form-control" value="{{ old('title', $techNews->title) }}" required></div>
        <div class="mb-3"><label class="form-label">Kutipan (Excerpt)</label><textarea name="excerpt" class="form-control" rows="3" required>{{ old('excerpt', $techNews->excerpt) }}</textarea></div>
        <div class="mb-3"><label class="form-label">Tanggal</label><input type="date" name="date" class="form-control" value="{{ old('date', $techNews->date) }}" required></div>
        <div class="mb-3"><label class="form-label">Sumber</label><input type="text" name="source" class="form-control" value="{{ old('source', $techNews->source) }}" required></div>
        <div class="mb-3">
            <p><strong>Gambar Saat Ini:</strong></p>
            <img src="{{ $techNews->imageUrl }}" alt="Current Image" style="max-width: 200px; border-radius: 8px;">
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
            <label for="imageUrl" class="form-label">Ganti dengan URL Gambar Baru</label>
            <input type="text" name="imageUrl" id="imageUrl" class="form-control">
            <small>Kosongkan jika tidak ingin mengganti gambar.</small>
        </div>
        <div id="image-upload-group" class="mb-3" style="display: none;">
            <label for="image_upload" class="form-label">Ganti dengan Upload File Baru</label>
            <input type="file" name="image_upload" id="image_upload" class="form-control" accept="image/*">
        </div>
        <div class="mb-3"><label class="form-label">URL Baca Selengkapnya</label><input type="text" name="readMoreUrl" class="form-control" value="{{ old('readMoreUrl', $techNews->readMoreUrl) }}"></div>
        <button type="submit" class="login-btn-bs w-100">Simpan Perubahan</button>
    </form>
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
            toggleInputs();
        });
    </script>
@endsection
