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
    
    {{-- Tabel Daftar User --}}
    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Tanggal Daftar</th>
                    <th style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
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