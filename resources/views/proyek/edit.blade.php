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
                    <h1 class="text-3xl font-bold text-slate-950">Ubah Proyek</h1>
                    <p class="max-w-xl text-sm leading-7 text-slate-500">Edit informasi proyek Anda, perbarui opsi publikasi, atau jadwalkan ulang.</p>
                </div>
            </div>
        </section>

        {{-- Form --}}
        <article class="rounded-[28px] border border-slate-100 bg-white shadow-sm overflow-hidden">
            <div class="flex">
                <div class="w-1 shrink-0 bg-stone-800 rounded-l-[28px]"></div>
                <div class="flex-1 p-8">
                    <form method="post" action="{{ route('proyek.update', $proyek) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Judul --}}
                        <div>
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-slate-600">Judul Proyek</label>
                            <input type="text" name="judul" value="{{ old('judul', $proyek->judul) }}"
                                placeholder="Contoh: Renovasi Rumah Minimalis 2 Lantai"
                                class="w-full rounded-[14px] border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 placeholder-slate-300 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-100">
                            @error('judul')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-slate-600">Deskripsi</label>
                            <textarea name="deskripsi" rows="5"
                                placeholder="Jelaskan kebutuhan proyek Anda secara detail..."
                                class="w-full rounded-[14px] border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 placeholder-slate-300 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-100">{{ old('deskripsi', $proyek->deskripsi) }}</textarea>
                            @error('deskripsi')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        {{-- Budget & Deadline --}}
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-slate-600">Anggaran</label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">Rp</span>
                                    <input type="number" name="budget" value="{{ old('budget', $proyek->budget) }}" min="0" step="0.01"
                                        placeholder="0"
                                        class="w-full rounded-[14px] border border-slate-200 bg-white py-3 pl-10 pr-4 text-sm font-medium text-slate-900 placeholder-slate-300 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-100">
                                </div>
                                @error('budget')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-slate-600">Batas Waktu</label>
                                <input type="date" name="deadline" value="{{ old('deadline', $proyek->deadline ? $proyek->deadline->format('Y-m-d') : '') }}"
                                    class="w-full rounded-[14px] border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-100">
                                @error('deadline')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Durasi & Lokasi --}}
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-slate-600">Durasi Buka Projek</label>
                                <div class="relative">
                                    <input type="number" name="open_duration_days" value="{{ old('open_duration_days', $proyek->open_duration_days ?? 14) }}" min="3" max="90"
                                        class="w-full rounded-[14px] border border-slate-200 bg-white py-3 pl-4 pr-14 text-sm font-medium text-slate-900 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-100">
                                    <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">hari</span>
                                </div>
                                <p class="mt-1.5 text-xs text-slate-400">Maksimal 90 hari, minimal 3 hari.</p>
                                @error('open_duration_days')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-slate-600">Lokasi</label>
                                <input type="text" name="lokasi" value="{{ old('lokasi', $proyek->lokasi) }}"
                                    placeholder="Contoh: Surabaya, Jawa Timur"
                                    class="w-full rounded-[14px] border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 placeholder-slate-300 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-100">
                                @error('lokasi')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Opsi Publikasi (Draft / Schedule / Publish) --}}
                        @php
                            $currentAction = 'publish';
                            if ($proyek->status === 'draft') {
                                $currentAction = 'draft';
                            } elseif ($proyek->status === 'scheduled') {
                                $currentAction = 'schedule';
                            }
                        @endphp
                        <div x-data="{ action: '{{ old('action', $currentAction) }}' }" class="border-t border-slate-100 pt-6 space-y-4">
                            <label class="block text-xs font-semibold uppercase tracking-[0.22em] text-slate-600">Opsi Publikasi</label>
                            
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                                {{-- Publish --}}
                                <label :class="action === 'publish' ? 'border-amber-400 bg-amber-50/20 ring-2 ring-amber-100' : 'border-slate-200'" class="flex cursor-pointer items-start gap-3 rounded-[14px] border p-4 transition hover:bg-slate-50/50">
                                    <input type="radio" name="action" value="publish" x-model="action" class="mt-1 border-slate-350 text-amber-700 focus:ring-amber-550">
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">Posting Sekarang</p>
                                        <p class="mt-1 text-xs text-slate-500">Proyek langsung aktif dan dapat dilihat oleh arsitek.</p>
                                    </div>
                                </label>

                                {{-- Draft --}}
                                <label :class="action === 'draft' ? 'border-amber-400 bg-amber-50/20 ring-2 ring-amber-100' : 'border-slate-200'" class="flex cursor-pointer items-start gap-3 rounded-[14px] border p-4 transition hover:bg-slate-50/50">
                                    <input type="radio" name="action" value="draft" x-model="action" class="mt-1 border-slate-350 text-amber-700 focus:ring-amber-550">
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">Simpan sebagai Draft</p>
                                        <p class="mt-1 text-xs text-slate-500">Simpan sebagai draft untuk diedit atau diposting nanti.</p>
                                    </div>
                                </label>

                                {{-- Schedule --}}
                                <label :class="action === 'schedule' ? 'border-amber-400 bg-amber-50/20 ring-2 ring-amber-100' : 'border-slate-200'" class="flex cursor-pointer items-start gap-3 rounded-[14px] border p-4 transition hover:bg-slate-50/50">
                                    <input type="radio" name="action" value="schedule" x-model="action" class="mt-1 border-slate-350 text-amber-700 focus:ring-amber-550">
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">Jadwalkan Posting</p>
                                        <p class="mt-1 text-xs text-slate-500">Jadwalkan postingan proyek secara otomatis di masa mendatang.</p>
                                    </div>
                                </label>
                            </div>

                            {{-- Tanggal Penjadwalan --}}
                            <div x-show="action === 'schedule'" x-transition class="rounded-[14px] border border-slate-200 bg-slate-50 p-4 space-y-2">
                                <label class="block text-xs font-semibold uppercase tracking-[0.22em] text-slate-600">Tanggal & Waktu Publikasi</label>
                                <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at', $proyek->scheduled_at ? $proyek->scheduled_at->format('Y-m-d\TH:i') : '') }}"
                                    class="w-full rounded-[10px] border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-900 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-100">
                                @error('scheduled_at')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-between border-t border-slate-100 pt-6">
                            <a href="{{ route('proyek.show', $proyek) }}" class="text-sm font-medium text-slate-400 transition hover:text-slate-600">← Kembali</a>
                            <button type="submit" class="inline-flex items-center rounded-2xl bg-amber-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-amber-900/20 transition duration-200 hover:bg-amber-800">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </article>

    </div>
</div>
@endsection
