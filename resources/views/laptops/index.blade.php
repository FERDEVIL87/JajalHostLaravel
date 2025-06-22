@extends('layouts.admin')

@section('title', 'Manajemen Laptop')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title-bs mb-0">Manajemen Data Laptop</h2>
        <a href="{{ route('laptops.create') }}" class="btn">Tambah Laptop Baru</a>
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
                    <th>Stok</th>
                    <th style="width: 15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laptops as $laptop)
                    <tr>
                        <td>
                            <img src="{{ $laptop->image }}" alt="{{ $laptop->name }}" style="max-width: 60px; border-radius: 4px;">
                        </td>
                        <td>{{ $laptop->name }}</td>
                        <td>{{ $laptop->brand }}</td>
                        <td>{{ $laptop->category }}</td>
                        <td>Rp {{ number_format($laptop->price, 0, ',', '.') }}</td>
                        <td>{{ $laptop->stock }}</td>
                        <td>
                            <a href="{{ route('laptops.edit', $laptop->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('laptops.destroy', $laptop->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data laptop.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection