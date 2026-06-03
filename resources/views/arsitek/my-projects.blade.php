@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="rounded-2xl bg-gradient-to-r from-slate-900 to-indigo-700 px-6 py-6 text-white shadow-lg">
            <p class="text-xs uppercase tracking-[0.2em] text-slate-200">Arsitek Workspace</p>
            <h1 class="mt-2 text-3xl font-bold">Proyek Saya</h1>
            <p class="mt-2 max-w-2xl text-sm text-slate-200">Daftar proyek yang sudah Anda lamar, lengkap dengan status proposal dan status proyeknya.</p>
        </div>

        @if($proposals->count())
            <div class="grid gap-4">
                @foreach($proposals as $proposal)
                    <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-0.5 hover:shadow-lg dark:bg-gray-800 dark:ring-gray-700">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                            <div class="space-y-3">
                                <div class="flex flex-wrap items-center gap-3">
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                                        <a href="{{ route('proposal.show', $proposal) }}" class="hover:text-indigo-600">{{ $proposal->proyek->judul }}</a>
                                    </h2>
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $proposal->status === 'accepted' ? 'bg-emerald-100 text-emerald-700' : ($proposal->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                        {{ strtoupper($proposal->status) }}
                                    </span>
                                </div>

                                <div class="flex flex-wrap gap-4 text-sm text-gray-500 dark:text-gray-400">
                                    <span>Budget proyek: {{ number_format($proposal->proyek->budget, 0, ',', '.') }}</span>
                                    <span>Lokasi: {{ $proposal->proyek->lokasi ?? '-' }}</span>
                                    <span>Status proyek: {{ strtoupper($proposal->proyek->status) }}</span>
                                    <span>Proposal Anda: {{ number_format($proposal->harga_tawaran, 0, ',', '.') }}</span>
                                </div>

                                <p class="max-w-4xl text-sm leading-6 text-gray-600 dark:text-gray-300">{{ \Illuminate\Support\Str::limit($proposal->deskripsi, 180) }}</p>
                            </div>

                            <div class="flex flex-col gap-2 sm:flex-row">
                                <a href="{{ route('proposal.show', $proposal) }}" class="inline-flex h-fit items-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 dark:bg-slate-700">Buka Proposal</a>
                                <a href="{{ route('proyek.show', $proposal->proyek) }}" class="inline-flex h-fit items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Lihat Proyek</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500 shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                Anda belum pernah mengajukan proposal.
            </div>
        @endif
    </div>
</div>
@endsection
