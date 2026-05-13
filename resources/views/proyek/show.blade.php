@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <a href="{{ route('proyek.index') }}" class="text-sm text-blue-600">&larr; Kembali ke daftar</a>

    <h1 class="text-2xl font-bold mt-2">{{ $proyek->judul }}</h1>
    <div class="text-sm text-gray-600">Lokasi: {{ $proyek->lokasi ?? '-' }} · Budget: {{ number_format($proyek->budget,0,',','.') }} · Deadline: {{ $proyek->deadline }}</div>

    <div class="mt-4">
        <h2 class="font-semibold">Deskripsi</h2>
        <p class="mt-2">{{ $proyek->deskripsi }}</p>
    </div>

    <div class="mt-6">
        <h3 class="font-semibold">Status</h3>
        <p>{{ $proyek->status }}</p>
    </div>
    @auth
        @if(auth()->user()->role === 'arsitek')
            @php
                $ver = \App\Models\VerifikasiUser::where('user_id', auth()->id())->first();
            @endphp
            @if($ver && $ver->status === 'verified' && $proyek->status === 'open')
                <div class="mt-4">
                    <a href="{{ route('proposal.create', $proyek) }}" class="bg-blue-600 text-white px-4 py-2 rounded">Ajukan Proposal</a>
                </div>
            @endif
        @endif
    @endauth
</div>
@endsection
