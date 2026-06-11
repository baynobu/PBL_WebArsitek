@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-10" x-data="{ openAddTask: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @php
            $isClientOwner = auth()->check() && auth()->id() === $proyek->client_id;
            $isAssignedArchitect = auth()->check() && auth()->id() === $proyek->arsitek_terpilih_id;
            $backRoute = $isClientOwner ? route('proyek.my') : route('proyek.index');
            $backLabel = $isClientOwner ? 'Kembali ke Proyek Saya' : 'Kembali ke daftar proyek';
            $deadline = $proyek->deadline ? \Carbon\Carbon::parse($proyek->deadline) : null;
            $remainingDays = $deadline ? max(0, $deadline->diffInDays(now())) : null;
            $progress = max(0, min(100, $proyek->progress_percent ?? 0));

            $statusLabel = match(strtolower($proyek->status)) {
                'open', 'active' => 'Buka',
                'progress' => 'Sedang Berjalan',
                'pending' => 'Menunggu',
                'done', 'completed' => 'Selesai',
                'closed' => 'Ditutup',
                'draft' => 'Draft',
                'rejected' => 'Ditolak',
                default => strtoupper($proyek->status ?? 'Unknown'),
            };

            $statusBadgeClass = match(strtolower($proyek->status)) {
                'open', 'active' => 'bg-emerald-100 text-emerald-700',
                'progress' => 'bg-sky-100 text-sky-700',
                'pending' => 'bg-amber-100 text-amber-700',
                'done', 'completed', 'closed', 'draft' => 'bg-slate-100 text-slate-600',
                'rejected' => 'bg-rose-100 text-rose-700',
                default => 'bg-slate-100 text-slate-600',
            };
        @endphp

        @if(session('success'))
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-700 shadow-sm mb-6">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="rounded-3xl border border-red-200 bg-red-50 px-5 py-4 text-red-700 shadow-sm mb-6">{{ session('error') }}</div>
        @endif

        <div class="grid gap-8 lg:grid-cols-3 mt-8">

            {{-- LEFT COLUMN --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Header card --}}
                <div class="rounded-[28px] border border-slate-100 bg-white shadow-sm overflow-hidden">
                    <div class="w-full h-1 bg-stone-800"></div>
                    <div class="p-8 space-y-4">
                        <a href="{{ $backRoute }}" class="inline-flex items-center text-sm font-medium text-slate-500 transition hover:text-slate-950">
                            <span class="mr-2 text-base leading-none">←</span>{{ $backLabel }}
                        </a>
                        <div class="space-y-3">
                            <div class="flex flex-wrap items-center gap-3">
                                <h1 class="text-2xl font-bold text-slate-950">{{ $proyek->judul ?? 'Desain Rumah Tinggal Minimalis 2 Lantai' }}</h1>
                                <span class="rounded-full px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] {{ $statusBadgeClass }}">{{ $statusLabel }}</span>
                            </div>
                            <p class="text-sm leading-7 text-slate-500">{{ $proyek->deskripsi ?? 'Proyek ini fokus pada pengalaman hunian premium, arsitektur modern, dan ruang keluarga yang terintegrasi dengan taman privat.' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Image placeholder --}}
                <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-sm">
                    <div class="overflow-hidden rounded-[20px] bg-slate-100">
                        <div class="aspect-[16/9] flex items-center justify-center text-slate-400">
                            <div class="text-center">
                                <div class="mb-4 inline-flex h-24 w-24 items-center justify-center rounded-[1.5rem] bg-white text-4xl shadow-sm">🏛️</div>
                                <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Rendering Arsitektur</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Editorial brief --}}
                <div class="rounded-[28px] border border-slate-100 bg-white p-8 shadow-sm space-y-6">
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                            <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Deskripsi Proyek</p>
                        </div>
                        <p class="mt-4 text-sm leading-8 text-slate-500">{{ $proyek->deskripsi ?? 'Deskripsi mendalam menyoroti tujuan, karakter estetika, dan kebutuhan fungsional proyek arsitektur ini pada setiap fase pengerjaan.' }}</p>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-[22px] bg-slate-50 p-5">
                            <h3 class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Kebutuhan Utama</h3>
                            <p class="mt-3 text-sm leading-6 text-slate-600">Ruang terbuka, pencahayaan alami, dan aliran sirkulasi yang jelas.</p>
                        </div>
                        <div class="rounded-[22px] bg-slate-50 p-5">
                            <h3 class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Prioritas Desain</h3>
                            <p class="mt-3 text-sm leading-6 text-slate-600">Memaksimalkan kenyamanan, privasi, dan estetika material netral.</p>
                        </div>
                    </div>
                </div>

                {{-- Owner profile --}}
                <div class="rounded-[28px] border border-slate-100 bg-white p-8 shadow-sm">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex h-14 w-14 items-center justify-center rounded-[18px] bg-slate-100 text-lg font-bold text-slate-700">{{ strtoupper(substr($proyek->client->name ?? 'RS', 0, 2)) }}</div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Profil Pemilik</p>
                            </div>
                            <p class="mt-1 text-sm leading-6 text-slate-600">{{ $proyek->client->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-3">
                        <div class="rounded-[22px] bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Po-sel</p>
                            <p class="mt-2 text-sm font-semibold text-slate-950">{{ $proyek->client->email ?? '-' }}</p>
                        </div>
                        <div class="rounded-[22px] bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">WhatsApp</p>
                            <p class="mt-2 text-sm font-semibold text-slate-950">{{ $proyek->client->whatsapp_number ?? '-' }}</p>
                        </div>
                        <div class="rounded-[22px] bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Lokasi Proyek</p>
                            <p class="mt-2 text-sm font-semibold text-slate-950">{{ $proyek->lokasi ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN --}}
            <div class="space-y-6">

                {{-- Quick summary --}}
                <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                        <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Ringkasan Proyek</p>
                    </div>
                    <p class="mt-1 mb-5 text-sm leading-6 text-slate-600">Detail cepat proyek yang sedang berjalan.</p>

                    <div class="space-y-3">
                        <div class="rounded-[22px] bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-indigo-400">Lokasi</p>
                            <p class="mt-2 text-sm font-semibold text-indigo-900">{{ $proyek->lokasi ?? 'Malang' }}</p>
                        </div>
                        <div class="rounded-[22px] bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-emerald-500">Anggaran</p>
                            <p class="mt-2 text-sm font-semibold text-emerald-900">Rp {{ number_format($proyek->budget ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="rounded-[22px] bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-sky-400">Sisa Waktu</p>
                            <p class="mt-2 text-sm font-semibold text-sky-900">{{ $remainingDays !== null ? $remainingDays . ' Hari' : '-' }}</p>
                        </div>
                        <div class="rounded-[22px] bg-slate-50 p-4">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-xs uppercase tracking-[0.2em] text-amber-500">Progress</p>
                                <span class="text-xs font-semibold text-amber-700">{{ $progress }}%</span>
                            </div>
                            <div class="h-1.5 overflow-hidden rounded-full bg-amber-100">
                                <div class="h-full rounded-full bg-amber-500 transition-all duration-500" style="width: {{ $progress }}%;"></div>
                            </div>
                        </div>
                    </div>

                    @if($isClientOwner)
                        @if($proyek->status !== 'done')
                            <form method="post" action="{{ route('proyek.updateStatus', $proyek) }}" class="mt-5">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="done">
                                <button type="submit" class="w-full rounded-2xl bg-amber-700 py-3.5 text-sm font-semibold text-white shadow-md shadow-amber-700/20 transition hover:bg-amber-800">Selesaikan Proyek</button>
                            </form>
                        @elseif(! $proyek->rating()->exists())
                            <a href="{{ route('rating.create', $proyek) }}" class="mt-5 inline-flex w-full items-center justify-center rounded-2xl bg-amber-700 py-3.5 text-sm font-semibold text-white shadow-md shadow-amber-700/20 transition hover:bg-amber-800">Beri Penilaian</a>
                        @else
                            <div class="mt-5 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700">Rating arsitek sudah dikirim.</div>
                        @endif
                    @endif
                    @if($isClientOwner && $proyek->status === 'open')
                        <form method="post" action="{{ route('proyek.destroy', $proyek) }}" class="mt-3" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full rounded-2xl border border-rose-200 bg-rose-50 py-3.5 text-sm font-semibold text-rose-600 transition hover:bg-rose-100">Hapus Proyek</button>
                        </form>
                    @endif

                    @if(auth()->check() && auth()->user()->role === 'arsitek')
                        @php
                            $alreadySubmitted = $proyek->proposal()->where('arsitek_id', auth()->id())->first();
                        @endphp
                        @if($proyek->status === 'open')
                            @if($alreadySubmitted)
                                <div class="mt-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 text-center">
                                    Anda telah mengajukan proposal untuk proyek ini.
                                    <a href="{{ route('proposal.show', $alreadySubmitted) }}" class="block mt-2 font-bold text-emerald-950 underline">Lihat Detail Proposal Anda</a>
                                </div>
                            @else
                                <a href="{{ route('proposal.create', $proyek) }}" class="mt-5 inline-flex w-full items-center justify-center rounded-2xl bg-amber-700 py-3.5 text-sm font-semibold text-white shadow-md shadow-amber-700/20 transition hover:bg-amber-800">Ajukan Proposal</a>
                            @endif
                        @endif
                    @endif
                </div>

                {{-- Task management --}}
                <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                            <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Manajemen Tugas</p>
                        </div>
                        @if($isClientOwner && $proyek->status !== 'done')
                            <button type="button" @click="openAddTask = !openAddTask" class="inline-flex items-center rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">+ Tambah</button>
                        @endif
                    </div>
                    <p class="mb-5 text-sm leading-6 text-slate-600">Tugas &amp; milestone yang sedang dikerjakan.</p>

                    <div x-show="openAddTask" x-cloak class="mb-5 rounded-[22px] border border-slate-100 bg-slate-50 p-5">
                        <form method="post" action="{{ route('proyek.tasks.store', $proyek) }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">Judul Tugas</label>
                                <input name="title" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-950 shadow-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200" placeholder="Contoh: Finalisasi denah lantai" />
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">Keterangan</label>
                                <textarea name="description" rows="3" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-950 shadow-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200" placeholder="Opsional"></textarea>
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">Berat Progress</label>
                                <input type="number" name="weight" min="1" max="100" value="1" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-950 shadow-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200" placeholder="1 - 100" />
                            </div>
                            <button type="submit" class="w-full rounded-2xl bg-amber-700 py-3 text-sm font-semibold text-white shadow-md shadow-amber-700/20 transition hover:bg-amber-800">Tambahkan Tugas</button>
                        </form>
                    </div>

                    <div class="space-y-3">
                        @php $sortedTasks = $proyek->tasks->sortByDesc('created_at'); @endphp
                        @forelse($sortedTasks as $task)
                            <div class="rounded-[22px] border border-slate-100 bg-slate-50 p-4">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <div class="space-y-1.5">
                                        <div class="flex flex-wrap items-center gap-2">
                                            @if($task->is_done)
                                                <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-700">Selesai</span>
                                            @else
                                                <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-[11px] font-semibold uppercase tracking-[0.2em] text-amber-700">Dalam Proses</span>
                                            @endif
                                            <p class="text-sm font-semibold text-slate-950">{{ $task->title }}</p>
                                        </div>
                                        <p class="text-sm text-slate-500">{{ $task->description ?? 'Tidak ada detail tugas.' }}</p>
                                    </div>
                                    @if($isAssignedArchitect)
                                        <form method="post" action="{{ route('proyek.tasks.toggle', ['proyek' => $proyek, 'task' => $task]) }}" class="shrink-0">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50">{{ $task->is_done ? 'Batalkan' : 'Selesaikan' }}</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="rounded-[22px] border border-dashed border-slate-200 bg-slate-50 p-6 text-center text-sm text-slate-400">Belum ada tugas untuk saat ini.</div>
                        @endforelse
                    </div>
                </div>

                {{-- Proposals --}}
                <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                            <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Arsitek Kandidat</p>
                        </div>
                        @if($isAssignedArchitect)
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-700">Terpilih</span>
                        @endif
                    </div>
                    <p class="mb-5 text-sm leading-6 text-slate-600">Proposal masuk dari arsitek kandidat.</p>

                    <div class="space-y-3">
                        @php
                            $visibleProposals = $proyek->proposal->filter(function ($p) use ($isClientOwner) {
                                return $isClientOwner || (auth()->check() && auth()->id() === $p->arsitek_id);
                            });
                        @endphp
                        @forelse($visibleProposals as $proposal)
                            @php
                                $pStatus = strtolower($proposal->status);
                                $pBadge = match(true) {
                                    in_array($pStatus, ['diterima','accepted'])  => 'bg-emerald-100 text-emerald-700',
                                    in_array($pStatus, ['ditolak','rejected'])   => 'bg-rose-100 text-rose-700',
                                    in_array($pStatus, ['pending','menunggu','review','menunggu review']) => 'bg-amber-100 text-amber-700',
                                    default => 'bg-slate-100 text-slate-600',
                                };
                            @endphp
                            <div class="rounded-[22px] border border-slate-100 bg-slate-50 p-4">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-950">{{ $proposal->arsitek->name ?? 'Arsitek' }}</p>
                                        <p class="mt-1 text-xs text-slate-500">Rp {{ number_format($proposal->harga_tawaran, 0, ',', '.') }} · {{ $proposal->estimasi_waktu }} hari</p>
                                    </div>
                                    <span class="inline-flex rounded-full px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] {{ $pBadge }}">{{ strtoupper($proposal->status) }}</span>
                                </div>
                                <p class="mt-3 text-sm leading-6 text-slate-500">{{ $proposal->catatan ?? 'Tidak ada catatan tambahan.' }}</p>
                            </div>
                        @empty
                            <div class="rounded-[22px] border border-dashed border-slate-200 bg-slate-50 p-6 text-center text-sm text-slate-400">Belum ada proposal masuk.</div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection