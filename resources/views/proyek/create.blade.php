@extends('layouts.app')

@section('content')
<div class="py-10 bg-slate-50">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Header --}}
        <section class="rounded-[32px] border border-slate-100 bg-white p-8 shadow-[0_40px_80px_rgba(15,23,42,0.08)]">
            <div class="max-w-2xl space-y-4">
                <div class="flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-600"></span>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Ruang Kerja Klien</p>
                </div>
                <div class="space-y-3">
                    <h1 class="text-3xl font-bold text-slate-950">Posting Proyek Baru</h1>
                    <p class="max-w-xl text-sm leading-7 text-slate-500">Buat lowongan proyek yang rapi agar arsitek mudah memahami kebutuhan Anda.</p>
                </div>
            </div>
        </section>

        {{-- Form --}}
        <article class="rounded-[28px] border border-slate-100 bg-white shadow-sm overflow-hidden">
            <div class="flex">
                <div class="w-1 shrink-0 bg-stone-800 rounded-l-[28px]"></div>
                <div class="flex-1 p-8">
                    <form method="post" action="{{ route('proyek.store') }}" class="space-y-6">
                        @csrf

                        {{-- Judul --}}
                        <div>
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-slate-600">Judul Proyek</label>
                            <input type="text" name="judul" value="{{ old('judul') }}"
                                placeholder="Contoh: Renovasi Rumah Minimalis 2 Lantai"
                                class="w-full rounded-[14px] border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 placeholder-slate-300 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-100">
                            @error('judul')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-slate-600">Deskripsi</label>
                            <textarea name="deskripsi" rows="5"
                                placeholder="Jelaskan kebutuhan proyek Anda secara detail..."
                                class="w-full rounded-[14px] border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 placeholder-slate-300 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-100">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        {{-- Budget & Deadline --}}
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-slate-600">Anggaran</label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">Rp</span>
                                    <input type="number" name="budget" value="{{ old('budget') }}" min="0" step="0.01"
                                        placeholder="0"
                                        class="w-full rounded-[14px] border border-slate-200 bg-white py-3 pl-10 pr-4 text-sm font-medium text-slate-900 placeholder-slate-300 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-100">
                                </div>
                                @error('budget')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-slate-600">Batas Waktu</label>
                                <input type="date" name="deadline" value="{{ old('deadline') }}"
                                    class="w-full rounded-[14px] border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-100">
                                @error('deadline')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Durasi & Lokasi --}}
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-slate-600">Durasi Buka Projek</label>
                                <div class="relative">
                                    <input type="number" name="open_duration_days" value="{{ old('open_duration_days', 14) }}" min="3" max="90"
                                        class="w-full rounded-[14px] border border-slate-200 bg-white py-3 pl-4 pr-14 text-sm font-medium text-slate-900 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-100">
                                    <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">hari</span>
                                </div>
                                <p class="mt-1.5 text-xs text-slate-400">Maksimal 90 hari, minimal 3 hari.</p>
                                @error('open_duration_days')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-slate-600">Lokasi</label>
                                <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                                    placeholder="Contoh: Surabaya, Jawa Timur"
                                    class="w-full rounded-[14px] border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 placeholder-slate-300 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-100">
                                @error('lokasi')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-between border-t border-slate-100 pt-6">
                            <a href="{{ route('proyek.index') }}" class="text-sm font-medium text-slate-400 transition hover:text-slate-600">← Kembali</a>
                            <button type="submit" class="inline-flex items-center rounded-2xl bg-slate-950 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-950/20 transition duration-200 hover:bg-slate-800">
                                Posting Proyek
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </article>

    </div>
</div>
@endsection