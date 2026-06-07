@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @php
            $totalProposals = $proposals->count();
            $pendingProposals = $proposals->filter(function ($proposal) {
                return in_array(strtolower($proposal->status), ['menunggu review', 'menunggu', 'pending', 'review']);
            })->count();
            $acceptedProposals = $proposals->filter(function ($proposal) {
                return in_array(strtolower($proposal->status), ['diterima', 'accepted']);
            })->count();
            $highestOffer = $totalProposals ? round($proposals->max('harga_tawaran')) : 0;
            $lowestOffer = $totalProposals ? round($proposals->min('harga_tawaran')) : 0;
            $groupedProposals = $proposals->groupBy(fn ($proposal) => optional($proposal->proyek)->id ?? 0);
            $projectNames = $proposals->mapWithKeys(fn ($proposal) => [optional($proposal->proyek)->id ?? 0 => optional($proposal->proyek)->judul ?? 'Proyek Tidak Diketahui']);
            $defaultProject = optional($groupedProposals->first()->first())->proyek;
            $projectDetailRoute = $defaultProject ? route('proyek.show', $defaultProject) : route('proyek.my');
        @endphp

        @if(session('success'))
            <div class="rounded-[28px] border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-700 shadow-sm mb-6">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="rounded-[28px] border border-red-200 bg-red-50 px-5 py-4 text-red-700 shadow-sm mb-6">{{ session('error') }}</div>
        @endif

        {{-- Header --}}
        <div class="rounded-[32px] border border-slate-100 bg-white p-8 shadow-[0_40px_80px_rgba(15,23,42,0.08)]">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-2xl space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-600"></span>
                        <p class="uppercase tracking-[0.28em] text-xs font-semibold text-slate-400">Proposal Center</p>
                    </div>
                    <div class="space-y-3">
                        <h1 class="text-3xl font-bold text-slate-950">Daftar Proposal</h1>
                        <p class="max-w-xl text-sm leading-7 text-slate-500">Pantau, tinjau, dan kelola semua proposal penawaran yang masuk dari arsitek untuk proyek Anda.</p>
                    </div>
                </div>
                <div class="flex justify-start lg:justify-end">
                    <div class="inline-flex items-center rounded-2xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700">
                        {{ $pendingProposals }} Proposal Menunggu
                    </div>
                </div>
            </div>
        </div>

        {{-- Per-project blocks --}}
        <div class="mt-8 space-y-10">
            @if($totalProposals)
                @foreach($groupedProposals as $projectId => $projectGroup)
                    @php
                        $projectPending  = $projectGroup->filter(fn($p) => in_array(strtolower($p->status), ['menunggu review','menunggu','pending','review']))->count();
                        $projectAccepted = $projectGroup->filter(fn($p) => in_array(strtolower($p->status), ['diterima','accepted']))->count();
                        $projectHighest  = round($projectGroup->max('harga_tawaran'));
                        $projectLowest   = round($projectGroup->min('harga_tawaran'));
                    @endphp

                    <div class="grid gap-6 lg:grid-cols-3">

                        {{-- Proposal list (2/3 width) --}}
                        <div class="lg:col-span-2 space-y-4">

                            {{-- Project header --}}
                            <article class="rounded-[28px] border border-slate-100 bg-white shadow-sm overflow-hidden">
                                <div class="flex">
                                    <div class="w-1 shrink-0 bg-stone-800 rounded-l-[28px]"></div>
                                    <div class="flex-1 px-6 py-5">
                                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                            <div class="space-y-1">
                                                <div class="flex items-center gap-2">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-600"></span>
                                                    <p class="text-xs uppercase tracking-[0.26em] font-semibold text-slate-400">Proyek</p>
                                                </div>
                                                <h2 class="text-xl font-bold text-slate-950">{{ $projectNames[$projectId] ?? 'Proyek Tidak Diketahui' }}</h2>
                                                <p class="text-sm text-slate-500">{{ $projectGroup->count() }} Proposal Masuk</p>
                                            </div>
                                            <span class="inline-flex rounded-full bg-slate-100 px-4 py-1.5 text-sm font-semibold text-slate-700">{{ $projectGroup->count() }} Proposal</span>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            {{-- Individual proposals --}}
                            @foreach($projectGroup as $proposal)
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
                                    $architectName = optional($proposal->arsitek)->name ?? 'Arsitek Terverifikasi';
                                @endphp

                                <article class="rounded-[28px] border border-slate-100 bg-white shadow-sm transition duration-200 hover:shadow-md overflow-hidden">
                                    <div class="flex">
                                        <div class="w-1 shrink-0 bg-stone-800 rounded-l-[28px]"></div>
                                        <div class="flex-1 p-6">
                                            <div class="flex flex-col gap-6 xl:flex-row xl:items-start xl:justify-between">
                                                <div class="space-y-5 xl:max-w-2xl">

                                                    {{-- Architect info --}}
                                                    <div class="flex flex-wrap items-center gap-4">
                                                        <div class="h-12 w-12 rounded-full bg-slate-100 text-slate-950 grid place-items-center text-base font-bold uppercase">{{ strtoupper(substr($architectName, 0, 2)) }}</div>
                                                        <div>
                                                            <p class="text-[11px] uppercase tracking-[0.26em] font-semibold text-slate-400">Arsitek</p>
                                                            <p class="text-base font-bold text-slate-950">{{ $architectName }}</p>
                                                        </div>
                                                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.15em] text-emerald-700">Verified Arsitek</span>
                                                    </div>

                                                    {{-- Note --}}
                                                    <div class="space-y-2">
                                                        <a href="{{ route('proposal.show', $proposal) }}" class="text-lg font-bold text-slate-950 hover:text-slate-700 leading-snug">Proposal untuk: {{ $proposal->proyek->judul }}</a>
                                                        <p class="text-sm leading-7 text-slate-500">{{ Str::limit($proposal->catatan ?? 'Proposal ini berisi penawaran jasa arsitek yang dirancang untuk memenuhi kebutuhan proyek Anda dengan kualitas terbaik.', 140) }}</p>
                                                    </div>

                                                    {{-- Stats --}}
                                                    <div class="grid gap-3 sm:grid-cols-3">
                                                        <div class="rounded-[22px] bg-emerald-50 ring-1 ring-emerald-100 p-4">
                                                            <p class="text-[11px] uppercase tracking-[0.22em] font-semibold text-emerald-600">Harga Penawaran</p>
                                                            <p class="mt-2 text-sm font-bold text-emerald-900">Rp {{ number_format($proposal->harga_tawaran, 0, ',', '.') }}</p>
                                                        </div>
                                                        <div class="rounded-[22px] bg-blue-50 ring-1 ring-blue-100 p-4">
                                                            <p class="text-[11px] uppercase tracking-[0.22em] font-semibold text-blue-600">Estimasi Durasi</p>
                                                            <p class="mt-2 text-sm font-bold text-blue-900">{{ $proposal->estimasi_waktu }} Hari</p>
                                                        </div>
                                                        <div class="rounded-[22px] bg-slate-50 ring-1 ring-slate-100 p-4">
                                                            <p class="text-[11px] uppercase tracking-[0.22em] font-semibold text-slate-500">Status</p>
                                                            <span class="mt-2 inline-flex rounded-full px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.15em] {{ $statusClasses }}">{{ $statusLabel }}</span>
                                                        </div>
                                                    </div>

                                                </div>

                                                {{-- Actions --}}
                                                <div class="flex flex-col gap-3 sm:items-end">
                                                    <a href="{{ route('proposal.show', $proposal) }}" class="inline-flex whitespace-nowrap items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">Tinjau Detail</a>
                                                    @if(in_array($status, ['menunggu review', 'menunggu', 'pending', 'review']))
                                                        <button type="button" class="inline-flex whitespace-nowrap items-center justify-center rounded-xl bg-amber-700 px-4 py-3 text-sm font-medium text-white transition hover:bg-amber-800">Terima Proposal</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        {{-- Ringkasan sidebar (1/3 width) --}}
                        <aside class="lg:col-span-1 lg:sticky lg:top-8 self-start">
                            <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-sm">
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-600"></span>
                                    <p class="text-xs uppercase tracking-[0.28em] font-semibold text-slate-400">Ringkasan</p>
                                </div>
                                <h2 class="text-base font-bold text-slate-950 mb-6">{{ $projectNames[$projectId] ?? 'Proyek Tidak Diketahui' }}</h2>

                                <div class="space-y-3">
                                    <div class="rounded-[22px] bg-slate-50 p-4">
                                        <p class="text-[11px] uppercase tracking-[0.22em] font-semibold text-slate-400">Total Proposal</p>
                                        <p class="mt-2 text-lg font-bold text-slate-950">{{ $projectGroup->count() }}</p>
                                    </div>
                                    <div class="rounded-[22px] bg-amber-50 ring-1 ring-amber-100 p-4">
                                        <p class="text-[11px] uppercase tracking-[0.22em] font-semibold text-amber-600">Menunggu Review</p>
                                        <p class="mt-2 text-lg font-bold text-amber-900">{{ $projectPending }}</p>
                                    </div>
                                    <div class="rounded-[22px] bg-emerald-50 ring-1 ring-emerald-100 p-4">
                                        <p class="text-[11px] uppercase tracking-[0.22em] font-semibold text-emerald-600">Diterima</p>
                                        <p class="mt-2 text-lg font-bold text-emerald-900">{{ $projectAccepted }}</p>
                                    </div>
                                    <div class="rounded-[22px] bg-slate-50 p-4">
                                        <p class="text-[11px] uppercase tracking-[0.22em] font-semibold text-slate-400">Penawaran Tertinggi</p>
                                        <p class="mt-2 text-base font-bold text-slate-950">Rp {{ number_format($projectHighest, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="rounded-[22px] bg-slate-50 p-4">
                                        <p class="text-[11px] uppercase tracking-[0.22em] font-semibold text-slate-400">Penawaran Terendah</p>
                                        <p class="mt-2 text-base font-bold text-slate-950">Rp {{ number_format($projectLowest, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <a href="{{ $projectDetailRoute }}" class="mt-6 inline-flex w-full items-center justify-center rounded-2xl bg-amber-700 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-950/20 transition duration-200 hover:bg-amber-800">Kelola Proyek</a>
                            </div>
                        </aside>

                    </div>
                @endforeach
            @else
                <div class="rounded-[28px] border border-slate-100 bg-white p-12 text-center shadow-sm">
                    <div class="mx-auto flex max-w-md flex-col items-center gap-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-slate-100 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <p class="text-xs uppercase tracking-[0.28em] font-semibold text-slate-400">Belum Ada Proposal</p>
                        <p class="text-sm leading-7 text-slate-500">Belum ada proposal masuk untuk proyek Anda saat ini.</p>
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection