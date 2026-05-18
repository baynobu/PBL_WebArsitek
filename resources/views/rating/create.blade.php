@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <a href="{{ route('proyek.show', $proyek) }}" class="text-sm text-blue-600">&larr; Kembali ke proyek</a>

    <h1 class="text-2xl font-bold mt-2">Beri Rating untuk Proyek: {{ $proyek->judul }}</h1>

    <form action="{{ route('rating.store', $proyek) }}" method="post" class="mt-4 max-w-lg">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1">Nilai (1-5)</label>
            <select name="nilai" class="w-full rounded border px-3 py-2">
                @for($i=5;$i>=1;$i--)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
            @error('nilai') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Komentar (opsional)</label>
            <textarea name="komentar" rows="4" class="w-full rounded border px-3 py-2">{{ old('komentar') }}</textarea>
            @error('komentar') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        <div>
            <button class="rounded bg-indigo-600 px-4 py-2 text-white">Kirim Rating</button>
        </div>
    </form>
</div>
@endsection
