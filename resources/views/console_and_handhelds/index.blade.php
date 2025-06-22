@extends('layouts.admin')
@section('title', 'Daftar Konsol & Handheld')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title-bs mb-0">Daftar Konsol & Handheld</h2>
        <a href="{{ route('console-and-handhelds.create') }}" class="btn">Tambah Data Baru</a>
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
                    <th>Nama</th>
                    <th>Brand</th>
                    <th>Kategori</th>
                    <th>Spesifikasi</th>
                    <th>Stok</th>
                    <th style="width: 15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($consoles as $console)
                    <tr>
                        <td>
                            <img src="{{ $console->image }}" alt="{{ $console->name }}" style="max-width: 60px; border-radius: 4px;">
                        </td>
                        <td>{{ $console->name }}</td>
                        <td>{{ $console->brand }}</td>
                        <td>{{ $console->category }}</td>
                        <td>
                            <ul class="mb-0" style="font-size: 0.95em;">
                                @foreach($console->specs as $spec)
                                    <li>{{ $spec }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $console->stock }}</td>
                        <td>
                            <a href="{{ route('console-and-handhelds.edit', $console->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('console-and-handhelds.destroy', $console->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection