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
                        <span>Open: {{ $proyek->open_duration_days ?? '-' }} hari</span>
                        <span>Progress: {{ $proyek->progress_percent ?? 0 }}%</span>
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
                    <div class="mt-3 space-y-2 text-sm text-gray-600 dark:text-gray-300">
                        <p>Progress saat ini: <strong>{{ $proyek->progress_percent ?? 0 }}%</strong></p>
                        <p>Update terakhir: {{ optional($proyek->progress_updated_at)->format('d M Y H:i') ?? '-' }}</p>
                    </div>

                    @auth
                        @if((auth()->user()->id === $proyek->client_id || auth()->user()->id === $proyek->arsitek_terpilih_id) && (int) ($proyek->progress_percent ?? 0) >= 100 && $proyek->status !== 'done')
                            <form method="post" action="{{ route('proyek.updateStatus', $proyek) }}" class="mt-4">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="done">
                                <button class="inline-flex w-full items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Tandai Selesai</button>
                            </form>
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

                    @if($proyek->moderation_note)
                        <div class="mt-4 rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Moderasi Admin</h4>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $proyek->moderation_note }}</p>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Diperbarui: {{ optional($proyek->moderated_at)->format('d M Y H:i') ?? '-' }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6 grid gap-4 lg:grid-cols-2">
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Kontak Client</h3>
                    <div class="mt-3 space-y-2 text-sm text-gray-600 dark:text-gray-300">
                        <p>Nama: <strong class="text-gray-900 dark:text-white">{{ $proyek->client->name ?? '-' }}</strong></p>
                        <p>Email: {{ $proyek->client->email ?? '-' }}</p>
                        <p>Telepon: {{ $proyek->client->phone_number ?? '-' }}</p>
                        <p>WhatsApp: {{ $proyek->client->whatsapp_number ?? '-' }}</p>
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Kontak Arsitek Terpilih</h3>
                    @if($proyek->arsitekTerpilih)
                        <div class="mt-3 space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <p>Nama: <strong class="text-gray-900 dark:text-white">{{ $proyek->arsitekTerpilih->name }}</strong></p>
                            <p>Email: {{ $proyek->arsitekTerpilih->email }}</p>
                            <p>Telepon: {{ $proyek->arsitekTerpilih->phone_number ?? '-' }}</p>
                            <p>WhatsApp: {{ $proyek->arsitekTerpilih->whatsapp_number ?? '-' }}</p>
                        </div>
                    @else
                        <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">Belum ada arsitek terpilih.</p>
                    @endif
                </div>
            </div>

            <div class="mt-6 rounded-2xl bg-gray-50 p-5 dark:bg-gray-900">
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Checklist Progress</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Progress dihitung dari task yang selesai dibanding total bobot task.</p>
                    </div>
                    <div class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ $proyek->progress_percent ?? 0 }}% selesai</div>
                </div>

                <div class="mt-4 h-3 overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                    <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-teal-500" style="width: {{ min(100, max(0, $proyek->progress_percent ?? 0)) }}%"></div>
                </div>

                @php
                    $canAddTasks = auth()->check() && auth()->user()->role === 'client' && auth()->id() === $proyek->client_id;
                    $canToggleTasks = auth()->check() && (
                        (auth()->user()->role === 'client' && auth()->id() === $proyek->client_id) ||
                        (auth()->user()->role === 'arsitek' && auth()->id() === $proyek->arsitek_terpilih_id)
                    );
                @endphp

                @if($canAddTasks)
                    <form method="post" action="{{ route('proyek.tasks.store', $proyek) }}" class="mt-5 grid gap-3 rounded-2xl border border-dashed border-gray-300 bg-white p-4 dark:border-gray-700 dark:bg-gray-800 md:grid-cols-3">
                        @csrf
                        <div class="md:col-span-1">
                            <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Judul Task</label>
                            <input type="text" name="title" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100" placeholder="Contoh: Finalisasi denah">
                        </div>
                        <div class="md:col-span-1">
                            <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Bobot</label>
                            <input type="number" name="weight" value="1" min="1" max="100" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                        </div>
                        <div class="md:col-span-3">
                            <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Catatan</label>
                            <textarea name="description" rows="2" class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100" placeholder="Opsional"></textarea>
                        </div>
                        <div class="md:col-span-3 flex justify-end">
                            <button class="inline-flex items-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 dark:bg-slate-700">Tambah Task</button>
                        </div>
                    </form>
                @endif

                <div class="mt-5 space-y-3">
                    @forelse($proyek->tasks as $task)
                        <div class="flex flex-col gap-3 rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800 md:flex-row md:items-start md:justify-between">
                            <div class="flex items-start gap-3">
                                @if($canToggleTasks)
                                    <form method="post" action="{{ route('proyek.tasks.toggle', [$proyek, $task]) }}" class="pt-1">
                                        @csrf
                                        @method('PATCH')
                                        <button class="h-5 w-5 rounded border border-gray-300 {{ $task->is_done ? 'bg-emerald-500 border-emerald-500' : 'bg-white' }}"></button>
                                    </form>
                                @else
                                    <div class="mt-1 h-5 w-5 rounded border border-gray-300 {{ $task->is_done ? 'bg-emerald-500 border-emerald-500' : 'bg-white' }}"></div>
                                @endif
                                <div>
                                    <div class="font-semibold text-gray-900 dark:text-white {{ $task->is_done ? 'line-through opacity-70' : '' }}">{{ $task->title }}</div>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ $task->description ?? 'Tidak ada catatan.' }}</p>
                                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                        Bobot: {{ $task->weight }} · {{ $task->is_done ? 'Selesai' : 'Belum selesai' }}
                                        @if($task->doneBy)
                                            · Diperbarui oleh: {{ $task->doneBy->name }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $task->is_done ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $task->is_done ? 'Done' : 'Open' }}
                            </span>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-6 text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                            Belum ada checklist task.
                        </div>
                    @endforelse
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
