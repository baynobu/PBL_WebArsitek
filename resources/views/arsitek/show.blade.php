@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
        <a href="{{ url()->previous() }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-700">&larr; Kembali</a>

        <div class="rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-6 text-white shadow-lg">
            <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Arsitek Profile</p>
            <h1 class="mt-2 text-3xl font-bold">Profil Arsitek: {{ $arsitek->name }}</h1>
            <div class="mt-3 flex flex-wrap gap-4 text-sm text-blue-100">
                <span>Rating rata-rata: {{ number_format($arsitek->ratingSebagaiArsitek()->avg('nilai') ?? 0, 1) }} / 5</span>
                <span>Jumlah rating: {{ $arsitek->ratingSebagaiArsitek()->count() }}</span>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <div class="space-y-4">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Email: <span class="font-semibold text-gray-900 dark:text-white">{{ $arsitek->email }}</span></div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Telepon: <span class="font-semibold text-gray-900 dark:text-white">{{ $arsitek->phone_number ?? '-' }}</span></div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">WhatsApp: <span class="font-semibold text-gray-900 dark:text-white">{{ $arsitek->whatsapp_number ?? '-' }}</span></div>
                    <div class="rounded-2xl bg-gray-50 p-4 dark:bg-gray-900">
                        <div class="text-xs uppercase tracking-wide text-gray-500">Skill</div>
                        <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ $arsitek->profilArsitek->skill ?? '-' }}</div>
                    </div>
                    <div class="rounded-2xl bg-gray-50 p-4 dark:bg-gray-900">
                        <div class="text-xs uppercase tracking-wide text-gray-500">Deskripsi</div>
                        <p class="mt-2 text-sm leading-7 text-gray-700 dark:text-gray-300">{{ $arsitek->profilArsitek->deskripsi ?? 'Belum ada deskripsi profil.' }}</p>
                    </div>
                    <div class="rounded-2xl bg-gray-50 p-4 dark:bg-gray-900">
                        <div class="text-xs uppercase tracking-wide text-gray-500">Pengalaman</div>
                        <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ $arsitek->profilArsitek->pengalaman ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Ulasan Terbaru</h2>
                @if($arsitek->ratingSebagaiArsitek()->count())
                    <div class="mt-4 space-y-3">
                        @foreach($arsitek->ratingSebagaiArsitek as $rating)
                            <div class="rounded-2xl border border-gray-200 p-4 dark:border-gray-700">
                                <div class="font-semibold text-gray-900 dark:text-white">{{ $rating->nilai }} / 5</div>
                                <div class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ $rating->komentar ?? '-' }}</div>
                                <div class="mt-2 text-xs text-gray-500">oleh client id: {{ $rating->client_id }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada ulasan.</p>
                @endif
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Portofolio</h2>

            @if($arsitek->portofolio->count())
                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                    @foreach($arsitek->portofolio as $portofolio)
                        <div class="rounded-2xl border border-gray-200 p-4 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $portofolio->judul }}</h3>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Kategori: {{ $portofolio->kategori }}</div>
                            <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-300">{{ $portofolio->deskripsi }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada portofolio.</p>
            @endif
        </div>
    </div>
</div>
@endsection
