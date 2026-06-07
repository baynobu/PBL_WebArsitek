@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-10" x-data="{ hasProjects: {{ $proyeks->count() ? 'true' : 'false' }} }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Header --}}
        <div class="rounded-[32px] border border-slate-100 bg-white p-8 shadow-[0_40px_80px_rgba(15,23,42,0.08)]">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-2xl space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-600"></span>
                        <p class="uppercase tracking-[0.28em] text-xs font-semibold text-slate-400">Client Workspace</p>
                    </div>
                    <div class="space-y-3">
                        <h1 class="text-3xl font-bold text-slate-950">Proyek Saya</h1>
                        <p class="max-w-xl text-sm leading-7 text-slate-500">Kelola, pantau progress, dan tinjau penawaran proposal dari proyek aktif Anda.</p>
                    </div>
                </div>

                <div class="flex justify-start lg:justify-end">
                    <a href="{{ route('proyek.create') }}" class="inline-flex items-center rounded-2xl bg-slate-950 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-950/20 transition duration-200 hover:bg-slate-800">+ Buat Proyek Baru</a>
                </div>
            </div>
        </div>

        {{-- Project list --}}
        <div class="grid gap-6">
            @if($proyeks->count())
                <template x-if="hasProjects">
                    <div class="space-y-5">
                        @foreach($proyeks as $proyek)
                            <article class="rounded-[28px] border border-slate-100 bg-white shadow-sm transition duration-200 hover:shadow-md overflow-hidden">

                                {{-- Subtle left accent bar --}}
                                <div class="flex">
                                    <div class="w-1 shrink-0 bg-stone-800 rounded-l-[28px]"></div>

                                    <div class="flex-1 p-8">
                                        <div class="grid gap-8 lg:grid-cols-[1fr_1.1fr_auto] lg:items-start">

                                            {{-- LEFT: Project info --}}
                                            <div class="space-y-5">
                                                <div class="flex flex-wrap items-center gap-3">
                                                    <span class="uppercase tracking-[0.26em] text-[11px] font-semibold text-slate-400">{{ $proyek->kategori ?? 'Proyek Arsitektur' }}</span>

                                                    {{-- Badge dengan warna berdasarkan status --}}
                                                    @php
                                                        $statusLabel = strtolower($proyek->status) === 'open'
                                                            ? 'AKTIF'
                                                            : (strtolower($proyek->status) === 'progress'
                                                                ? 'Sedang Berjalan'
                                                                : strtoupper($proyek->status));
                                                        $statusClass = match(strtolower($proyek->status)) {
                                                            'open'      => 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200',
                                                            'progress'  => 'bg-sky-100 text-sky-700 ring-1 ring-sky-200',
                                                            'closed'    => 'bg-slate-100 text-slate-500 ring-1 ring-slate-200',
                                                            'pending'   => 'bg-amber-100 text-amber-700 ring-1 ring-amber-200',
                                                            'cancelled' => 'bg-red-100 text-red-600 ring-1 ring-red-200',
                                                            default     => 'bg-blue-100 text-blue-700 ring-1 ring-blue-200',
                                                        };
                                                    @endphp
                                                    <span class="inline-flex rounded-full px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.15em] {{ $statusClass }}">
                                                        {{ $statusLabel }}
                                                    </span>
                                                </div>

                                                <h2 class="text-2xl font-bold leading-snug text-slate-950">{{ $proyek->judul }}</h2>

                                                @if($proyek->deskripsi ?? false)
                                                    <p class="text-sm leading-7 text-slate-500 line-clamp-2">{{ $proyek->deskripsi }}</p>
                                                @else
                                                    <p class="text-sm leading-7 text-slate-400 italic">Belum ada deskripsi proyek.</p>
                                                @endif

                                                <div class="flex flex-wrap gap-3 pt-1">
                                                    <div class="flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                                        <span>Dibuat {{ $proyek->created_at->translatedFormat('d F Y') }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                        <span>Deadline {{ $proyek->deadline }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- MIDDLE: Stats --}}
                                            <div class="grid gap-4 sm:grid-cols-2">

                                                {{-- Budget card --}}
                                                <div class="rounded-[22px] bg-slate-50 p-4">
                                                    <div class="flex items-center gap-1.5 mb-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                                        <p class="text-xs uppercase tracking-[0.22em] font-semibold text-emerald-600">Budget</p>
                                                    </div>
                                                    <p class="text-base font-bold text-emerald-900">Rp {{ number_format($proyek->budget, 0, ',', '.') }}</p>
                                                </div>

                                                {{-- Proposal card --}}
                                                <div class="rounded-[22px] bg-slate-50 p-4">
                                                    <div class="flex items-center gap-1.5 mb-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                                        <p class="text-xs uppercase tracking-[0.22em] font-semibold text-blue-600">Proposal Masuk</p>
                                                    </div>
                                                    <div class="flex items-baseline gap-1.5">
                                                        <p class="text-base font-bold text-blue-900">{{ $proyek->proposal_count ?? 0 }}</p>
                                                        <span class="mt-0.5 text-sm font-medium text-blue-500">penawaran</span>
                                                    </div>
                                                </div>

                                                {{-- Progress card --}}
                                                <div class="sm:col-span-2 rounded-[22px] bg-slate-50 p-4">
                                                    <div class="flex items-center justify-between mb-3">
                                                        <div class="flex items-center gap-1.5">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                                            <p class="text-xs uppercase tracking-[0.22em] font-semibold text-amber-600">Progress Proyek</p>
                                                        </div>
                                                        <span class="text-sm font-bold text-amber-800 bg-amber-100 px-2.5 py-0.5 rounded-full">{{ $proyek->progress_percent ?? 0 }}%</span>
                                                    </div>
                                                    <div class="h-2 overflow-hidden rounded-full bg-amber-100">
                                                        <div class="h-2 rounded-full bg-gradient-to-r from-amber-400 to-amber-600 transition-all duration-500" style="width: {{ min(max($proyek->progress_percent ?? 0, 0), 100) }}%"></div>
                                                    </div>
                                                </div>

                                            </div>

                                            {{-- RIGHT: Actions --}}
                                            <div class="flex flex-col gap-3 justify-start lg:pt-1">
                                                <a href="{{ route('proyek.show', $proyek) }}" class="inline-flex w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">Lihat Proposal</a>
                                                <a href="{{ route('proyek.show', $proyek) }}" class="inline-flex w-full items-center justify-center rounded-xl bg-amber-700 px-5 py-3 text-sm font-medium text-white transition hover:bg-amber-800">Kelola Proyek</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </template>

                <div class="pt-2">{{ $proyeks->links() }}</div>
            @else
                <div x-show="!hasProjects" x-cloak class="rounded-[32px] border border-slate-100 bg-white p-12 shadow-[0_40px_80px_rgba(15,23,42,0.06)]">
                    <div class="mx-auto flex max-w-2xl flex-col items-center gap-6 text-center">
                        <div class="flex h-20 w-20 items-center justify-center rounded-3xl bg-slate-100 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 8.5C3 7.12 4.12 6 5.5 6h13c1.38 0 2.5 1.12 2.5 2.5v8c0 1.38-1.12 2.5-2.5 2.5h-13A2.5 2.5 0 0 1 3 16.5v-8Z" />
                                <path d="M8 12.5h8" />
                                <path d="M8 15.5h5" />
                            </svg>
                        </div>
                        <div class="space-y-3">
                            <p class="text-sm uppercase tracking-[0.28em] text-slate-400">Belum Ada Proyek Berjalan</p>
                            <h2 class="text-2xl font-semibold text-slate-950">Mulai kembangkan portofolio arsitektur Anda</h2>
                            <p class="max-w-xl text-sm leading-7 text-slate-500">Tambahkan proyek baru untuk menerima proposal, memantau kemajuan, dan menjaga semua pekerjaan arsitektur Anda tetap terorganisir.</p>
                        </div>
                        <a href="{{ route('proyek.create') }}" class="inline-flex rounded-2xl bg-slate-950 px-7 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-950/20 transition duration-200 hover:bg-slate-800">Mulai Buat Proyek</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection