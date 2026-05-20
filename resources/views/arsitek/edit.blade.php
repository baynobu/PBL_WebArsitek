@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="rounded-2xl bg-gradient-to-r from-slate-700 to-slate-900 px-6 py-6 text-white shadow-lg">
            <p class="text-xs uppercase tracking-[0.2em] text-slate-200">Arsitek Workspace</p>
            <h1 class="mt-2 text-3xl font-bold">Edit Profil Arsitek</h1>
            <p class="mt-2 text-sm text-slate-200">Perbarui informasi profil agar portofolio dan identitas Anda terlihat lebih profesional.</p>
        </div>

        @if(session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700">{{ session('success') }}</div>
        @endif

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
            <form action="{{ route('arsitek.profile.update') }}" method="post" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Foto Profil</label>
                    @if($profil->foto)
                        <img src="{{ asset('storage/' . $profil->foto) }}" alt="foto" class="mb-3 h-28 w-28 rounded-2xl object-cover ring-4 ring-white dark:ring-gray-800">
                    @endif
                    <input type="file" name="foto" accept="image/*" class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-slate-700 file:px-4 file:py-2 file:text-white hover:file:bg-slate-800 dark:text-gray-300">
                    @error('foto') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Skill (comma separated)</label>
                    <input type="text" name="skill" value="{{ old('skill', $profil->skill ?? '') }}" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                    @error('skill') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Deskripsi</label>
                    <textarea name="deskripsi" rows="6" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">{{ old('deskripsi', $profil->deskripsi ?? '') }}</textarea>
                    @error('deskripsi') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Pengalaman</label>
                    <textarea name="pengalaman" rows="4" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">{{ old('pengalaman', $profil->pengalaman ?? '') }}</textarea>
                </div>

                <div class="flex justify-end border-t border-gray-200 pt-5 dark:border-gray-700">
                    <button class="inline-flex items-center rounded-lg bg-slate-700 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Simpan Profil</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
