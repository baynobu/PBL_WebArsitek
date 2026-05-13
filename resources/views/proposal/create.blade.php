@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold">Kirim Proposal untuk: {{ $proyek->judul }}</h1>

    <form method="post" action="{{ route('proposal.store', $proyek) }}" class="mt-4 max-w-lg">
        @csrf

        <label class="block mb-2">Harga Tawaran</label>
        <input type="number" name="harga_tawaran" step="0.01" class="border rounded p-2 w-full" value="{{ old('harga_tawaran') }}">
        @error('harga_tawaran')<div class="text-red-600">{{ $message }}</div>@enderror

        <label class="block mt-4 mb-2">Estimasi Waktu (hari)</label>
        <input type="number" name="estimasi_waktu" class="border rounded p-2 w-full" value="{{ old('estimasi_waktu') }}">
        @error('estimasi_waktu')<div class="text-red-600">{{ $message }}</div>@enderror

        <label class="block mt-4 mb-2">Deskripsi</label>
        <textarea name="deskripsi" class="border rounded p-2 w-full">{{ old('deskripsi') }}</textarea>
        @error('deskripsi')<div class="text-red-600">{{ $message }}</div>@enderror

        <div class="mt-4">
            <button class="bg-green-600 text-white px-4 py-2 rounded">Kirim Proposal</button>
        </div>
    </form>
</div>
@endsection
