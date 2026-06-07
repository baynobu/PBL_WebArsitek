<x-app-layout>
    <main class="relative min-h-screen overflow-hidden bg-white py-10">
        <div class="pointer-events-none absolute -left-16 top-12 h-72 w-72 rounded-full bg-gradient-to-br from-sky-200 via-violet-200 to-fuchsia-200 opacity-20 blur-3xl"></div>
        <div class="pointer-events-none absolute right-0 top-24 h-64 w-64 rounded-full bg-gradient-to-tl from-cyan-200 via-slate-100 to-purple-200 opacity-20 blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <section class="relative overflow-hidden rounded-[2rem] border border-slate-100/70 bg-white/80 p-8 shadow-[0_18px_70px_rgba(15,23,42,0.12)] backdrop-blur-md">
                <div class="grid gap-8 lg:grid-cols-[1.45fr_0.85fr] lg:items-end">
                    <div class="space-y-6">
                        <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Beranda Klien</p>
                        <h1 class="max-w-3xl text-5xl font-extrabold tracking-tight text-slate-950 sm:text-6xl">Selamat datang kembali, {{ $user?->name ?? 'Client' }}</h1>
                        <p class="max-w-2xl text-base leading-8 text-slate-600">Ringkasan proyek premium Anda hadir dalam tata letak editorial yang lapang dan berkelas.</p>
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('proyek.create') }}"
                            class="inline-flex items-center justify-center rounded-full bg-amber-700 px-7 py-3 text-sm font-semibold text-white shadow-lg shadow-stone-900/10 transition hover:bg-amber-800">
                                Buat Proyek Baru
                            </a>
                            <a href="{{ route('proyek.my') }}" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-7 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-50">Kelola Proyek Saya</a>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-slate-100/70 bg-white/80 p-6 shadow-[0_14px_45px_rgba(15,23,42,0.10)] backdrop-blur-md">
                        <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Ringkasan Akun</p>
                        <div class="mt-6 space-y-4">
                            <div class="rounded-[1.75rem] border border-slate-100/70 bg-white/90 p-5 shadow-md">
                                <p class="text-sm text-slate-500">Nama</p>
                                <p class="mt-2 text-xl font-bold text-slate-950">{{ $user?->name ?? '-' }}</p>
                            </div>
                            <div class="rounded-[1.75rem] border border-slate-100/70 bg-white/90 p-5 shadow-md">
                                <p class="text-sm text-slate-500">Status Akun</p>
                                <div class="mt-2 flex flex-wrap items-center gap-3">
                                    <span class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-emerald-700">Terverifikasi</span>
                                    <span class="text-sm text-slate-600">Klien</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="grid gap-6 xl:grid-cols-3">
                <article class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_12px_40px_rgba(15,23,42,0.08)] backdrop-blur-md">
                    <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Proyek Berjalan</p>
                    <h2 class="mt-4 text-4xl font-extrabold text-slate-950">{{ $proyekAktif }}</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Jumlah proyek yang sedang berlangsung bersama arsitek favorit Anda.</p>
                </article>
                <article class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_12px_40px_rgba(15,23,42,0.08)] backdrop-blur-md">
                    <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Proposal Masuk</p>
                    <h2 class="mt-4 text-4xl font-extrabold text-slate-950">{{ $proposalMasuk }}</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Proposal baru yang menunggu review dan keputusan Anda.</p>
                </article>
                <article class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_12px_40px_rgba(15,23,42,0.08)] backdrop-blur-md">
                    <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Total Anggaran</p>
                    <h2 class="mt-4 text-4xl font-extrabold text-slate-950">Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Total nilai anggaran proyek yang aktif dan terdata dalam akun Anda.</p>
                </article>
            </section>

            <section class="grid gap-6 xl:grid-cols-[1.45fr_1fr]">
                <div class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_8px_30px_rgba(15,23,42,0.04)] backdrop-blur-md">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Proyek yang Sedang Dikerjakan</p>
                            <p class="mt-2 max-w-2xl text-sm leading-7 text-slate-600">Lihat status proyek aktif Anda dalam bentuk editorial yang rapi dan mudah dibaca.</p>
                        </div>
                        <span class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-5 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-emerald-700">AKTIF</span>
                    </div>

                    <div class="mt-8 space-y-5">
                        @forelse($projectsInProgress as $proyek)
                            <article class="rounded-[1.75rem] border border-slate-100/70 bg-white p-6 shadow-md">
                                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-stone-600">
                                            {{ $proyek->judul }}
                                        </p>

                                        <p class="mt-3 text-sm text-slate-700">
                                            Arsitek:
                                            <span class="font-semibold text-slate-950">
                                                {{ $proyek->arsitekTerpilih?->name ?? 'Belum ditentukan' }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="whitespace-nowrap rounded-full bg-sky-50 px-5 py-2 text-xs font-semibold uppercase tracking-wider text-sky-700">
                                        Sedang Berjalan
                                    </div>
                                </div>

                                <!-- PROGRESS DI LUAR FLEX DI ATAS -->
                                <div class="mt-6">
                                    <div class="mb-3 flex items-center justify-between text-sm font-semibold text-slate-700">
                                        <span>Progress</span>
                                        <span>{{ $proyek->progress_percent ?? 0 }}%</span>
                                    </div>

                                    <div class="h-2 overflow-hidden rounded-full bg-slate-100">
                                        <div
                                            class="h-full rounded-full bg-gradient-to-r from-bg-gradient-to-r from-amber-500 to-amber-700"
                                            style="width: {{ $proyek->progress_percent ?? 0 }}%">
                                        </div>
                                    </div>
                                </div>

                            </article>
                        @empty
                            <div class="rounded-[1.75rem] border border-slate-100/70 bg-white p-8 text-center text-slate-500 shadow-md">
                                Tidak ada proyek aktif saat ini.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_8px_30px_rgba(15,23,42,0.04)] backdrop-blur-md">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Tugas & Milestone Terbaru</p>
                            <p class="mt-2 text-sm leading-7 text-slate-600">Daftar tugas terbaru yang sedang dilaksanakan untuk proyek Anda.</p>
                        </div>
                        <span class="whitespace-nowrap rounded-full bg-amber-700 px-5 py-2 text-xs font-semibold tracking-[0.14em] text-white">
                            DAFTAR TUGAS
                        </span>
                    </div>
                    <div class="mt-8 space-y-4">
                        @forelse($recentTasks as $task)
                            <div class="rounded-[1.75rem] border border-slate-100/70 bg-white p-5 shadow-md">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-base font-semibold text-slate-950">{{ $task->title }}</p>
                                        <p class="mt-2 text-sm text-slate-500">{{ $task->proyek?->judul ?? 'Proyek tidak tersedia' }}</p>
                                    </div>
                                    <span class="rounded-full px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.22em] {{ $task->is_done ? 'bg-slate-100 text-slate-600' : 'bg-amber-100 text-amber-700' }}">{{ $task->is_done ? 'Selesai' : 'Dalam Proses' }}</span>
                                </div>
                                @if($task->description)
                                    <p class="mt-4 text-sm leading-7 text-slate-600">{{ $task->description }}</p>
                                @endif
                            </div>
                        @empty
                            <div class="rounded-[1.75rem] border border-slate-100/70 bg-white p-8 text-center text-slate-500 shadow-md">
                                Belum ada tugas terbaru untuk proyek ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>
    </main>
</x-app-layout>
