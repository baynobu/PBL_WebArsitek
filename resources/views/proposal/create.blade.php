@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="rounded-2xl bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-6 text-white shadow-lg">
            <p class="text-xs uppercase tracking-[0.2em] text-indigo-100">Arsitek Workspace</p>
            <h1 class="mt-2 text-3xl font-bold">Kirim Proposal</h1>
            <p class="mt-2 text-sm text-indigo-100">Berikan penawaran terbaik untuk proyek: {{ $proyek->judul }}</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
            <form method="post" action="{{ route('proposal.store', $proyek) }}" class="space-y-5">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Harga Tawaran</label>
                    <input type="number" name="harga_tawaran" step="0.01" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100" value="{{ old('harga_tawaran') }}">
                    @error('harga_tawaran')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Estimasi Waktu (hari)</label>
                    <input type="number" name="estimasi_waktu" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100" value="{{ old('estimasi_waktu') }}">
                    @error('estimasi_waktu')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Deskripsi</label>
                    <textarea name="deskripsi" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100" rows="6">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
                </div>

                <div class="flex justify-end border-t border-gray-200 pt-5 dark:border-gray-700">
                    <button class="inline-flex items-center rounded-lg bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700">Kirim Proposal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
