@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-6 text-white shadow-lg">
            <p class="text-xs uppercase tracking-[0.2em] text-emerald-100">Client Workspace</p>
            <h1 class="mt-2 text-3xl font-bold">Posting Proyek Baru</h1>
            <p class="mt-2 text-sm text-emerald-100">Buat lowongan proyek yang rapi agar arsitek mudah memahami kebutuhan Anda.</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
            <form method="post" action="{{ route('proyek.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Judul</label>
                    <input type="text" name="judul" value="{{ old('judul') }}" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                    @error('judul')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Deskripsi</label>
                    <textarea name="deskripsi" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100" rows="6">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Budget</label>
                        <input type="number" name="budget" value="{{ old('budget') }}" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100" min="0" step="0.01">
                        @error('budget')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Deadline</label>
                        <input type="date" name="deadline" value="{{ old('deadline') }}" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                        @error('deadline')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Durasi Open Project (hari)</label>
                    <input type="number" name="open_duration_days" value="{{ old('open_duration_days', 14) }}" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100" min="3" max="90">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Setelah durasi ini lewat, proyek dapat dianggap ditutup untuk proposal baru.</p>
                    @error('open_duration_days')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Lokasi</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                    @error('lokasi')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
                </div>

                <div class="flex justify-end border-t border-gray-200 pt-5 dark:border-gray-700">
                    <button class="inline-flex items-center rounded-lg bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700">Posting Proyek</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
