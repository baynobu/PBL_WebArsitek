@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="rounded-2xl bg-gradient-to-r from-amber-600 to-orange-600 px-6 py-6 text-white shadow-lg">
            <p class="text-xs uppercase tracking-[0.2em] text-amber-100">Proposal Center</p>
            <h1 class="mt-2 text-3xl font-bold">Daftar Proposal</h1>
            <p class="mt-2 text-sm text-amber-100">Pantau seluruh proposal yang masuk atau yang Anda kirim dalam satu tampilan yang rapi.</p>
        </div>

        @if(session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">{{ session('error') }}</div>
        @endif

        @if($proposals->count())
            <div class="grid gap-4">
                @foreach($proposals as $pr)
                    <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <a class="text-xl font-bold text-gray-900 hover:text-indigo-600 dark:text-white" href="{{ route('proposal.show', $pr) }}">Proposal untuk: {{ $pr->proyek->judul }}</a>
                                <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">Harga: {{ number_format($pr->harga_tawaran,0,',','.') }} · Estimasi: {{ $pr->estimasi_waktu }} hari · Status: {{ $pr->status }}</div>
                            </div>
                            <a href="{{ route('proposal.show', $pr) }}" class="inline-flex items-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 dark:bg-slate-700">Detail</a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500 shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                Tidak ada proposal ditemukan.
            </div>
        @endif
    </div>
</div>
@endsection
