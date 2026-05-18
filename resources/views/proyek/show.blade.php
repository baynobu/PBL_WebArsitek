@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    @if(session('success'))
        <div class="mb-4 rounded border border-green-300 bg-green-50 p-3 text-green-700">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-red-700">{{ session('error') }}</div>
    @endif

    <a href="{{ route('proyek.index') }}" class="text-sm text-blue-600">&larr; Kembali ke daftar</a>

    <h1 class="text-2xl font-bold mt-2">{{ $proyek->judul }}</h1>
    <div class="text-sm text-gray-600">Lokasi: {{ $proyek->lokasi ?? '-' }} · Budget: {{ number_format($proyek->budget,0,',','.') }} · Deadline: {{ $proyek->deadline }}</div>

    <div class="mt-4">
        <h2 class="font-semibold">Deskripsi</h2>
        <p class="mt-2">{{ $proyek->deskripsi }}</p>
    </div>

    <div class="mt-6">
        <h3 class="font-semibold">Status</h3>
        <p class="mb-2 font-mono text-lg">{{ strtoupper($proyek->status) }}</p>

        @auth
            @if(auth()->user()->id === $proyek->client_id || auth()->user()->id === $proyek->arsitek_terpilih_id)
                @if($proyek->status === 'progress')
                    <form method="post" action="{{ route('proyek.updateStatus', $proyek) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="done">
                        <button class="rounded bg-green-600 px-3 py-1 text-sm text-white">Tandai Selesai</button>
                    </form>
                @endif
            @endif
        @endauth
    </div>

    <div class="mt-6">
        <h3 class="font-semibold">Rating</h3>
        @if($proyek->rating)
            <div class="rounded border p-3 mt-2">
                <div class="font-semibold">Nilai: {{ $proyek->rating->nilai }}/5</div>
                <div class="text-sm text-gray-600">Komentar: {{ $proyek->rating->komentar ?? '-' }}</div>
            </div>
        @else
            @auth
                @if(auth()->user()->id === $proyek->client_id && $proyek->status === 'done')
                    <a href="{{ route('rating.create', $proyek) }}" class="inline-block mt-2 rounded bg-indigo-600 px-3 py-1 text-sm text-white">Beri Rating</a>
                @endif
            @endauth
        @endif
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

        @if(auth()->user()->id === $proyek->client_id)
            <div class="mt-8">
                <h3 class="mb-3 text-lg font-semibold">Review Proposal</h3>

                @if($proyek->proposal->count())
                    <div class="space-y-3">
                        @foreach($proyek->proposal as $proposal)
                            <div class="rounded border p-4">
                                <div class="font-semibold">{{ $proposal->arsitek->name ?? 'Arsitek' }}</div>
                                <div class="text-sm text-gray-600">Harga: {{ number_format($proposal->harga_tawaran, 0, ',', '.') }} · Estimasi: {{ $proposal->estimasi_waktu }} hari · Status: {{ $proposal->status }}</div>
                                <div class="mt-2 flex gap-2">
                                    <a href="{{ route('proposal.show', $proposal) }}" class="rounded bg-blue-600 px-3 py-1 text-sm text-white">Detail Proposal</a>
                                    <a href="{{ route('arsitek.show', $proposal->arsitek_id) }}" class="rounded bg-gray-700 px-3 py-1 text-sm text-white">Lihat Profil Arsitek</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-600">Belum ada proposal masuk.</p>
                @endif
            </div>
        @endif
    @endauth
</div>
@endsection
