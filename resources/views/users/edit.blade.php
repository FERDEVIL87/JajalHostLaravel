@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <h2 class="section-title-bs">Edit User: {{ $user->username }}</h2>

    @if ($errors->any())
        <div class="errors" style="margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="admin-card-bs p-4" action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Penting untuk request UPDATE --}}

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-control" required>
                @php $selectedRole = old('role', $user->role); @endphp
                <option value="user" @if($selectedRole == 'user') selected @endif>User</option>
                <option value="admin" @if($selectedRole == 'admin') selected @endif>Admin</option>
            </select>
        </div>

        <hr style="border-color: #2d3748;">
        <p class="text-muted">Kosongkan password jika tidak ingin mengubahnya.</p>
        
        <div class="mb-3">
            <label for="password" class="form-label">Password Baru</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>
        
        <button type="submit" class="login-btn-bs w-100">Simpan Perubahan</button>
    </form>
@endsection