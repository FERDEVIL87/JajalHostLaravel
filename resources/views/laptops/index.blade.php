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

    @php
        $sort = request('sort', 'name');
        $dir = request('dir', 'asc');
        function sort_link_laptop($label, $col) {
            $currentSort = request('sort', 'name');
            $currentDir = request('dir', 'asc');
            $newDir = ($currentSort === $col && $currentDir === 'asc') ? 'desc' : 'asc';
            $icon = '';
            if ($currentSort === $col) {
                $icon = $currentDir === 'asc' ? '↑' : '↓';
            }
            $params = array_merge(request()->except(['sort', 'dir', 'page']), ['sort' => $col, 'dir' => $newDir]);
            $url = url()->current() . '?' . http_build_query($params);
            return '<a href="' . $url . '" style="color:#00d9ff;">' . $label . ' ' . $icon . '</a>';
        }
    @endphp

    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle table-bordered">
            <thead>
                <tr>
                    <th>{!! sort_link_laptop('Gambar', 'image') !!}</th>
                    <th>{!! sort_link_laptop('Nama', 'name') !!}</th>
                    <th>{!! sort_link_laptop('Brand', 'brand') !!}</th>
                    <th>{!! sort_link_laptop('Kategori', 'category') !!}</th>
                    <th>{!! sort_link_laptop('Harga', 'price') !!}</th>
                    <th>{!! sort_link_laptop('Stok', 'stock') !!}</th>
                    <th style="width: 15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sorted = $laptops->sortBy(function($laptop) use ($sort) {
                        return $laptop->{$sort};
                    }, SORT_REGULAR, $dir === 'desc');
                @endphp
                @forelse ($sorted as $laptop)
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