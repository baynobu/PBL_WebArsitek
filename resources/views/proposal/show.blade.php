@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    @if(session('success'))
        <div class="mb-4 rounded border border-green-300 bg-green-50 p-3 text-green-700">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-red-700">{{ session('error') }}</div>
    @endif

    <h1 class="text-2xl font-bold">Proposal untuk: {{ $proposal->proyek->judul }}</h1>

    <div class="mt-4">
        <div><strong>Arsitek:</strong> {{ $proposal->arsitek->name ?? 'N/A' }}</div>
        <div><strong>Harga Tawaran:</strong> {{ number_format($proposal->harga_tawaran,0,',','.') }}</div>
        <div><strong>Estimasi Waktu:</strong> {{ $proposal->estimasi_waktu }} hari</div>
        <div class="mt-2"><strong>Deskripsi:</strong><p>{{ $proposal->deskripsi }}</p></div>
        <div class="mt-2"><strong>Status:</strong> {{ $proposal->status }}</div>
    </div>

    @if(auth()->id() === $proposal->proyek->client_id && $proposal->status === 'pending')
        <div class="mt-6 flex gap-2">
            <form method="post" action="{{ route('proposal.terima', $proposal) }}">
                @csrf
                @method('PATCH')
                <button class="rounded bg-green-600 px-4 py-2 text-white">Terima Proposal</button>
            </form>

            <form method="post" action="{{ route('proposal.tolak', $proposal) }}">
                @csrf
                @method('PATCH')
                <button class="rounded bg-red-600 px-4 py-2 text-white">Tolak Proposal</button>
            </form>
        </div>
    @endif
</div>
@endsection
