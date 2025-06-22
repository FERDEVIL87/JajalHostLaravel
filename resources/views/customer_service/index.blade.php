@extends('layouts.admin')

@section('title', 'Pesan Customer Service')

@section('content')
    <h2 class="section-title-bs">Pesan Masuk dari Customer</h2>

    @if(session('success'))
        <div class="success" style="margin-bottom: 20px;"><p>{{ session('success') }}</p></div>
    @endif

    @if($messages->isEmpty())
        <div class="alert alert-info" style="background-color: #1f2937; border-color: #00d9ff; color: #e8eff5;">
            Belum ada pesan yang masuk.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle table-bordered">
                <thead>
                    <tr>
                        <th style="width: 4%;">No</th>
                        <th style="width: 12%;">Tanggal Kirim</th>
                        <th style="width: 12%;">Nama</th>
                        <th style="width: 16%;">Email</th>
                        <th style="width: 36%;">Pesan</th>
                        <th style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $index => $message)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $message->created_at->format('d M Y, H:i') }}</td>
                            <td>{{ $message->nama }}</td>
                            <td>{{ $message->email }}</td>
                            <td style="white-space: pre-wrap;">{{ $message->pesan }}</td>
                            <td>
                                {{-- ========================================================== --}}
                                <!-- FORM DAN TOMBOL HAPUS -->
                                {{-- ========================================================== --}}
                                <form action="{{ route('customer-service.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                                {{-- ========================================================== --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection