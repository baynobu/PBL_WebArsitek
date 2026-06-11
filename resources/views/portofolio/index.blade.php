@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-stone-50 py-12 text-stone-900">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-10">
        
        <header class="border-b border-stone-200 pb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-amber-600 animate-pulse"></span>
                    <p class="text-xs font-bold uppercase tracking-[0.25em] text-stone-500">Galeri Portofolio</p>
                </div>
                <h1 class="text-4xl font-black tracking-tight text-stone-900 sm:text-5xl">Portofolio Saya</h1>
                <p class="max-w-2xl text-sm text-stone-600 leading-relaxed">Tampilkan karya terbaik Anda dalam galeri yang rapi dan profesional untuk memikat klien potensial.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('portofolio.create') }}" class="inline-flex items-center justify-center rounded-xl bg-amber-600 px-5 py-3 text-xs font-bold uppercase tracking-wider text-white shadow-md shadow-amber-900/10 transition hover:bg-amber-700">
                    Tambah Portofolio
                </a>
            </div>
        </header>

        @if(session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700 font-medium">{{ session('success') }}</div>
        @endif

        @if($items->count())
            <div class="grid gap-6">
                @foreach($items as $item)
                    <article class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm transition duration-200 hover:border-amber-500 hover:shadow-md md:flex">
                        <div class="md:w-72 shrink-0">
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="h-56 w-full object-cover md:h-full" alt="karya portofolio">
                        </div>
                        <div class="flex-1 p-6 flex flex-col justify-between">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="rounded bg-stone-100 px-2.5 py-1 text-[10px] font-bold text-stone-600 uppercase tracking-wider border border-stone-200">
                                        Kategori: {{ $item->kategori }}
                                    </span>
                                </div>
                                <h3 class="text-2xl font-bold tracking-tight text-stone-900">
                                    {{ $item->judul }}
                                </h3>
                                <p class="text-sm leading-relaxed text-stone-600 max-w-4xl">
                                    {{ $item->deskripsi }}
                                </p>
                            </div>

                            <div class="mt-6 pt-4 border-t border-stone-100 flex items-center justify-end gap-3">
                                <a href="{{ route('portofolio.edit', $item) }}" class="inline-flex h-10 items-center justify-center rounded-xl bg-stone-900 px-5 text-xs font-bold uppercase tracking-wider text-white hover:bg-stone-800 transition">
                                    Ubah
                                </a>
                                <form action="{{ route('portofolio.destroy', $item) }}" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus portofolio ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="inline-flex h-10 items-center justify-center rounded-xl border border-red-200 bg-red-50 px-5 text-xs font-bold uppercase tracking-wider text-red-600 hover:bg-red-100 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="pt-4">{{ $items->links() }}</div>
        @else
            <div class="rounded-2xl border-2 border-dashed border-stone-200 bg-white p-12 text-center">
                <p class="text-sm font-semibold text-stone-500">Belum ada portofolio yang terdaftar.</p>
                <p class="mt-1 text-xs text-stone-400">Gunakan tombol di atas untuk mulai membuat dan memamerkan karya arsitektur Anda.</p>
            </div>
        @endif
    </div>
</div>
@endsection
