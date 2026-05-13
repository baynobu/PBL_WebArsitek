@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold">Proposal untuk: {{ $proposal->proyek->judul }}</h1>

    <div class="mt-4">
        <div><strong>Arsitek:</strong> {{ $proposal->arsitek->name ?? 'N/A' }}</div>
        <div><strong>Harga Tawaran:</strong> {{ number_format($proposal->harga_tawaran,0,',','.') }}</div>
        <div><strong>Estimasi Waktu:</strong> {{ $proposal->estimasi_waktu }} hari</div>
        <div class="mt-2"><strong>Deskripsi:</strong><p>{{ $proposal->deskripsi }}</p></div>
        <div class="mt-2"><strong>Status:</strong> {{ $proposal->status }}</div>
    </div>
</div>
@endsection
