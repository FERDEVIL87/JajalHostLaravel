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

    @php
        $sort = request('sort', 'name');
        $dir = request('dir', 'asc');
        function sort_link_pcpart($label, $col) {
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
                    <th>{!! sort_link_pcpart('Gambar', 'image') !!}</th>
                    <th>{!! sort_link_pcpart('Nama', 'name') !!}</th>
                    <th>{!! sort_link_pcpart('Brand', 'brand') !!}</th>
                    <th>{!! sort_link_pcpart('Kategori', 'category') !!}</th>
                    <th>{!! sort_link_pcpart('Harga', 'price') !!}</th>
                    <th>{!! sort_link_pcpart('Spesifikasi', 'specs') !!}</th>
                    <th>{!! sort_link_pcpart('Stok', 'stock') !!}</th>
                    <th style="width: 15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sorted = $pcParts->sortBy(function($part) use ($sort) {
                        if ($sort === 'specs') {
                            return is_array($part->specs) ? implode(' ', $part->specs) : '';
                        }
                        return $part->{$sort};
                    }, SORT_REGULAR, $dir === 'desc');
                @endphp
                @forelse ($sorted as $part)
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