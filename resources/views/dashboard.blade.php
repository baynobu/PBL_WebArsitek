<x-app-layout>
    <main class="relative min-h-screen overflow-hidden bg-white py-10">
        <div class="pointer-events-none absolute -left-16 top-12 h-72 w-72 rounded-full bg-gradient-to-br from-sky-200 via-violet-200 to-fuchsia-200 opacity-20 blur-3xl"></div>
        <div class="pointer-events-none absolute right-0 top-24 h-64 w-64 rounded-full bg-gradient-to-tl from-cyan-200 via-slate-100 to-purple-200 opacity-20 blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            <section class="relative overflow-hidden rounded-[2rem] border border-slate-100/70 bg-white/80 p-8 shadow-[0_18px_70px_rgba(15,23,42,0.12)] backdrop-blur-md">
                <div class="grid gap-8 lg:grid-cols-[1.45fr_0.85fr] lg:items-end">
                    <div class="space-y-6">
                        <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Beranda Admin</p>
                        <h1 class="max-w-3xl text-5xl font-extrabold tracking-tight text-slate-950 sm:text-6xl">Selamat datang, {{ $user?->name ?? 'Administrator' }}</h1>
                        <p class="max-w-2xl text-base leading-8 text-slate-600">Pantau seluruh aktivitas platform, kelola moderasi proyek, dan tinjau performa sistem secara menyeluruh di sini.</p>
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="#"
                            class="inline-flex items-center justify-center rounded-full bg-amber-700 px-7 py-3 text-sm font-semibold text-white shadow-lg shadow-stone-900/10 transition hover:bg-amber-800">
                                Tinjau Proyek Baru
                            </a>
                            <a href="#" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-7 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-50">Kelola Pengguna</a>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-slate-100/70 bg-white/80 p-6 shadow-[0_14px_45px_rgba(15,23,42,0.10)] backdrop-blur-md">
                        <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Akses Sistem</p>
                        <div class="mt-6 space-y-4">
                            <div class="rounded-[1.75rem] border border-slate-100/70 bg-white/90 p-5 shadow-md">
                                <p class="text-sm text-slate-500">Nama Admin</p>
                                <p class="mt-2 text-xl font-bold text-slate-950">{{ $user?->name ?? 'Admin Platform' }}</p>
                            </div>
                            <div class="rounded-[1.75rem] border border-slate-100/70 bg-white/90 p-5 shadow-md">
                                <p class="text-sm text-slate-500">Level Otoritas</p>
                                <div class="mt-2 flex flex-wrap items-center gap-3">
                                    <span class="inline-flex rounded-full border border-violet-200 bg-violet-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-violet-700">Super Admin</span>
                                    <span class="text-sm text-slate-600">Akses Penuh</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="grid gap-6 xl:grid-cols-3">
                <article class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_12px_40px_rgba(15,23,42,0.08)] backdrop-blur-md">
                    <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Total Proyek</p>
                    <h2 class="mt-4 text-4xl font-extrabold text-slate-950">{{ $totalProyekPlatform ?? 0 }}</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Keseluruhan proyek yang telah dibuat oleh klien di platform.</p>
                </article>
                <article class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_12px_40px_rgba(15,23,42,0.08)] backdrop-blur-md">
                    <p class="text-base font-bold uppercase tracking-[0.14em] text-amber-600">Menunggu Moderasi</p>
                    <h2 class="mt-4 text-4xl font-extrabold text-slate-950">{{ $proyekPendingModerasi ?? 0 }}</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Proyek baru yang membutuhkan peninjauan sebelum ditayangkan.</p>
                </article>
                <article class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_12px_40px_rgba(15,23,42,0.08)] backdrop-blur-md">
                    <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Total Proposal</p>
                    <h2 class="mt-4 text-4xl font-extrabold text-slate-950">{{ $totalProposalSistem ?? 0 }}</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Jumlah proposal yang telah diajukan oleh arsitek di sistem.</p>
                </article>
            </section>

            <section class="grid gap-6 xl:grid-cols-[1.45fr_1fr]">
                
                <div class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_8px_30px_rgba(15,23,42,0.04)] backdrop-blur-md">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Antrean Moderasi Proyek</p>
                            <p class="mt-2 max-w-2xl text-sm leading-7 text-slate-600">Tinjau proyek yang baru didaftarkan klien untuk memastikan sesuai standar platform.</p>
                        </div>
                        <span class="inline-flex rounded-full border border-rose-200 bg-rose-50 px-5 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-rose-700">TINDAKAN DIPERLUKAN</span>
                    </div>

                    <div class="mt-8 space-y-5">
                        @forelse($unmoderatedProjects ?? [] as $proyek)
                            <article class="rounded-[1.75rem] border border-slate-100/70 bg-white p-6 shadow-md transition hover:border-amber-200">
                                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <div class="flex items-center gap-3">
                                            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-stone-600">
                                                {{ $proyek->judul }}
                                            </p>
                                        </div>

                                        <p class="mt-3 text-sm text-slate-700">
                                            Klien:
                                            <span class="font-semibold text-slate-950">
                                                {{ $proyek->client?->name ?? 'Data tidak tersedia' }}
                                            </span>
                                        </p>
                                        <p class="mt-1 text-sm text-slate-500">
                                            Budget: Rp {{ number_format($proyek->budget ?? 0, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div class="flex flex-col items-end gap-3">
                                        <div class="whitespace-nowrap rounded-full bg-amber-50 px-5 py-2 text-xs font-semibold uppercase tracking-wider text-amber-700 border border-amber-200">
                                            Pending Review
                                        </div>
                                        <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 underline underline-offset-4">Tinjau Detail</a>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="rounded-[1.75rem] border border-slate-100/70 bg-white p-8 text-center text-slate-500 shadow-md">
                                Antrean moderasi kosong. Semua proyek telah ditinjau.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_8px_30px_rgba(15,23,42,0.04)] backdrop-blur-md">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Aktivitas Proposal</p>
                            <p class="mt-2 text-sm leading-7 text-slate-600">Log proposal penawaran terbaru dari arsitek di platform.</p>
                        </div>
                        <span class="whitespace-nowrap rounded-full bg-slate-800 px-5 py-2 text-xs font-semibold tracking-[0.14em] text-white">
                            SISTEM LOG
                        </span>
                    </div>
                    <div class="mt-8 space-y-4">
                        @forelse($recentProposals ?? [] as $proposal)
                            <div class="rounded-[1.75rem] border border-slate-100/70 bg-white p-5 shadow-md">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-base font-semibold text-slate-950">{{ $proposal->arsitek?->name ?? 'Arsitek' }}</p>
                                        <p class="mt-2 text-sm text-slate-500">Proyek: {{ $proposal->proyek?->judul ?? 'Tidak tersedia' }}</p>
                                    </div>
                                    <span class="rounded-full px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.22em] 
                                        {{ strtolower($proposal->status) == 'terima' || strtolower($proposal->status) == 'accepted' ? 'bg-emerald-100 text-emerald-700' : (strtolower($proposal->status) == 'tolak' || strtolower($proposal->status) == 'rejected' ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-600') }}">
                                        {{ $proposal->status ?? 'Pending' }}
                                    </span>
                                </div>
                                <div class="mt-4 pt-4 border-t border-slate-50 flex items-center gap-4 text-xs font-medium text-slate-500">
                                    <span>Tawaran: Rp {{ number_format($proposal->harga_tawaran ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-[1.75rem] border border-slate-100/70 bg-white p-8 text-center text-slate-500 shadow-md">
                                Belum ada log proposal terbaru.
                            </div>
                        @endforelse
                    </div>
                </div>
                
            </section>
        </div>
    </main>
</x-app-layout>