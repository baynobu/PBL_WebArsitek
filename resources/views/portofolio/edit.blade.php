@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-stone-50 py-12 text-stone-900">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 space-y-10">
        
        <header class="border-b border-stone-200 pb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-amber-600 animate-pulse"></span>
                    <p class="text-xs font-bold uppercase tracking-[0.25em] text-stone-500">Galeri Portofolio</p>
                </div>
                <h1 class="text-4xl font-black tracking-tight text-stone-900 sm:text-5xl">Ubah Portofolio</h1>
                <p class="max-w-2xl text-sm text-stone-600 leading-relaxed">Perbarui detail karya terbaik Anda agar tetap akurat dan menarik.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('portofolio.index') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-5 py-3 text-xs font-semibold text-stone-700 transition hover:bg-stone-50">
                    Kembali
                </a>
            </div>
        </header>

        <div class="rounded-2xl border border-stone-200 bg-white p-8 shadow-sm max-w-2xl mx-auto">
            <form action="{{ route('portofolio.update', $portofolio) }}" method="post" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-stone-850">Judul Karya</label>
                    <input type="text" name="judul" value="{{ old('judul', $portofolio->judul) }}" placeholder="Contoh: Desain Villa Bali Modern" class="block w-full rounded-xl border border-stone-200 bg-stone-50 px-4 py-3 text-sm text-stone-900 placeholder:text-stone-400 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-amber-500 transition-all">
                    @error('judul') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-stone-850">Kategori</label>
                    <input type="text" name="kategori" value="{{ old('kategori', $portofolio->kategori) }}" placeholder="Contoh: Residensial, Komersial, Lanskap" class="block w-full rounded-xl border border-stone-200 bg-stone-50 px-4 py-3 text-sm text-stone-900 placeholder:text-stone-400 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-amber-500 transition-all">
                    @error('kategori') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-stone-850">Deskripsi Karya</label>
                    <textarea name="deskripsi" rows="6" placeholder="Ceritakan detail konsep desain, material, luas tapak, dan tantangan yang diselesaikan..." class="block w-full rounded-xl border border-stone-200 bg-stone-50 px-4 py-3 text-sm text-stone-900 placeholder:text-stone-400 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-amber-500 transition-all">{{ old('deskripsi', $portofolio->deskripsi) }}</textarea>
                    @error('deskripsi') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
                </div>

                <div class="grid gap-4 md:grid-cols-[180px,1fr]">
                    <div class="rounded-xl border border-stone-200 bg-stone-50 p-3 flex flex-col items-center">
                        <label class="mb-2 block text-xs font-semibold text-stone-500 uppercase tracking-wider">Gambar Saat Ini</label>
                        <img src="{{ asset('storage/' . $portofolio->gambar) }}" class="h-28 w-full rounded-lg object-cover" alt="gambar portofolio">
                    </div>
                    <div class="space-y-2 flex flex-col justify-center">
                        <label class="block text-sm font-semibold text-stone-850">Ganti Gambar (opsional)</label>
                        <input type="file" name="gambar" accept="image/*" class="block w-full text-sm text-stone-500 file:mr-4 file:rounded-xl file:border-0 file:bg-stone-900 file:px-4 file:py-2.5 file:text-xs file:font-semibold file:uppercase file:tracking-wider file:text-white hover:file:bg-stone-800 transition">
                        @error('gambar') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="flex justify-end border-t border-stone-100 pt-6">
                    <button class="inline-flex items-center justify-center rounded-xl bg-amber-600 px-6 py-3 text-xs font-bold uppercase tracking-wider text-white shadow-md shadow-amber-900/10 transition hover:bg-amber-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
