@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Daftar Proposal</h1>

    @if($proposals->count())
        <div class="space-y-4">
            @foreach($proposals as $pr)
                <div class="border rounded p-4">
                    <a class="text-lg font-semibold" href="{{ route('proposal.show', $pr) }}">Proposal untuk: {{ $pr->proyek->judul }}</a>
                    <div class="text-sm text-gray-600">Harga: {{ number_format($pr->harga_tawaran,0,',','.') }} · Estimasi: {{ $pr->estimasi_waktu }} hari · Status: {{ $pr->status }}</div>
                </div>
            @endforeach
        </div>
    @else
        <p>Tidak ada proposal ditemukan.</p>
    @endif
</div>
@endsection
