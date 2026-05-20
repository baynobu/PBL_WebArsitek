@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-6 text-white shadow-lg">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-indigo-100">Client Workspace</p>
                    <h1 class="mt-2 text-3xl font-bold">Proyek Saya</h1>
                    <p class="mt-2 max-w-2xl text-sm text-indigo-100">Kelola proyek yang sudah Anda posting dan pantau proposal yang masuk dengan tampilan yang lebih rapi.</p>
                </div>

                <!-- <a href="{{ route('proyek.create') }}" class="inline-flex items-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-indigo-700 shadow-sm hover:bg-indigo-50">Posting Proyek</a> -->
            </div>
        </div>

        @if($proyeks->count())
            <div class="grid gap-4">
                @foreach($proyeks as $proyek)
                    <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-0.5 hover:shadow-lg dark:bg-gray-800 dark:ring-gray-700">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                            <div class="space-y-3">
                                <div class="flex flex-wrap items-center gap-3">
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $proyek->judul }}</h2>
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold @if($proyek->status === 'open') bg-yellow-100 text-yellow-800 @elseif($proyek->status === 'progress') bg-blue-100 text-blue-800 @else bg-emerald-100 text-emerald-800 @endif">{{ strtoupper($proyek->status) }}</span>
                                </div>

                                <div class="flex flex-wrap gap-4 text-sm text-gray-500 dark:text-gray-400">
                                    <span>Proposal masuk: {{ $proyek->proposal_count }}</span>
                                    <span>Budget: {{ number_format($proyek->budget, 0, ',', '.') }}</span>
                                    <span>Deadline: {{ $proyek->deadline }}</span>
                                </div>
                            </div>

                            <a href="{{ route('proyek.show', $proyek) }}" class="inline-flex h-fit items-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 dark:bg-slate-700">Kelola Proyek</a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="pt-2">{{ $proyeks->links() }}</div>
        @else
            <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500 shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                Anda belum memiliki proyek.
            </div>
        @endif
    </div>
</div>
@endsection
