@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 space-y-6">
        @if(session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">{{ session('error') }}</div>
        @endif

        <a href="{{ url()->previous() }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-700">&larr; Kembali</a>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Detail Proposal</p>
                    <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">Proposal untuk: {{ $proposal->proyek->judul }}</h1>
                    <div class="mt-3 flex flex-wrap gap-3 text-sm text-gray-500 dark:text-gray-400">
                        <span>Arsitek: {{ $proposal->arsitek->name ?? 'N/A' }}</span>
                        <span>Status: {{ $proposal->status }}</span>
                    </div>
                </div>
                <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">{{ number_format($proposal->harga_tawaran,0,',','.') }}</span>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl bg-gray-50 p-4 dark:bg-gray-900">
                    <div class="text-xs uppercase tracking-wide text-gray-500">Harga Tawaran</div>
                    <div class="mt-2 text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($proposal->harga_tawaran,0,',','.') }}</div>
                </div>
                <div class="rounded-2xl bg-gray-50 p-4 dark:bg-gray-900">
                    <div class="text-xs uppercase tracking-wide text-gray-500">Estimasi Waktu</div>
                    <div class="mt-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $proposal->estimasi_waktu }} hari</div>
                </div>
                <div class="rounded-2xl bg-gray-50 p-4 dark:bg-gray-900">
                    <div class="text-xs uppercase tracking-wide text-gray-500">Status</div>
                    <div class="mt-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $proposal->status }}</div>
                </div>
            </div>

            <div class="mt-6 rounded-2xl bg-gray-50 p-5 dark:bg-gray-900">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Deskripsi</h2>
                <p class="mt-3 leading-7 text-gray-700 dark:text-gray-300">{{ $proposal->deskripsi }}</p>
            </div>

            @if(auth()->id() === $proposal->proyek->client_id && $proposal->status === 'pending')
                <div class="mt-6 flex flex-wrap gap-3">
                    <form method="post" action="{{ route('proposal.terima', $proposal) }}">
                        @csrf
                        @method('PATCH')
                        <button class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Terima Proposal</button>
                    </form>

                    <form method="post" action="{{ route('proposal.tolak', $proposal) }}">
                        @csrf
                        @method('PATCH')
                        <button class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">Tolak Proposal</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
