@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-6 text-white shadow-lg">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Lokapasar</p>
                    <h1 class="mt-2 text-3xl font-bold">Daftar Proyek</h1>
                    <p class="mt-2 max-w-2xl text-sm text-blue-100">Temukan lowongan proyek arsitek yang aktif dan sesuai dengan kebutuhan Anda.</p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
            <form method="get" action="{{ route('proyek.index') }}" class="flex flex-col gap-3 md:flex-row md:items-center">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul, deskripsi, lokasi..." class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100" />
                <button class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-700">Cari</button>
            </form>
        </div>

        @if($proyeks->count())
            <div class="grid grid-cols-1 gap-5">
                @foreach($proyeks as $p)
                    <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-0.5 hover:shadow-lg dark:bg-gray-800 dark:ring-gray-700">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                            <div class="space-y-3">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                                        <a href="{{ route('proyek.show', $p) }}" class="hover:text-indigo-600">{{ $p->judul }}</a>
                                    </h2>
                                    <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">{{ strtoupper($p->status) }}</span>
                                </div>
                                <p class="text-sm leading-6 text-gray-600 dark:text-gray-300">{{ Str::limit($p->deskripsi, 200) }}</p>
                                <div class="flex flex-wrap gap-3 text-sm text-gray-500 dark:text-gray-400">
                                    <span>Lokasi: {{ $p->lokasi ?? '-' }}</span>
                                    <span>Budget: {{ number_format($p->budget, 0, ',', '.') }}</span>
                                    <span>Open: {{ $p->open_duration_days ?? '-' }} hari</span>
                                    <span>Progress: {{ $p->progress_percent ?? 0 }}%</span>
                                </div>
                            </div>

                            <a href="{{ route('proyek.show', $p) }}" class="inline-flex h-fit items-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 dark:bg-slate-700">Detail</a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="pt-2">{{ $proyeks->links() }}</div>
        @else
            <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500 shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                Tidak ada proyek ditemukan.
            </div>
        @endif
    </div>
</div>
@endsection
