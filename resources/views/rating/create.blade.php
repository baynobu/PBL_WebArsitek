@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-6">
        <a href="{{ route('proyek.show', $proyek) }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-700">&larr; Kembali ke proyek</a>

        <div class="rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-6 text-white shadow-lg">
            <p class="text-xs uppercase tracking-[0.2em] text-indigo-100">Client Feedback</p>
            <h1 class="mt-2 text-3xl font-bold">Beri Rating</h1>
            <p class="mt-2 text-sm text-indigo-100">Proyek: {{ $proyek->judul }}</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
            <form action="{{ route('rating.store', $proyek) }}" method="post" class="space-y-5">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Nilai (1-5)</label>
                    <select name="nilai" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                        @for($i=5;$i>=1;$i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    @error('nilai') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Komentar (opsional)</label>
                    <textarea name="komentar" rows="5" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">{{ old('komentar') }}</textarea>
                    @error('komentar') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div class="flex justify-end border-t border-gray-200 pt-5 dark:border-gray-700">
                    <button class="inline-flex items-center rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-700">Kirim Rating</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
