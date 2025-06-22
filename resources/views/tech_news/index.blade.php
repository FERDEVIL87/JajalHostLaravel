@extends('layouts.admin')
@section('title', 'Manajemen Berita Teknologi')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title-bs mb-0">Manajemen Berita Teknologi</h2>
        <a href="{{ route('tech-news.create') }}" class="btn">Tambah Berita Baru</a>
    </div>
    @if(session('success'))
        <div class="success" style="margin-bottom: 20px;"><p>{{ session('success') }}</p></div>
    @endif
    @if(session('error'))
        <div class="errors" style="margin-bottom: 20px;"><p>{{ session('error') }}</p></div>
    @endif
    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle table-bordered">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Tanggal</th>
                    <th>Judul</th>
                    <th>Sumber</th>
                    <th style="width: 15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($newsItems as $news)
                    <tr>
                        <td class="text-center">
                            @if($news->imageUrl)
                                <img src="{{ $news->imageUrl }}" alt="Gambar" style="max-width: 80px; max-height: 60px; border-radius: 6px;">
                            @else
                                <span style="color:#888;">-</span>
                            @endif
                        </td>
                        <td>{{ $news->date->format('d M Y') }}</td>
                        <td>{{ $news->title }}</td>
                        <td>{{ $news->source }}</td>
                        <td>
                            <a href="{{ route('tech-news.edit', $news->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('tech-news.destroy', $news->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Belum ada berita.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection