@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <a href="{{ url()->previous() }}" class="text-sm text-blue-600">&larr; Kembali</a>

    <h1 class="mt-2 text-2xl font-bold">Profil Arsitek: {{ $arsitek->name }}</h1>

    <div class="mt-4 rounded border p-4">
        <div><strong>Email:</strong> {{ $arsitek->email }}</div>
        <div class="mt-2"><strong>Skill:</strong> {{ $arsitek->profilArsitek->skill ?? '-' }}</div>
        <div class="mt-2"><strong>Deskripsi:</strong></div>
        <p>{{ $arsitek->profilArsitek->deskripsi ?? 'Belum ada deskripsi profil.' }}</p>
        <div class="mt-2"><strong>Pengalaman:</strong> {{ $arsitek->profilArsitek->pengalaman ?? '-' }}</div>
    </div>

    <div class="mt-6">
        <h2 class="text-xl font-semibold">Portofolio</h2>

        @if($arsitek->portofolio->count())
            <div class="mt-3 grid grid-cols-1 gap-3 md:grid-cols-2">
                @foreach($arsitek->portofolio as $portofolio)
                    <div class="rounded border p-3">
                        <h3 class="font-semibold">{{ $portofolio->judul }}</h3>
                        <div class="text-sm text-gray-600">Kategori: {{ $portofolio->kategori }}</div>
                        <p class="mt-2 text-sm">{{ $portofolio->deskripsi }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="mt-2 text-sm text-gray-600">Belum ada portofolio.</p>
        @endif
    </div>
</div>
@endsection
