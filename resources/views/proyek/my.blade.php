@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl font-bold">Proyek Saya</h1>
        <a href="{{ route('proyek.create') }}" class="rounded bg-green-600 px-4 py-2 text-white">Posting Proyek</a>
    </div>

    @if($proyeks->count())
        <div class="space-y-3">
            @foreach($proyeks as $proyek)
                <div class="rounded border p-4">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <h2 class="text-lg font-semibold">{{ $proyek->judul }}</h2>
                        <span class="rounded px-2 py-1 text-sm font-semibold @if($proyek->status === 'open') bg-yellow-100 text-yellow-800 @elseif($proyek->status === 'progress') bg-blue-100 text-blue-800 @else bg-green-100 text-green-800 @endif">{{ strtoupper($proyek->status) }}</span>
                    </div>
                    <div class="mt-1 text-sm text-gray-600">Proposal masuk: {{ $proyek->proposal_count }}</div>
                    <div class="mt-3">
                        <a href="{{ route('proyek.show', $proyek) }}" class="rounded bg-blue-600 px-3 py-1 text-sm text-white">Kelola Proyek</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $proyeks->links() }}</div>
    @else
        <p>Anda belum memiliki proyek.</p>
    @endif
</div>
@endsection
