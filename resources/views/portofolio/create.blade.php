@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="rounded-2xl bg-gradient-to-r from-fuchsia-600 to-pink-600 px-6 py-6 text-white shadow-lg">
            <p class="text-xs uppercase tracking-[0.2em] text-fuchsia-100">Arsitek Workspace</p>
            <h1 class="mt-2 text-3xl font-bold">Tambah Portofolio</h1>
            <p class="mt-2 text-sm text-fuchsia-100">Tambahkan karya baru agar profil Anda terlihat lebih profesional.</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
            <form action="{{ route('portofolio.store') }}" method="post" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Judul</label>
                    <input type="text" name="judul" value="{{ old('judul') }}" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                    @error('judul') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Kategori</label>
                    <input type="text" name="kategori" value="{{ old('kategori') }}" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                    @error('kategori') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Deskripsi</label>
                    <textarea name="deskripsi" rows="6" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Gambar</label>
                    <input type="file" name="gambar" accept="image/*" class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-pink-600 file:px-4 file:py-2 file:text-white hover:file:bg-pink-700 dark:text-gray-300">
                    @error('gambar') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div class="flex justify-end border-t border-gray-200 pt-5 dark:border-gray-700">
                    <button class="inline-flex items-center rounded-lg bg-fuchsia-600 px-5 py-3 text-sm font-semibold text-white hover:bg-fuchsia-700">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
