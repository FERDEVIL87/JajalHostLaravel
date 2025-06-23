@extends('layouts.admin')

@section('title', 'Manajemen Paket Rakitan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title-bs mb-0">Manajemen Paket PC Rakitan</h2>
        <a href="{{ route('pc-rakitans.create') }}" class="btn">Tambah Paket Baru</a>
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
        function sort_link_paket($label, $col) {
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
                    <th>{!! sort_link_paket('Gambar', 'image') !!}</th>
                    <th>{!! sort_link_paket('Nama Paket', 'name') !!}</th>
                    <th>{!! sort_link_paket('Kategori', 'category') !!}</th>
                    <th>{!! sort_link_paket('Harga', 'price') !!}</th>
                    <th>{!! sort_link_paket('Spesifikasi Utama', 'specs') !!}</th>
                    <th style="width: 15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sorted = $pakets->sortBy(function($paket) use ($sort) {
                        if ($sort === 'specs') {
                            return is_array($paket->specs) ? implode(' ', array_keys($paket->specs)) : '';
                        }
                        return $paket->{$sort};
                    }, SORT_REGULAR, $dir === 'desc');
                @endphp
                @forelse ($sorted as $paket)
                    <tr>
                        <td>
                            <img src="{{ $paket->image }}" alt="{{ $paket->name }}" style="max-width: 70px; margin-right: 15px; border-radius: 4px;">
                        </td>
                        <td>{{ $paket->name }}</td>
                        <td>{{ $paket->category }}</td>
                        <td>Rp {{ number_format($paket->price, 0, ',', '.') }}</td>
                        <td>
                            @if(is_array($paket->specs) && !empty($paket->specs))
                                <ul class="list-unstyled mb-0" style="font-size: 0.85rem;">
                                    @foreach(array_slice($paket->specs, 0, 3) as $key => $value)
                                        <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                                    @endforeach
                                    @if(count($paket->specs) > 3)
                                        <li>...</li>
                                    @endif
                                </ul>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('pc-rakitans.edit', $paket->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('pc-rakitans.destroy', $paket->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data paket rakitan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection