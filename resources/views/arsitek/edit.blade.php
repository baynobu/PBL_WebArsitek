@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-stone-50 py-12 text-stone-900">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-10">
        
        <header class="border-b border-stone-200 pb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-amber-600 animate-pulse"></span>
                    <p class="text-xs font-bold uppercase tracking-[0.25em] text-stone-500">Studio Kerja Arsitek</p>
                </div>
                <h1 class="text-4xl font-black tracking-tight text-stone-900 sm:text-5xl">Ubah Profil Arsitek</h1>
                <p class="max-w-2xl text-sm text-stone-600 leading-relaxed">Perbarui informasi profil agar portofolio dan identitas Anda terlihat lebih profesional.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-5 py-3 text-xs font-semibold text-stone-700 transition hover:bg-stone-50">
                    Kembali
                </a>
            </div>
        </header>

        @if(session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700 font-medium">{{ session('success') }}</div>
        @endif

        <div class="rounded-2xl border border-stone-200 bg-white p-8 shadow-sm w-full">
            <form action="{{ route('arsitek.profile.update') }}" method="post" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid gap-4 md:grid-cols-[150px,1fr]">
                    <div class="rounded-xl border border-stone-200 bg-stone-50 p-3 flex flex-col items-center justify-center">
                        <label class="mb-2 block text-[10px] font-bold uppercase tracking-wider text-stone-500">Foto Profil</label>
                        @if($profil->foto)
                            <img src="{{ asset('storage/' . $profil->foto) }}" alt="foto profil" class="h-24 w-24 rounded-full object-cover border border-stone-200">
                        @else
                            <div class="h-24 w-24 rounded-full bg-stone-200 flex items-center justify-center text-stone-400 font-bold">Foto</div>
                        @endif
                    </div>
                    <div class="space-y-2 flex flex-col justify-center">
                        <label class="block text-sm font-semibold text-stone-850">Unggah Foto Profil Baru</label>
                        <input type="file" name="foto" accept="image/*" class="block w-full text-sm text-stone-500 file:mr-4 file:rounded-xl file:border-0 file:bg-stone-900 file:px-4 file:py-2.5 file:text-xs file:font-semibold file:uppercase file:tracking-wider file:text-white hover:file:bg-stone-800 transition">
                        @error('foto') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-stone-850">Keahlian (pisahkan dengan koma)</label>
                    <input type="text" name="skill" value="{{ old('skill', $profil->skill ?? '') }}" placeholder="Contoh: AutoCAD, SketchUp, Blender, Desain Interior" class="block w-full rounded-xl border border-stone-200 bg-stone-50 px-4 py-3 text-sm text-stone-900 placeholder:text-stone-400 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-amber-500 transition-all">
                    @error('skill') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-stone-850">Deskripsi Diri</label>
                    <textarea name="deskripsi" rows="6" placeholder="Ceritakan latar belakang Anda, filosofi desain, dan spesialisasi arsitektur Anda..." class="block w-full rounded-xl border border-stone-200 bg-stone-50 px-4 py-3 text-sm text-stone-900 placeholder:text-stone-400 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-amber-500 transition-all">{{ old('deskripsi', $profil->deskripsi ?? '') }}</textarea>
                    @error('deskripsi') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-stone-850">Pengalaman Kerja</label>
                    <textarea name="pengalaman" rows="4" placeholder="Sebutkan proyek besar yang pernah Anda kerjakan atau riwayat studio tempat bekerja sebelumnya..." class="block w-full rounded-xl border border-stone-200 bg-stone-50 px-4 py-3 text-sm text-stone-900 placeholder:text-stone-400 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-amber-500 transition-all">{{ old('pengalaman', $profil->pengalaman ?? '') }}</textarea>
                    @error('pengalaman') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
                </div>

                <div class="flex justify-end border-t border-stone-100 pt-6">
                    <button class="inline-flex items-center justify-center rounded-xl bg-amber-600 px-6 py-3 text-xs font-bold uppercase tracking-wider text-white shadow-md shadow-amber-900/10 transition hover:bg-amber-700">
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
