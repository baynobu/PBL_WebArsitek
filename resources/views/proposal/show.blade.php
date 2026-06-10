@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-10">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 space-y-6">

        @if(session('success'))
            <div class="rounded-[28px] border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700 shadow-sm">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="rounded-[28px] border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700 shadow-sm">{{ session('error') }}</div>
        @endif

        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 transition hover:text-slate-800">&larr; Kembali</a>

        {{-- Header --}}
        <div class="rounded-[32px] border border-slate-100 bg-white p-8 shadow-[0_40px_80px_rgba(15,23,42,0.08)]">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-2xl space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-600"></span>
                        <p class="uppercase tracking-[0.28em] text-xs font-semibold text-slate-400">Detail Proposal</p>
                    </div>
                    <div class="space-y-3">
                        <h1 class="text-3xl font-bold text-slate-950">Proposal untuk: {{ $proposal->proyek->judul }}</h1>
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="text-sm text-slate-500">Arsitek: <a href="{{ route('arsitek.show', $proposal->arsitek_id) }}" class="font-semibold text-slate-700 hover:text-amber-600 transition underline underline-offset-2">{{ $proposal->arsitek->name ?? 'N/A' }}</a></span>

                            @php
                                $status = strtolower($proposal->status);
                                if (in_array($status, ['diterima', 'accepted'])) {
                                    $statusClasses = 'bg-emerald-100 text-emerald-700';
                                    $statusLabel = 'Diterima';
                                } elseif (in_array($status, ['ditolak', 'rejected'])) {
                                    $statusClasses = 'bg-rose-100 text-rose-700';
                                    $statusLabel = 'Ditolak';
                                } else {
                                    $statusClasses = 'bg-amber-100 text-amber-700';
                                    $statusLabel = 'Menunggu Review';
                                }
                            @endphp
                            <span class="inline-flex rounded-full px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] {{ $statusClasses }}">{{ $statusLabel }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats & Detail --}}
        <article class="rounded-[28px] border border-slate-100 bg-white shadow-sm overflow-hidden">
            <div class="flex">
                <div class="w-1 shrink-0 bg-stone-800 rounded-l-[28px]"></div>
                <div class="flex-1 p-8 space-y-6">

                    {{-- Stats --}}
                    <div class="grid gap-4 md:grid-cols-3">
                        <div class="rounded-[22px] bg-emerald-50 ring-1 ring-emerald-100 p-5">
                            <div class="flex items-center gap-1.5 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                <p class="text-[11px] uppercase tracking-[0.22em] font-semibold text-emerald-600">Harga Tawaran</p>
                            </div>
                            <p class="text-base font-bold text-emerald-900">Rp {{ number_format($proposal->harga_tawaran, 0, ',', '.') }}</p>
                        </div>

                        <div class="rounded-[22px] bg-blue-50 ring-1 ring-blue-100 p-5">
                            <div class="flex items-center gap-1.5 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <p class="text-[11px] uppercase tracking-[0.22em] font-semibold text-blue-600">Estimasi Waktu</p>
                            </div>
                            <div class="flex items-baseline gap-1.5">
                                <p class="text-base font-bold text-blue-900">{{ $proposal->estimasi_waktu }}</p>
                                <span class="text-xs font-medium text-blue-500">hari</span>
                            </div>
                        </div>

                        <div class="rounded-[22px] bg-slate-50 ring-1 ring-slate-100 p-5">
                            <div class="flex items-center gap-1.5 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                                <p class="text-[11px] uppercase tracking-[0.22em] font-semibold text-slate-500">Status</p>
                            </div>
                            <span class="inline-flex rounded-full px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.15em] {{ $statusClasses }}">{{ $statusLabel }}</span>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="rounded-[22px] bg-slate-50 p-6">
                        <p class="text-[11px] uppercase tracking-[0.22em] font-semibold text-slate-400 mb-3">Deskripsi Proposal</p>
                        <p class="text-sm leading-7 text-slate-600">{{ $proposal->deskripsi }}</p>
                    </div>

                    {{-- Catatan --}}
                    @if($proposal->catatan)
                        <div class="rounded-[22px] bg-amber-50 ring-1 ring-amber-100 p-6">
                            <p class="text-[11px] uppercase tracking-[0.22em] font-semibold text-amber-600 mb-3">Catatan</p>
                            <p class="text-sm leading-7 text-amber-900">{{ $proposal->catatan }}</p>
                        </div>
                    @endif

                    {{-- Actions --}}
                    @if(auth()->id() === $proposal->proyek->client_id && $proposal->status === 'pending')
                        <div class="flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6">
                            <form method="post" action="{{ route('proposal.terima', $proposal) }}">
                                @csrf
                                @method('PATCH')
                                <button class="inline-flex items-center rounded-2xl bg-slate-950 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-950/20 transition duration-200 hover:bg-slate-800">Terima Proposal</button>
                            </form>
                            <form method="post" action="{{ route('proposal.tolak', $proposal) }}">
                                @csrf
                                @method('PATCH')
                                <button class="inline-flex items-center rounded-2xl border border-red-200 bg-red-50 px-6 py-3 text-sm font-semibold text-red-600 transition duration-200 hover:bg-red-100">Tolak Proposal</button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </article>

    </div>
</div>
@endsection