@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold">Portofolio Saya</h1>

    @if(session('success'))
        <div class="mb-4 rounded border border-green-300 bg-green-50 p-3 text-green-700">{{ session('success') }}</div>
    @endif

    <div class="mt-4 mb-4">
        <a href="{{ route('portofolio.create') }}" class="rounded bg-blue-600 px-3 py-1 text-white">Tambah Portofolio</a>
    </div>

    @if($items->count())
        <div class="grid grid-cols-1 gap-4">
            @foreach($items as $item)
                <div class="rounded border p-3 flex gap-4 items-start">
                    <img src="{{ asset('storage/' . $item->gambar) }}" class="w-32 h-24 object-cover rounded" alt="gambar">
                    <div class="flex-1">
                        <h3 class="font-semibold">{{ $item->judul }}</h3>
                        <div class="text-sm text-gray-600">{{ $item->kategori }}</div>
                        <p class="mt-2 text-sm">{{ Str::limit($item->deskripsi, 200) }}</p>
                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('portofolio.edit', $item) }}" class="rounded bg-yellow-600 px-3 py-1 text-sm text-white">Edit</a>
                            <form action="{{ route('portofolio.destroy', $item) }}" method="post" onsubmit="return confirm('Hapus portofolio?')">
                                @csrf
                                @method('DELETE')
                                <button class="rounded bg-red-600 px-3 py-1 text-sm text-white">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $items->links() }}</div>
    @else
        <p class="text-sm text-gray-600">Belum ada portofolio.</p>
    @endif
</div>
@endsection
