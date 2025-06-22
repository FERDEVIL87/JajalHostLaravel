@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>

    <div class="mb-3">
        <a href="{{ route('pc-parts.index') }}" class="btn btn-primary">PC Parts</a>
        <a href="{{ route('laptops.index') }}" class="btn btn-secondary">Laptops</a>
        <!-- ...tombol lain di sini -->
    </div>

    <!-- ...konten lain di sini -->
</div>
@endsection