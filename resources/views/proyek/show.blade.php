@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
        @if(session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">{{ session('error') }}</div>
        @endif

        <a href="{{ route('proyek.index') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-700">&larr; Kembali ke daftar</a>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div class="space-y-3">
                    <div class="flex flex-wrap items-center gap-2">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $proyek->judul }}</h1>
                        <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">{{ strtoupper($proyek->status) }}</span>
                    </div>
                    <div class="flex flex-wrap gap-3 text-sm text-gray-500 dark:text-gray-400">
                        <span>Lokasi: {{ $proyek->lokasi ?? '-' }}</span>
                        <span>Budget: {{ number_format($proyek->budget,0,',','.') }}</span>
                        <span>Deadline: {{ $proyek->deadline }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 rounded-2xl bg-gray-50 p-5 dark:bg-gray-900">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Deskripsi</h2>
                    <p class="mt-3 leading-7 text-gray-700 dark:text-gray-300">{{ $proyek->deskripsi }}</p>
                </div>

                <div class="rounded-2xl bg-gray-50 p-5 dark:bg-gray-900">
                    <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Status Proyek</h3>
                    <p class="mt-3 text-2xl font-bold text-gray-900 dark:text-white">{{ strtoupper($proyek->status) }}</p>

                    @auth
                        @if(auth()->user()->id === $proyek->client_id || auth()->user()->id === $proyek->arsitek_terpilih_id)
                            @if($proyek->status === 'progress')
                                <form method="post" action="{{ route('proyek.updateStatus', $proyek) }}" class="mt-4">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="done">
                                    <button class="inline-flex w-full items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Tandai Selesai</button>
                                </form>
                            @endif
                        @endif
                    @endauth

                    <div class="mt-4 rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Rating</h4>
                        @if($proyek->rating)
                            <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">Nilai: <strong>{{ $proyek->rating->nilai }}/5</strong></div>
                            <div class="text-sm text-gray-600 dark:text-gray-300">Komentar: {{ $proyek->rating->komentar ?? '-' }}</div>
                        @else
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada rating.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @auth
            @if(auth()->user()->role === 'arsitek')
                @php
                    $ver = \App\Models\VerifikasiUser::where('user_id', auth()->id())->first();
                @endphp
                @if($ver && $ver->status === 'verified' && $proyek->status === 'open')
                    <div class="rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 p-5 text-white shadow-lg">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">Tersedia untuk proposal</h3>
                                <p class="text-sm text-blue-100">Akun Anda terverifikasi dan proyek masih terbuka.</p>
                            </div>
                            <a href="{{ route('proposal.create', $proyek) }}" class="inline-flex items-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-blue-700 hover:bg-blue-50">Ajukan Proposal</a>
                        </div>
                    </div>
                @endif
            @endif

            @if(auth()->user()->id === $proyek->client_id)
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Review Proposal</h3>
                        <span class="text-sm text-gray-500">{{ $proyek->proposal->count() }} proposal</span>
                    </div>

                    @if($proyek->proposal->count())
                        <div class="space-y-4">
                            @foreach($proyek->proposal as $proposal)
                                <div class="rounded-2xl border border-gray-200 p-5 dark:border-gray-700 dark:bg-gray-900">
                                    <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                                        <div>
                                            <div class="font-semibold text-gray-900 dark:text-white">{{ $proposal->arsitek->name ?? 'Arsitek' }}</div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">Harga: {{ number_format($proposal->harga_tawaran, 0, ',', '.') }} · Estimasi: {{ $proposal->estimasi_waktu }} hari · Status: {{ $proposal->status }}</div>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('proposal.show', $proposal) }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Detail Proposal</a>
                                            <a href="{{ route('arsitek.show', $proposal->arsitek_id) }}" class="inline-flex items-center rounded-lg bg-slate-700 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Profil Arsitek</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada proposal masuk.</p>
                    @endif
                </div>
            @endif
        @endauth
    </div>
</div>
@endsection
