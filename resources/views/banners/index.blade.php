@extends('layouts.admin')

@section('title', 'Manajemen Banner')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title-bs mb-0">Manajemen Banner Halaman Utama</h2>
        <a href="{{ route('banners.create') }}" class="btn">Tambah Banner Baru</a>
    </div>

    @php
        $sort = request('sort', 'order_column');
        $dir = request('dir', 'asc');
        function sort_link($label, $col) {
            $currentSort = request('sort', 'order_column');
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
                    <th>{!! sort_link('Urutan', 'order_column') !!}</th>
                    <th>{!! sort_link('Gambar', 'imageSrc') !!}</th>
                    <th>{!! sort_link('Brand & Nama', 'brand') !!}</th>
                    <th>{!! sort_link('Status', 'is_active') !!}</th>
                    <th style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sorted = $banners->sortBy(function($banner) use ($sort) {
                        // Support for nested sort (brand & name)
                        if ($sort === 'brand') {
                            return $banner->brand . ' ' . $banner->name;
                        }
                        return $banner->{$sort};
                    }, SORT_REGULAR, $dir === 'desc');
                @endphp
                @forelse ($sorted as $banner)
                    <tr>
                        <td>{{ $banner->order_column }}</td>
                        <td>
                            <img src="{{ $banner->imageSrc }}" alt="{{ $banner->name }}" style="max-width: 100px; border-radius: 4px;">
                        </td>
                        <td>
                            <strong>{{ $banner->brand }}</strong><br>
                            {{ $banner->name }}
                        </td>
                        <td>
                            @if($banner->is_active)
                                <span style="color: #28f57a;">Aktif</span>
                            @else
                                <span style="color: #ff4d4d;">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('banners.edit', $banner->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('banners.destroy', $banner->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus banner ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada banner yang ditambahkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection