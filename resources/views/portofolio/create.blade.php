@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold">Tambah Portofolio</h1>

    <form action="{{ route('portofolio.store') }}" method="post" enctype="multipart/form-data" class="mt-4 max-w-lg">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1">Judul</label>
            <input type="text" name="judul" value="{{ old('judul') }}" class="w-full rounded border px-3 py-2">
            @error('judul') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Kategori</label>
            <input type="text" name="kategori" value="{{ old('kategori') }}" class="w-full rounded border px-3 py-2">
            @error('kategori') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="5" class="w-full rounded border px-3 py-2">{{ old('deskripsi') }}</textarea>
            @error('deskripsi') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Gambar</label>
            <input type="file" name="gambar" accept="image/*">
            @error('gambar') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        <div>
            <button class="rounded bg-blue-600 px-4 py-2 text-white">Tambah</button>
        </div>
    </form>
</div>
@endsection
