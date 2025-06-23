@extends('layouts.admin')

@section('title', 'Dashboard Utama')

@section('content')
    {{-- Judul Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title-bs mb-0">Daftar Pengguna</h2>
        <a href="{{ route('users.create') }}" class="btn">Tambah User Baru</a>
    </div>

    {{-- Tampilkan pesan sukses atau error dari session --}}
    @if(session('success'))
        <div class="success" style="margin-bottom: 20px;"><p>{{ session('success') }}</p></div>
    @endif
    @if(session('error'))
        <div class="errors" style="margin-bottom: 20px;"><p>{{ session('error') }}</p></div>
    @endif
    
    @php
        $sort = request('sort', 'id');
        $dir = request('dir', 'asc');
        function sort_link_user($label, $col) {
            $currentSort = request('sort', 'id');
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

    {{-- Tabel Daftar User --}}
    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle table-bordered">
            <thead>
                <tr>
                    <th>{!! sort_link_user('ID', 'id') !!}</th>
                    <th>{!! sort_link_user('Username', 'username') !!}</th>
                    <th>{!! sort_link_user('Email', 'email') !!}</th>
                    <th>{!! sort_link_user('Role', 'role') !!}</th>
                    <th>{!! sort_link_user('Tanggal Daftar', 'created_at') !!}</th>
                    <th style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sorted = $users->sortBy(function($user) use ($sort) {
                        if ($sort === 'created_at') {
                            return $user->created_at;
                        }
                        return $user->{$sort};
                    }, SORT_REGULAR, $dir === 'desc');
                @endphp
                @forelse ($sorted as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn-edit">Edit</a>
                            {{-- Tombol Hapus hanya muncul jika user yang akan dihapus BUKAN user yang sedang login --}}
                            @if(auth()->id() !== $user->id)
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada user terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection