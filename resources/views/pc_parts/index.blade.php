@extends('layouts.admin')

@section('title', 'Daftar PC Parts')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title-bs mb-0">Daftar PC Part</h2>
        <a href="{{ route('pc-parts.create') }}" class="btn">Tambah PC Part Baru</a>
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
                    <th>Harga</th>
                    <th>Spesifikasi</th>
                    <th>Stok</th>
                    <th style="width: 15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pcParts as $part)
                    <tr>
                        <td><img src="{{ $part->image }}" alt="{{ $part->name }}" style="max-width:80px; border-radius: 4px;"></td>
                        <td>{{ $part->name }}</td>
                        <td>{{ $part->brand }}</td>
                        <td>{{ $part->category }}</td>
                        <td>Rp {{ number_format($part->price, 0, ',', '.') }}</td>
                        <td>
                            @if(!empty($part->specs))
                                <ul class="mb-0" style="font-size: 0.95em;">
                                    @foreach($part->specs as $spec)
                                        <li>{{ $spec }}</li>
                                    @endforeach
                                </ul>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $part->stock }}</td>
                        <td>
                            <a href="{{ route('pc-parts.edit', $part->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('pc-parts.destroy', $part->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data PC Part.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection