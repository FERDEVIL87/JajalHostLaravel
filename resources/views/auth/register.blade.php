@extends('layouts.app')

@section('title', 'Registrasi User')

@section('content')
    <h2>Registrasi Admin</h2>

    @if($errors->any())
        <div class="errors">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('register') }}" method="post">
        @csrf
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="password_confirmation">Konfirmasi Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div>
            <button type="submit">Daftar</button>
        </div>
        <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
    </form>
@endsection