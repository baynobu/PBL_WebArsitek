@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Daftar Proyek</h1>

    <form method="get" action="{{ route('proyek.index') }}" class="mb-4">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul, deskripsi, lokasi..." class="border rounded p-2 w-2/3" />
        <button class="bg-blue-600 text-white rounded px-3 py-2">Cari</button>
    </form>

    @if($proyeks->count())
        <div class="grid grid-cols-1 gap-4">
            @foreach($proyeks as $p)
                <div class="border rounded p-4">
                    <h2 class="text-xl font-semibold"><a href="{{ route('proyek.show', $p) }}">{{ $p->judul }}</a></h2>
                    <p class="text-sm text-gray-600">{{ Str::limit($p->deskripsi, 200) }}</p>
                    <div class="mt-2 text-sm text-gray-500">Lokasi: {{ $p->lokasi ?? '-' }} · Budget: {{ number_format($p->budget, 0, ',', '.') }}</div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $proyeks->links() }}</div>
    @else
        <p>Tidak ada proyek ditemukan.</p>
    @endif
</div>
@endsection
