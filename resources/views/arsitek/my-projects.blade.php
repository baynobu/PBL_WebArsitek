@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-stone-50 py-12 text-stone-900">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-10">
        
        <header class="border-b border-stone-200 pb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-amber-600 animate-pulse"></span>
                    <p class="text-xs font-bold uppercase tracking-[0.25em] text-stone-500">Studio Kerja Arsitek</p>
                </div>
                <h1 class="text-4xl font-black tracking-tight text-stone-900 sm:text-5xl">Workspace Proyek</h1>
                <p class="max-w-2xl text-sm text-stone-600 leading-relaxed">Kelola seluruh ajuan blueprint, negosiasi harga penawaran, dan monitoring status proyek aktif Anda dalam satu panel terintegrasi.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('proyek.index') }}" class="inline-flex items-center justify-center rounded-xl bg-amber-600 px-5 py-3 text-xs font-bold uppercase tracking-wider text-white shadow-md shadow-amber-900/10 transition hover:bg-amber-700">
                    Eksplor Tender Baru
                </a>
                <a href="{{ route('portofolio.index') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-5 py-3 text-xs font-semibold text-stone-700 transition hover:bg-stone-50">
                    Galeri Portofolio
                </a>
            </div>
        </header>

        @php
            $totalProposal = $proposals->count();
            $proposalDiterima = $proposals->filter(fn($p) => in_array(strtolower($p->status), ['accepted', 'terima']))->count();
            $proposalDitolak = $proposals->filter(fn($p) => in_array(strtolower($p->status), ['rejected', 'tolak']))->count();
            $proposalReview = $totalProposal - $proposalDiterima - $proposalDitolak;
            
            // Kalkulasi Win Rate Proyek
            $winRate = $totalProposal > 0 ? round(($proposalDiterima / $totalProposal) * 100) : 0;
        @endphp

        <section class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-stone-400">Total Ajuan</p>
                    <h3 class="mt-2 text-3xl font-black text-stone-900">{{ $totalProposal }}</h3>
                </div>
                <div class="rounded-xl bg-stone-100 p-3 text-stone-600">📂</div>
            </div>

            <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-emerald-600">Disetujui Klien</p>
                    <h3 class="mt-2 text-3xl font-black text-stone-900">{{ $proposalDiterima }}</h3>
                </div>
                <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600">✓</div>
            </div>

            <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-amber-600">Tahap Review</p>
                    <h3 class="mt-2 text-3xl font-black text-stone-900">{{ $proposalReview }}</h3>
                </div>
                <div class="rounded-xl bg-amber-50 p-3 text-amber-600">⏳</div>
            </div>

            <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-stone-400">Rasio Menang</p>
                    <h3 class="mt-2 text-3xl font-black text-stone-900">{{ $winRate }}%</h3>
                </div>
                <div class="rounded-xl bg-stone-100 p-3 text-stone-600">📈</div>
            </div>
        </section>

        <section class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold text-stone-900 uppercase tracking-wider">Daftar Kontrak & Proposal Anda</h2>
                <span class="text-xs font-medium text-stone-500">Menampilkan {{ $totalProposal }} berkas penawaran</span>
            </div>

            @if($proposals->count())
                <div class="grid gap-6">
                    @foreach($proposals as $proposal)
                        <article class="group rounded-2xl border border-stone-200 bg-white p-6 shadow-sm transition duration-200 hover:border-amber-500 hover:shadow-md">
                            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                                
                                <div class="space-y-4 flex-1">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span class="rounded bg-stone-100 px-2 py-0.5 text-[10px] font-bold text-stone-600 uppercase tracking-wider border border-stone-200">
                                            Status Proyek: {{ $proposal->proyek->status }}
                                        </span>
                                        
                                        <span class="rounded-full px-3 py-0.5 text-xs font-bold uppercase tracking-wide border
                                            {{ in_array(strtolower($proposal->status), ['accepted', 'terima']) ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 
                                              (in_array(strtolower($proposal->status), ['rejected', 'tolak']) ? 'bg-rose-50 text-rose-700 border-rose-200' : 
                                              'bg-amber-50 text-amber-700 border-amber-200') }}">
                                            {{ $proposal->status }}
                                        </span>
                                    </div>

                                    <h3 class="text-2xl font-bold tracking-tight text-stone-900 group-hover:text-amber-700 transition">
                                        <a href="{{ route('proposal.show', $proposal) }}">{{ $proposal->proyek->judul }}</a>
                                    </h3>

                                    <div class="grid grid-cols-2 gap-4 sm:flex sm:flex-wrap sm:gap-x-8 text-xs font-semibold text-stone-600 border-t border-b border-stone-100 py-3">
                                        <div class="space-y-0.5">
                                            <p class="text-stone-400 font-normal">Harga Penawaran Anda</p>
                                            <p class="text-amber-700 font-bold text-sm">Rp {{ number_format($proposal->harga_tawaran, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="space-y-0.5">
                                            <p class="text-stone-400 font-normal">Pagu Anggaran Klien</p>
                                            <p class="text-stone-900">Rp {{ number_format($proposal->proyek->budget, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="space-y-0.5">
                                            <p class="text-stone-400 font-normal">Lokasi Tapak Proyek</p>
                                            <p class="text-stone-900">{{ $proposal->proyek->lokasi ?? '-' }}</p>
                                        </div>
                                    </div>

                                    @if($proposal->deskripsi)
                                        <p class="text-sm leading-relaxed text-stone-600 max-w-5xl line-clamp-2">
                                            {{ $proposal->deskripsi }}
                                        </p>
                                    @endif
                                </div>

                                <div class="flex flex-row lg:flex-col gap-2 min-w-max w-full lg:w-auto pt-4 border-t border-stone-100 lg:border-t-0 lg:pt-0">
                                    <a href="{{ route('proposal.show', $proposal) }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-stone-900 px-5 text-xs font-bold uppercase tracking-wider text-white hover:bg-stone-800 transition w-full lg:w-36 text-center">
                                        Buka Proposal
                                    </a>
                                    <a href="{{ route('proyek.show', $proposal->proyek) }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-white border border-stone-300 px-5 text-xs font-bold uppercase tracking-wider text-stone-700 hover:bg-stone-50 transition w-full lg:w-36 text-center">
                                        Lihat Proyek
                                    </a>
                                </div>

                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border-2 border-dashed border-stone-200 bg-white p-12 text-center">
                    <p class="text-sm font-semibold text-stone-500">Tidak ada arsip lamaran proyek.</p>
                    <p class="mt-1 text-xs text-stone-400">Gunakan tombol di atas untuk mulai mencari tender dan mengajukan cetak cetak cetak sketsa pertama Anda.</p>
                </div>
            @endif
        </section>

    </div>
</div>
@endsection