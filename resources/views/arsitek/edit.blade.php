@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold">Edit Profil Arsitek</h1>

    @if(session('success'))
        <div class="mb-4 rounded border border-green-300 bg-green-50 p-3 text-green-700">{{ session('success') }}</div>
    @endif

    <form action="{{ route('arsitek.profile.update') }}" method="post" enctype="multipart/form-data" class="mt-4 max-w-lg">
        @csrf
        @method('PATCH')

        <div class="mb-4">
            <label class="block font-semibold mb-1">Foto Profil</label>
            @if($profil->foto)
                <img src="{{ asset('storage/' . $profil->foto) }}" alt="foto" class="w-24 h-24 rounded object-cover mb-2">
            @endif
            <input type="file" name="foto" accept="image/*">
            @error('foto') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Skill (comma separated)</label>
            <input type="text" name="skill" value="{{ old('skill', $profil->skill ?? '') }}" class="w-full rounded border px-3 py-2">
            @error('skill') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="5" class="w-full rounded border px-3 py-2">{{ old('deskripsi', $profil->deskripsi ?? '') }}</textarea>
            @error('deskripsi') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Pengalaman</label>
            <textarea name="pengalaman" rows="3" class="w-full rounded border px-3 py-2">{{ old('pengalaman', $profil->pengalaman ?? '') }}</textarea>
        </div>

        <div>
            <button class="rounded bg-blue-600 px-4 py-2 text-white">Simpan Profil</button>
        </div>
    </form>
</div>
@endsection
