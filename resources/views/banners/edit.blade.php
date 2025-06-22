@extends('layouts.admin')

@section('title', 'Edit Banner')

@section('content')
    <h2 class="section-title-bs">Edit Banner: {{ $banner->name }}</h2>

    @if ($errors->any())
        <div class="errors" style="margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="admin-card-bs p-4" action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3"><label class="form-label">Brand</label><input type="text" name="brand" class="form-control" value="{{ old('brand', $banner->brand) }}" required></div>
        <div class="mb-3"><label class="form-label">Nama Produk</label><input type="text" name="name" class="form-control" value="{{ old('name', $banner->name) }}" required></div>
        <div class="mb-3"><label class="form-label">Slogan</label><input type="text" name="slogan" class="form-control" value="{{ old('slogan', $banner->slogan) }}" required></div>
        <div class="mb-3">
            <p><strong>Gambar Saat Ini:</strong></p>
            <img src="{{ $banner->imageSrc }}" alt="Current Banner" style="max-width: 200px; border-radius: 8px;">
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
            <label for="imageSrc" class="form-label">Ganti dengan URL Gambar Baru</label>
            <input type="text" name="imageSrc" id="imageSrc" class="form-control" value="{{ old('imageSrc') }}">
            <small>Kosongkan jika tidak ingin mengganti gambar.</small>
        </div>
        <div id="image-upload-group" class="mb-3" style="display: none;">
            <label for="image_upload" class="form-label">Ganti dengan Upload File Baru</label>
            <input type="file" name="image_upload" id="image_upload" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label class="form-label">Fitur Unggulan (Satu per Baris)</label>
            <textarea name="features" class="form-control" rows="3" required>{{ old('features', implode("\n", $banner->features ?? [])) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Urutan Tampil</label>
            <input type="number" name="order_column" class="form-control" value="{{ old('order_column', $banner->order_column) }}" required>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" @if(old('is_active', $banner->is_active)) checked @endif>
            <label class="form-check-label" for="is_active">
                Aktifkan Banner ini
            </label>
        </div>

        <button type="submit" class="login-btn-bs w-100">Simpan Perubahan</button>
    </form>

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