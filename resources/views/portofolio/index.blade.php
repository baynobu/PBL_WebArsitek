@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="rounded-2xl bg-gradient-to-r from-pink-600 to-fuchsia-600 px-6 py-6 text-white shadow-lg">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-pink-100">Arsitek Workspace</p>
                    <h1 class="mt-2 text-3xl font-bold">Portofolio Saya</h1>
                    <p class="mt-2 text-sm text-pink-100">Tampilkan karya terbaik Anda dalam galeri yang rapi dan profesional.</p>
                </div>
                <a href="{{ route('portofolio.create') }}" class="inline-flex items-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-pink-700 hover:bg-pink-50">Tambah Portofolio</a>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700">{{ session('success') }}</div>
        @endif

        @if($items->count())
            <div class="grid gap-5">
                @foreach($items as $item)
                    <article class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-0.5 hover:shadow-lg dark:bg-gray-800 dark:ring-gray-700 md:flex">
                        <div class="md:w-72">
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="h-56 w-full object-cover md:h-full" alt="gambar">
                        </div>
                        <div class="flex-1 p-6">
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $item->judul }}</h3>
                                    <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $item->kategori }}</div>
                                    <p class="mt-3 text-sm leading-6 text-gray-600 dark:text-gray-300">{{ Str::limit($item->deskripsi, 200) }}</p>
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('portofolio.edit', $item) }}" class="inline-flex items-center rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-600">Edit</a>
                                    <form action="{{ route('portofolio.destroy', $item) }}" method="post" onsubmit="return confirm('Hapus portofolio?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="pt-2">{{ $items->links() }}</div>
        @else
            <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500 shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                Belum ada portofolio.
            </div>
        @endif
    </div>
</div>
@endsection
