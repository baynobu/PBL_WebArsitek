<x-app-layout>
    <main class="relative min-h-screen overflow-hidden bg-slate-50 py-10">
        <div class="pointer-events-none absolute -left-16 top-12 h-72 w-72 rounded-full bg-gradient-to-br from-indigo-200 via-blue-200 to-slate-200 opacity-30 blur-3xl"></div>
        <div class="pointer-events-none absolute right-0 top-24 h-64 w-64 rounded-full bg-gradient-to-tl from-slate-200 via-indigo-100 to-blue-200 opacity-30 blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10 relative z-10">
            <section class="relative overflow-hidden rounded-[2rem] border border-slate-200/80 bg-white/80 p-8 shadow-[0_18px_70px_rgba(15,23,42,0.08)] backdrop-blur-md">
                <div class="grid gap-8 lg:grid-cols-[1.45fr_0.85fr] lg:items-end">
                    <div class="space-y-6">
                        <p class="text-base font-bold uppercase tracking-[0.14em] text-indigo-600">Beranda Admin</p>
                        <h1 class="max-w-3xl text-5xl font-extrabold tracking-tight text-slate-950 sm:text-6xl">Selamat datang, {{ $user?->name ?? 'Administrator' }}</h1>
                        <p class="max-w-2xl text-base leading-8 text-slate-600">Ringkasan aktivitas platform, moderasi proyek, dan statistik sistem tersedia dalam satu tampilan terpusat.</p>
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="#" class="inline-flex items-center justify-center rounded-full bg-indigo-700 px-7 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-900/20 transition hover:bg-indigo-800">
                                Moderasi Proyek
                            </a>
                            <a href="#" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-7 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-50">Kelola Pengguna</a>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] backdrop-blur-md">
                        <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Informasi Akses</p>
                        <div class="mt-6 space-y-4">
                            <div class="rounded-[1.75rem] border border-slate-100/70 bg-white/90 p-5 shadow-sm">
                                <p class="text-sm text-slate-500">Nama Administrator</p>
                                <p class="mt-2 text-xl font-bold text-slate-950">{{ $user?->name ?? 'Admin Sistem' }}</p>
                            </div>
                            <div class="rounded-[1.75rem] border border-slate-100/70 bg-white/90 p-5 shadow-sm">
                                <p class="text-sm text-slate-500">Tingkat Akses</p>
                                <div class="mt-2 flex flex-wrap items-center gap-3">
                                    <span class="inline-flex rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-indigo-700">Super Admin</span>
                                    <span class="text-sm text-slate-600">Hak Penuh</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="grid gap-6 xl:grid-cols-3">
                <article class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_12px_40px_rgba(15,23,42,0.04)] backdrop-blur-md transition hover:shadow-[0_12px_40px_rgba(15,23,42,0.08)]">
                    <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-500">Total Proyek Sistem</p>
                    <h2 class="mt-4 text-4xl font-extrabold text-slate-950">{{ $totalProyekPlatform ?? 0 }}</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Keseluruhan proyek yang telah dibuat oleh klien di platform.</p>
                </article>
                <article class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_12px_40px_rgba(15,23,42,0.04)] backdrop-blur-md transition hover:shadow-[0_12px_40px_rgba(15,23,42,0.08)]">
                    <p class="text-base font-bold uppercase tracking-[0.14em] text-rose-600">Menunggu Moderasi</p>
                    <h2 class="mt-4 text-4xl font-extrabold text-slate-950">{{ $proyekPendingModerasi ?? 0 }}</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Proyek baru yang membutuhkan peninjauan sebelum ditayangkan.</p>
                </article>
                <article class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_12px_40px_rgba(15,23,42,0.04)] backdrop-blur-md transition hover:shadow-[0_12px_40px_rgba(15,23,42,0.08)]">
                    <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-500">Total Proposal</p>
                    <h2 class="mt-4 text-4xl font-extrabold text-slate-950">{{ $totalProposalSistem ?? 0 }}</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Jumlah proposal penawaran yang diajukan oleh arsitek terdaftar.</p>
                </article>
            </section>

            <section class="grid gap-6 xl:grid-cols-[1.45fr_1fr]">
                <div class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_8px_30px_rgba(15,23,42,0.04)] backdrop-blur-md">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Antrean Moderasi Proyek</p>
                            <p class="mt-2 max-w-2xl text-sm leading-7 text-slate-600">Tinjau proyek yang baru didaftarkan klien untuk memastikan sesuai dengan standar platform.</p>
                        </div>
                        <span class="inline-flex rounded-full border border-rose-200 bg-rose-50 px-5 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-rose-700">TINDAKAN DIPERLUKAN</span>
                    </div>

                    <div class="mt-8 space-y-5">
                        @forelse($unmoderatedProjects ?? [] as $proyek)
                            <article class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm transition hover:border-indigo-200 hover:shadow-md">
                                <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                                    <div>
                                        <div class="flex items-center gap-3">
                                            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-indigo-600">
                                                {{ $proyek->judul }}
                                            </p>
                                        </div>
                                        <p class="mt-3 text-sm text-slate-700">
                                            Klien: <span class="font-semibold text-slate-950">{{ $proyek->client?->name ?? 'Tidak diketahui' }}</span>
                                        </p>
                                    </div>
                                    <div class="flex flex-col items-end gap-2">
                                        <div class="whitespace-nowrap rounded-full bg-slate-100 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-slate-600">
                                            {{ \Carbon\Carbon::parse($proyek->created_at)->diffForHumans() }}
                                        </div>
                                        <a href="#" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 underline underline-offset-4">Tinjau Detail</a>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="flex flex-col items-center justify-center rounded-[1.75rem] border border-dashed border-slate-300 bg-slate-50/50 p-10 text-center shadow-sm">
                                <p class="font-semibold text-slate-700">Antrean Moderasi Kosong</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_8px_30px_rgba(15,23,42,0.04)] backdrop-blur-md">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Proposal Terbaru</p>
                            <p class="mt-2 text-sm leading-7 text-slate-600">Aktivitas penawaran arsitek terakhir di platform.</p>
                        </div>
                        <span class="whitespace-nowrap rounded-full bg-slate-800 px-5 py-2 text-xs font-semibold tracking-[0.14em] text-white">SISTEM LOG</span>
                    </div>
                    
                    <div class="mt-8 space-y-4">
                        @forelse($recentProposals ?? [] as $proposal)
                            <div class="rounded-[1.75rem] border border-slate-100 bg-white p-5 shadow-sm transition hover:bg-slate-50">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-950">Arsitek: {{ $proposal->arsitek?->name ?? 'Anonim' }}</p>
                                        <p class="mt-1 text-xs text-slate-500">Proyek: {{ $proposal->proyek?->judul ?? '-' }}</p>
                                    </div>
                                    <span class="rounded-full px-3 py-1.5 text-[10px] font-bold uppercase tracking-[0.2em] bg-slate-100 text-slate-700">
                                        {{ $proposal->status }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-[1.75rem] border border-slate-100/70 bg-white p-8 text-center text-slate-500 shadow-sm">
                                Belum ada aktivitas proposal terbaru.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>
    </main>
</x-app-layout>