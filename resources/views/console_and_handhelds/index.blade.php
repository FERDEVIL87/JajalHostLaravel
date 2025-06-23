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

    @php
        $sort = request('sort', 'name');
        $dir = request('dir', 'asc');
        function sort_link_console($label, $col) {
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
                    <th>{!! sort_link_console('Gambar', 'image') !!}</th>
                    <th>{!! sort_link_console('Nama', 'name') !!}</th>
                    <th>{!! sort_link_console('Brand', 'brand') !!}</th>
                    <th>{!! sort_link_console('Kategori', 'category') !!}</th>
                    <th>{!! sort_link_console('Harga', 'price') !!}</th>
                    <th>{!! sort_link_console('Spesifikasi', 'specs') !!}</th>
                    <th>{!! sort_link_console('Stok', 'stock') !!}</th>
                    <th style="width: 15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sorted = $consoles->sortBy(function($console) use ($sort) {
                        if ($sort === 'specs') {
                            return is_array($console->specs) ? implode(' ', $console->specs) : '';
                        }
                        return $console->{$sort};
                    }, SORT_REGULAR, $dir === 'desc');
                @endphp
                @forelse ($sorted as $console)
                    <tr>
                        <td>
                            <img src="{{ $console->image }}" alt="{{ $console->name }}" style="max-width: 60px; border-radius: 4px;">
                        </td>
                        <td>{{ $console->name }}</td>
                        <td>{{ $console->brand }}</td>
                        <td>{{ $console->category }}</td>
                        <td>Rp {{ number_format($console->price, 0, ',', '.') }}</td>
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
                    <tr><td colspan="8" class="text-center">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection