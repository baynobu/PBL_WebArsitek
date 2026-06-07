@extends('layouts.app')

@section('content')
<div x-data="{ query: @js(request('q')) }" class="py-10 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Header --}}
        <section class="rounded-[32px] border border-slate-100 bg-white p-8 shadow-[0_40px_80px_rgba(15,23,42,0.08)]">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-600"></span>
                        <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Cari Proyek</p>
                    </div>
                    <h1 class="text-3xl font-bold text-slate-950">Daftar Proyek</h1>
                    <p class="max-w-2xl text-sm leading-6 text-slate-600">Temukan lowongan proyek arsitek yang aktif dan sesuai dengan kebutuhan Anda.</p>
                </div>
            </div>

            <form method="get" action="{{ route('proyek.index') }}" class="mt-8">
                <div class="flex flex-col gap-3 rounded-[1.75rem] border border-slate-100 bg-slate-50 px-4 py-4 shadow-sm sm:flex-row sm:items-center">
                    <div class="relative flex-1">
                        <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                        </svg>
                        <input x-model="query" name="q" type="text" placeholder="Cari judul, deskripsi, lokasi..."
                            class="w-full rounded-[1.5rem] border border-transparent bg-white px-12 py-4 text-sm text-slate-900 shadow-sm focus:border-slate-300 focus:outline-none focus:ring-2 focus:ring-slate-200" />
                    </div>
                    <button type="submit" class="inline-flex shrink-0 items-center justify-center rounded-full bg-amber-700 px-6 py-4 text-sm font-semibold text-white transition hover:bg-amber-800">Cari</button>
                </div>
            </form>
        </section>

        @if($proyeks->count())
            <div class="space-y-5">
                @foreach($proyeks as $p)
                    @php
                        $statusMap = [
                            'open'      => 'Buka',
                            'active'    => 'Buka',
                            'progress'  => 'Sedang Berjalan',
                            'pending'   => 'Menunggu',
                            'done'      => 'Selesai',
                            'completed' => 'Selesai',
                            'closed'    => 'Ditutup',
                            'draft'     => 'Draft',
                            'rejected'  => 'Ditolak',
                        ];

                        $statusLabel = $statusMap[Str::lower($p->status)] ?? strtoupper($p->status);

                        $statusBadge = match(Str::lower($p->status)) {
                            'open'               => 'bg-emerald-100 text-emerald-700',
                            'active'             => 'bg-emerald-100 text-emerald-700',
                            'progress'           => 'bg-sky-100 text-sky-700',
                            'pending'            => 'bg-amber-100 text-amber-700',
                            'done', 'completed'  => 'bg-slate-100 text-slate-600',
                            'closed'             => 'bg-slate-100 text-slate-600',
                            'draft'              => 'bg-slate-100 text-slate-600',
                            'rejected'           => 'bg-rose-100 text-rose-700',
                            default              => 'bg-slate-100 text-slate-600',
                        };
                    @endphp

                    <article class="rounded-[28px] border border-slate-100 bg-white shadow-sm transition duration-200 hover:shadow-md overflow-hidden">
                        <div class="flex">
                            <div class="w-1 shrink-0 bg-stone-800 rounded-l-[28px]"></div>
                            <div class="flex-1 p-8">
                                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                                    <div class="space-y-5 flex-1">

                                        {{-- Title & status --}}
                                        <div class="flex flex-wrap items-center gap-3">
                                            <h2 class="text-2xl font-bold leading-snug text-slate-950">{{ $p->judul }}</h2>
                                            <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] {{ $statusBadge }}">{{ $statusLabel }}</span>
                                        </div>

                                        <p class="text-sm leading-6 text-slate-600 line-clamp-2">{{ Str::limit($p->deskripsi, 170) }}</p>

                                        {{-- Stats grid --}}
                                        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">

                                            {{-- Lokasi --}}
                                            <div class="rounded-[22px] bg-slate-50 p-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-indigo-500">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 12.414a2 2 0 10-2.828 2.828l4.243 4.243a8 8 0 111.414-1.414z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs uppercase tracking-[0.22em] text-indigo-400">Lokasi</p>
                                                        <p class="mt-0.5 text-sm font-semibold text-indigo-900">{{ $p->lokasi ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Anggaran --}}
                                            <div class="rounded-[22px] bg-slate-50 p-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-500">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.21 0-4 .895-4 2s1.79 2 4 2 4-.895 4-2-1.79-2-4-2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c-2.21 0-4 .895-4 2s1.79 2 4 2 4-.895 4-2-1.79-2-4-2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16c-2.21 0-4 .895-4 2s1.79 2 4 2 4-.895 4-2-1.79-2-4-2z" /></svg>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs uppercase tracking-[0.22em] text-emerald-500">Anggaran</p>
                                                        <p class="mt-0.5 text-sm font-semibold text-emerald-900">Rp {{ number_format($p->budget ?? 0, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Durasi --}}
                                            <div class="rounded-[22px] bg-slate-50 p-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-sky-500">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l2 2" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs uppercase tracking-[0.22em] text-sky-400">Durasi</p>
                                                        <p class="mt-0.5 text-sm font-semibold text-sky-900">{{ $p->open_duration_days ?? 0 }} hari</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Progress --}}
                                            <div class="rounded-[22px] bg-slate-50 p-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-amber-500">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="flex items-center justify-between">
                                                            <p class="text-xs uppercase tracking-[0.22em] text-amber-00">Progress</p>
                                                            <p class="text-xs font-semibold text-amber-700">{{ $p->progress_percent ?? 0 }}%</p>
                                                        </div>
                                                        <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-amber-100">
                                                            <div class="h-full rounded-full bg-amber-500 transition-all duration-500" style="width: {{ $p->progress_percent ?? 0 }}%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    {{-- Action --}}
                                    <div class="flex items-start lg:pl-6 lg:pt-1">
                                        <a href="{{ route('proyek.show', $p) }}" class="inline-flex items-center justify-center rounded-xl bg-amber-700 px-5 py-3 text-sm font-medium text-white shadow-md shadow-amber-700/20 transition hover:bg-amber-800">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="pt-6">{{ $proyeks->links() }}</div>
        @else
            <div class="rounded-[28px] border border-slate-100 bg-white p-12 text-center shadow-sm">
                <div class="mx-auto flex max-w-md flex-col items-center gap-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                    </div>
                    <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Tidak ada proyek ditemukan.</p>
                    <p class="text-sm leading-6 text-slate-600">Silakan coba kata kunci lain untuk menemukan peluang proyek arsitek yang cocok.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection