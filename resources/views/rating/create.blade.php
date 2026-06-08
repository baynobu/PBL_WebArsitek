@extends('layouts.app')

@section('content')
<div class="py-10 bg-slate-50">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Header --}}
        <section class="rounded-[32px] border border-slate-100 bg-white p-8 shadow-[0_40px_80px_rgba(15,23,42,0.08)]">
            <div class="max-w-2xl space-y-4">
                <div class="flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-600"></span>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Ulasan Klien</p>
                </div>
                <div class="space-y-3">
                    <h1 class="text-3xl font-bold text-slate-950">Beri Penilaian</h1>
                    <p class="max-w-xl text-sm leading-7 text-slate-500">Proyek: {{ $proyek->judul }}</p>
                </div>
            </div>
        </section>

        {{-- Form --}}
        <article class="rounded-[28px] border border-slate-100 bg-white shadow-sm overflow-hidden">
            <div class="flex">
                <div class="w-1 shrink-0 bg-stone-800 rounded-l-[28px]"></div>
                <div class="flex-1 p-8">
                    <form action="{{ route('rating.store', $proyek) }}" method="post" class="space-y-6">
                        @csrf

                        {{-- Nilai --}}
                        <div>
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-slate-600">Nilai (1–5)</label>
                            <select name="nilai"
                                class="w-full rounded-[14px] border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-100">
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('nilai')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        {{-- Komentar --}}
                        <div>
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.22em] text-slate-600">Komentar <span class="normal-case tracking-normal font-normal text-slate-400">(opsional)</span></label>
                            <textarea name="komentar" rows="5"
                                placeholder="Ceritakan pengalaman Anda bekerja sama dengan arsitek ini..."
                                class="w-full rounded-[14px] border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 placeholder-slate-300 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-100">{{ old('komentar') }}</textarea>
                            @error('komentar')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-between border-t border-slate-100 pt-6">
                            <a href="{{ route('proyek.show', $proyek) }}" class="text-sm font-medium text-slate-400 transition hover:text-slate-600">← Kembali</a>
                            <button type="submit" class="inline-flex items-center rounded-2xl bg-slate-950 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-950/20 transition duration-200 hover:bg-slate-800">
                                Kirim Penilaian
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </article>

    </div>
</div>
@endsection