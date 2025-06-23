@extends('layouts.admin')

@section('title', 'Pesan Customer Service')

@section('content')
    <h2 class="section-title-bs">Pesan Masuk dari Customer</h2>

    @if(session('success'))
        <div class="success" style="margin-bottom: 20px;"><p>{{ session('success') }}</p></div>
    @endif

    @php
        $sort = request('sort', 'created_at');
        $dir = request('dir', 'desc');
        function sort_link_cs($label, $col) {
            $currentSort = request('sort', 'created_at');
            $currentDir = request('dir', 'desc');
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

    @if($messages->isEmpty())
        <div class="alert alert-info" style="background-color: #1f2937; border-color: #00d9ff; color: #e8eff5;">
            Belum ada pesan yang masuk.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle table-bordered">
                <thead>
                    <tr>
                        <th style="width: 4%;">{!! sort_link_cs('No', 'no') !!}</th>
                        <th style="width: 12%;">{!! sort_link_cs('Tanggal Kirim', 'created_at') !!}</th>
                        <th style="width: 12%;">{!! sort_link_cs('Nama', 'nama') !!}</th>
                        <th style="width: 16%;">{!! sort_link_cs('Email', 'email') !!}</th>
                        <th style="width: 36%;">{!! sort_link_cs('Pesan', 'pesan') !!}</th>
                        <th style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sorted = $messages->sortBy(function($msg, $idx) use ($sort) {
                            if ($sort === 'no') return $idx;
                            if ($sort === 'created_at') return $msg->created_at;
                            return $msg->{$sort};
                        }, SORT_REGULAR, $dir === 'desc');
                    @endphp
                    @foreach($sorted->values() as $index => $message)
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