@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold">Posting Proyek Baru</h1>

    <form method="post" action="{{ route('proyek.store') }}" class="mt-4 max-w-2xl">
        @csrf

        <label class="mb-2 block">Judul</label>
        <input type="text" name="judul" value="{{ old('judul') }}" class="w-full rounded border p-2">
        @error('judul')<div class="text-red-600">{{ $message }}</div>@enderror

        <label class="mb-2 mt-4 block">Deskripsi</label>
        <textarea name="deskripsi" class="w-full rounded border p-2" rows="5">{{ old('deskripsi') }}</textarea>
        @error('deskripsi')<div class="text-red-600">{{ $message }}</div>@enderror

        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <label class="mb-2 block">Budget</label>
                <input type="number" name="budget" value="{{ old('budget') }}" class="w-full rounded border p-2" min="0" step="0.01">
                @error('budget')<div class="text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="mb-2 block">Deadline</label>
                <input type="date" name="deadline" value="{{ old('deadline') }}" class="w-full rounded border p-2">
                @error('deadline')<div class="text-red-600">{{ $message }}</div>@enderror
            </div>
        </div>

        <label class="mb-2 mt-4 block">Lokasi</label>
        <input type="text" name="lokasi" value="{{ old('lokasi') }}" class="w-full rounded border p-2">
        @error('lokasi')<div class="text-red-600">{{ $message }}</div>@enderror

        <div class="mt-5">
            <button class="rounded bg-green-600 px-4 py-2 text-white">Posting Proyek</button>
        </div>
    </form>
</div>
@endsection
