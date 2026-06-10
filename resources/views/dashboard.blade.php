<x-app-layout>
    <main class="relative min-h-screen overflow-hidden bg-white py-10">
        <div class="pointer-events-none absolute -left-16 top-12 h-72 w-72 rounded-full bg-gradient-to-br from-sky-200 via-violet-200 to-fuchsia-200 opacity-20 blur-3xl"></div>
        <div class="pointer-events-none absolute right-0 top-24 h-64 w-64 rounded-full bg-gradient-to-tl from-cyan-200 via-slate-100 to-purple-200 opacity-20 blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            @if(auth()->user()->role === 'admin')
                <!-- ADMIN DASHBOARD TABS -->
                <div class="flex flex-wrap gap-2 border-b border-stone-200 pb-4 mb-8">
                    <a href="?tab=dashboard" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider rounded-xl transition {{ $tab === 'dashboard' ? 'bg-amber-600 text-white shadow-sm shadow-amber-900/10' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                        Ikhtisar
                    </a>
                    <a href="?tab=users" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider rounded-xl transition relative {{ $tab === 'users' ? 'bg-amber-600 text-white shadow-sm shadow-amber-900/10' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                        Verifikasi Pengguna
                        @if($unverifiedUsers->count() > 0)
                            <span class="absolute -top-1.5 -right-1.5 flex h-5 w-5 items-center justify-center rounded-full bg-rose-600 text-[10px] font-bold text-white animate-pulse">
                                {{ $unverifiedUsers->count() }}
                            </span>
                        @endif
                    </a>
                    <a href="?tab=projects" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider rounded-xl transition {{ $tab === 'projects' ? 'bg-amber-600 text-white shadow-sm shadow-amber-900/10' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                        Manajemen Proyek
                    </a>
                    <a href="?tab=landing" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider rounded-xl transition {{ $tab === 'landing' ? 'bg-amber-600 text-white shadow-sm shadow-amber-900/10' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                        Kelola Landing Page
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700 font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                @if($tab === 'dashboard')
                    <!-- TAB 1: OVERVIEW -->
                    <section class="relative overflow-hidden rounded-[2rem] border border-slate-100/70 bg-white/80 p-8 shadow-[0_18px_70px_rgba(15,23,42,0.12)] backdrop-blur-md">
                        <div class="grid gap-8 lg:grid-cols-[1.45fr_0.85fr] lg:items-end">
                            <div class="space-y-6">
                                <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Beranda Admin</p>
                                <h1 class="max-w-3xl text-5xl font-extrabold tracking-tight text-slate-950 sm:text-6xl">Selamat datang, {{ $user?->name ?? 'Administrator' }}</h1>
                                <p class="max-w-2xl text-base leading-8 text-slate-600">Pantau seluruh aktivitas platform, kelola moderasi proyek, dan tinjau performa sistem secara menyeluruh di sini.</p>
                                <div class="flex flex-wrap items-center gap-3">
                                    <a href="?tab=projects"
                                    class="inline-flex items-center justify-center rounded-full bg-amber-700 px-7 py-3 text-sm font-semibold text-white shadow-lg shadow-stone-900/10 transition hover:bg-amber-800">
                                        Tinjau Proyek Baru
                                    </a>
                                    <a href="?tab=users" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-7 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-50">Kelola Pengguna</a>
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

                    <section class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
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

                    <section class="grid gap-6 lg:grid-cols-[1.45fr_1fr]">
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
                                                    Anggaran: Rp {{ number_format($proyek->budget ?? 0, 0, ',', '.') }}
                                                </p>
                                            </div>

                                            <div class="flex flex-col items-end gap-3">
                                                <div class="whitespace-nowrap rounded-full bg-amber-50 px-5 py-2 text-xs font-semibold uppercase tracking-wider text-amber-700 border border-amber-200">
                                                    Menunggu Moderasi
                                                </div>
                                                <a href="{{ route('proyek.show', $proyek) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 underline underline-offset-4">Tinjau Detail</a>
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
                                    LOG SISTEM
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
                                            @php
                                                $proposalStatus = strtolower($proposal->status);
                                                $displayProposalStatus = $proposalStatus == 'terima' || $proposalStatus == 'accepted' ? 'Diterima' : ($proposalStatus == 'tolak' || $proposalStatus == 'rejected' ? 'Ditolak' : 'Pending');
                                            @endphp
                                            <span class="rounded-full px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.22em] 
                                                {{ $proposalStatus == 'terima' || $proposalStatus == 'accepted' ? 'bg-emerald-100 text-emerald-700' : ($proposalStatus == 'tolak' || $proposalStatus == 'rejected' ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-600') }}">
                                                {{ $displayProposalStatus }}
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

                @elseif($tab === 'users')
                    <!-- TAB 2: USER VERIFICATION -->
                    <div class="rounded-[2rem] border border-slate-100/70 bg-white p-8 shadow-[0_18px_70px_rgba(15,23,42,0.08)]">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-slate-950">Persetujuan Verifikasi Pengguna</h2>
                            <p class="text-sm text-slate-500">Daftar pengguna terdaftar yang masih menunggu verifikasi akun untuk dapat mengakses fitur platform.</p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-slate-600">
                                <thead class="bg-stone-50 text-xs font-bold uppercase tracking-wider text-stone-700">
                                    <tr>
                                        <th class="px-6 py-4">Nama</th>
                                        <th class="px-6 py-4">Pos-el (Email)</th>
                                        <th class="px-6 py-4">Peran (Role)</th>
                                        <th class="px-6 py-4">Terdaftar Pada</th>
                                        <th class="px-6 py-4 text-right">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-stone-100">
                                    @forelse($unverifiedUsers as $usr)
                                        <tr class="hover:bg-stone-50/50">
                                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $usr->name }}</td>
                                            <td class="px-6 py-4">{{ $usr->email }}</td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium uppercase tracking-wide {{ $usr->role === 'arsitek' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                                                    {{ $usr->role }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-stone-500">{{ $usr->created_at->format('d M Y H:i') }}</td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="inline-flex items-center gap-2">
                                                    <form action="{{ route('admin.users.approve', $usr) }}" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui verifikasi pengguna ini?')">
                                                        @csrf
                                                        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-white hover:bg-emerald-700 transition">
                                                            Setujui
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.users.reject', $usr) }}" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menolak verifikasi pengguna ini?')">
                                                        @csrf
                                                        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-rose-650 px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-white hover:bg-rose-700 transition">
                                                            Tolak
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-8 text-center text-stone-500">Tidak ada pengguna yang menunggu verifikasi saat ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                @elseif($tab === 'projects')
                    <!-- TAB 3: PROJECT MANAGEMENT -->
                    <div class="rounded-[2rem] border border-slate-100/70 bg-white p-8 shadow-[0_18px_70px_rgba(15,23,42,0.08)]">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-slate-950">Manajemen & Moderasi Proyek</h2>
                            <p class="text-sm text-slate-500">Kelola daftar seluruh proyek di platform. Anda dapat menyembunyikan proyek yang melanggar aturan atau menandai proyek terpilih (featured).</p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-slate-600">
                                <thead class="bg-stone-50 text-xs font-bold uppercase tracking-wider text-stone-700">
                                    <tr>
                                        <th class="px-6 py-4">Judul Proyek</th>
                                        <th class="px-6 py-4">Klien</th>
                                        <th class="px-6 py-4">Arsitek Terpilih</th>
                                        <th class="px-6 py-4">Status / Progres</th>
                                        <th class="px-6 py-4 text-center">Featured</th>
                                        <th class="px-6 py-4 text-center">Visibilitas</th>
                                        <th class="px-6 py-4 text-right">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-stone-100">
                                    @forelse($allProjects as $proj)
                                        <tr class="hover:bg-stone-50/50">
                                            <td class="px-6 py-4 font-semibold text-slate-900">
                                                <a href="{{ route('proyek.show', $proj) }}" class="hover:text-amber-600 transition underline underline-offset-2">
                                                    {{ $proj->judul }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 text-stone-700 font-medium">{{ $proj->client?->name ?? '-' }}</td>
                                            <td class="px-6 py-4 text-stone-600">{{ $proj->arsitekTerpilih?->name ?? '-' }}</td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col gap-1">
                                                    <span class="inline-flex w-max rounded-full px-2 py-0.5 text-xs font-semibold uppercase tracking-wider
                                                        {{ $proj->status === 'open' ? 'bg-amber-100 text-amber-800' : ($proj->status === 'progress' ? 'bg-blue-100 text-blue-800' : 'bg-emerald-100 text-emerald-800') }}">
                                                        {{ $proj->status }}
                                                    </span>
                                                    @if($proj->status === 'progress')
                                                        <span class="text-xs text-stone-500 font-semibold">{{ $proj->progress_percent }}%</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <form action="{{ route('admin.proyek.toggle-featured', $proj) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold tracking-wide transition {{ $proj->is_featured ? 'bg-amber-600 text-white shadow-sm' : 'bg-stone-150 text-stone-600 hover:bg-stone-200' }}">
                                                        <span>{{ $proj->is_featured ? 'Ya' : 'Tidak' }}</span>
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <form action="{{ route('admin.proyek.toggle-hidden', $proj) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold tracking-wide transition {{ $proj->is_hidden ? 'bg-rose-100 text-rose-800 border border-rose-200' : 'bg-emerald-100 text-emerald-850 border border-emerald-200' }}">
                                                        <span>{{ $proj->is_hidden ? 'Sembunyi' : 'Tampil' }}</span>
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('proyek.show', $proj) }}" class="inline-flex items-center justify-center rounded-lg border border-stone-300 bg-white px-3 py-1.5 text-xs font-semibold text-stone-700 hover:bg-stone-50 transition">
                                                    Tinjau
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-8 text-center text-stone-500">Belum ada proyek yang terdaftar.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $allProjects->links() }}
                        </div>
                    </div>

                @elseif($tab === 'landing')
                    <!-- TAB 4: LANDING PAGE CONTENT MANAGEMENT -->
                    <div x-data="{ editingContent: null, isAdding: false }" class="rounded-[2rem] border border-slate-100/70 bg-white p-8 shadow-[0_18px_70px_rgba(15,23,42,0.08)]">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-slate-950">Kelola Konten Landing Page</h2>
                                <p class="text-sm text-slate-500">Ubah teks dinamis, statistik, dan bagian penunjang lainnya pada landing page secara langsung.</p>
                            </div>
                            <button @click="isAdding = true" class="inline-flex items-center justify-center rounded-xl bg-amber-600 px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white hover:bg-amber-700 shadow-md transition">
                                Tambah Konten
                            </button>
                        </div>

                        <!-- Add Form Container (Alpine.js toggle) -->
                        <div x-show="isAdding" x-cloak class="mb-8 p-6 rounded-2xl border border-stone-200 bg-stone-50/50 space-y-4">
                            <h3 class="text-lg font-bold text-stone-900">Tambah Konten Baru</h3>
                            <form action="{{ route('admin.landing-content.store') }}" method="post" class="grid gap-4 md:grid-cols-2">
                                @csrf
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600">Bagian (Section)</label>
                                    <select name="section" required class="block w-full rounded-xl border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-900 focus:border-amber-500 focus:outline-none">
                                        <option value="hero">Hero</option>
                                        <option value="stats">Stats</option>
                                        <option value="feature">Feature</option>
                                        <option value="footer">Footer</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600">Key (Unik)</label>
                                    <input type="text" name="key" required placeholder="Contoh: hero_title" class="block w-full rounded-xl border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-900 focus:border-amber-500 focus:outline-none">
                                </div>
                                <div class="space-y-1 md:col-span-2">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600">Value (Konten)</label>
                                    <textarea name="value" rows="3" required placeholder="Konten teks atau HTML..." class="block w-full rounded-xl border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-900 focus:border-amber-500 focus:outline-none"></textarea>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600">Tipe Data</label>
                                    <select name="type" required class="block w-full rounded-xl border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-900 focus:border-amber-500 focus:outline-none">
                                        <option value="text">Teks Biasa</option>
                                        <option value="html">HTML</option>
                                        <option value="number">Angka</option>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600">Urutan (Sort Order)</label>
                                    <input type="number" name="sort_order" required value="0" class="block w-full rounded-xl border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-900 focus:border-amber-500 focus:outline-none">
                                </div>
                                <div class="flex items-center gap-2 py-2">
                                    <input type="checkbox" name="is_active" id="is_active_new" value="1" checked class="rounded border-stone-300 text-amber-600 focus:ring-amber-500">
                                    <label for="is_active_new" class="text-xs font-bold uppercase tracking-wider text-stone-600">Aktifkan Konten</label>
                                </div>
                                <div class="md:col-span-2 flex justify-end gap-2 border-t border-stone-150 pt-4">
                                    <button type="button" @click="isAdding = false" class="rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-xs font-semibold text-stone-700 hover:bg-stone-50">Batal</button>
                                    <button type="submit" class="rounded-xl bg-amber-600 px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-white hover:bg-amber-700">Simpan</button>
                                </div>
                            </form>
                        </div>

                        <!-- Edit Form Container (Alpine.js toggle) -->
                        <div x-show="editingContent !== null" x-cloak class="mb-8 p-6 rounded-2xl border border-amber-200 bg-amber-50/10 space-y-4">
                            <h3 class="text-lg font-bold text-stone-900">Ubah Konten: <span class="text-amber-700" x-text="editingContent?.key"></span></h3>
                            <form :action="`/admin/landing-content/${editingContent?.id}`" method="post" class="grid gap-4 md:grid-cols-2">
                                @csrf
                                @method('PUT')
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600">Bagian (Section)</label>
                                    <select name="section" x-model="editingContent.section" required class="block w-full rounded-xl border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-900 focus:border-amber-500 focus:outline-none">
                                        <option value="hero">Hero</option>
                                        <option value="stats">Stats</option>
                                        <option value="feature">Feature</option>
                                        <option value="footer">Footer</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600">Key (Unik)</label>
                                    <input type="text" name="key" x-model="editingContent.key" required class="block w-full rounded-xl border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-900 focus:border-amber-500 focus:outline-none">
                                </div>
                                <div class="space-y-1 md:col-span-2">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600">Value (Konten)</label>
                                    <textarea name="value" x-model="editingContent.value" rows="5" required class="block w-full rounded-xl border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-900 focus:border-amber-500 focus:outline-none"></textarea>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600">Tipe Data</label>
                                    <select name="type" x-model="editingContent.type" required class="block w-full rounded-xl border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-900 focus:border-amber-500 focus:outline-none">
                                        <option value="text">Teks Biasa</option>
                                        <option value="html">HTML</option>
                                        <option value="number">Angka</option>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600">Urutan (Sort Order)</label>
                                    <input type="number" name="sort_order" x-model="editingContent.sort_order" required class="block w-full rounded-xl border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-900 focus:border-amber-500 focus:outline-none">
                                </div>
                                <div class="flex items-center gap-2 py-2">
                                    <input type="checkbox" name="is_active" id="is_active_edit" value="1" :checked="editingContent.is_active" class="rounded border-stone-300 text-amber-600 focus:ring-amber-500">
                                    <label for="is_active_edit" class="text-xs font-bold uppercase tracking-wider text-stone-600">Aktifkan Konten</label>
                                </div>
                                <div class="md:col-span-2 flex justify-end gap-2 border-t border-amber-100 pt-4">
                                    <button type="button" @click="editingContent = null" class="rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-xs font-semibold text-stone-700 hover:bg-stone-50">Batal</button>
                                    <button type="submit" class="rounded-xl bg-amber-600 px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-white hover:bg-amber-700">Perbarui</button>
                                </div>
                            </form>
                        </div>

                        <!-- Data Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-slate-600">
                                <thead class="bg-stone-50 text-xs font-bold uppercase tracking-wider text-stone-700">
                                    <tr>
                                        <th class="px-6 py-4">Section</th>
                                        <th class="px-6 py-4">Key</th>
                                        <th class="px-6 py-4">Tipe</th>
                                        <th class="px-6 py-4">Value</th>
                                        <th class="px-6 py-4 text-center">Urutan</th>
                                        <th class="px-6 py-4 text-center">Status</th>
                                        <th class="px-6 py-4 text-right">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-stone-100">
                                    @forelse($landingContents as $item)
                                        <tr class="hover:bg-stone-50/50">
                                            <td class="px-6 py-4 font-semibold text-stone-900 uppercase tracking-wide text-xs">{{ $item->section }}</td>
                                            <td class="px-6 py-4 text-stone-800 font-mono text-xs">{{ $item->key }}</td>
                                            <td class="px-6 py-4 uppercase text-[10px] font-bold text-stone-500">{{ $item->type }}</td>
                                            <td class="px-6 py-4 text-stone-600 max-w-[200px] truncate">{{ $item->value }}</td>
                                            <td class="px-6 py-4 text-center text-stone-550 font-semibold">{{ $item->sort_order }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $item->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-200 text-stone-600' }}">
                                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="inline-flex items-center gap-2">
                                                    <button @click="editingContent = {{ json_encode($item) }}; isAdding = false; window.scrollTo({top: 0, behavior: 'smooth'})" class="inline-flex items-center justify-center rounded-lg bg-stone-100 px-3 py-1.5 text-xs font-semibold text-stone-700 hover:bg-stone-200 transition">
                                                        Ubah
                                                    </button>
                                                    <form action="{{ route('admin.landing-content.destroy', $item) }}" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus konten ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-rose-50 text-rose-650 hover:bg-rose-100 border border-rose-100 px-3 py-1.5 text-xs font-semibold transition">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-8 text-center text-stone-500">Tidak ada konten landing page yang dikonfigurasi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            @elseif(auth()->user()->role === 'client')
                <!-- CLIENT DASHBOARD -->
                <section class="relative overflow-hidden rounded-[2rem] border border-slate-100/70 bg-white/80 p-8 shadow-[0_18px_70px_rgba(15,23,42,0.12)] backdrop-blur-md">
                    <div class="grid gap-8 lg:grid-cols-[1.45fr_0.85fr] lg:items-end">
                        <div class="space-y-6">
                            <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Dasbor Klien</p>
                            <h1 class="max-w-3xl text-5xl font-extrabold tracking-tight text-slate-950 sm:text-6xl">Selamat datang, {{ $user?->name ?? 'Klien' }}</h1>
                            <p class="max-w-2xl text-base leading-8 text-slate-600">Publikasikan lowongan proyek baru, pantau progres arsitek Anda, dan kelola penawaran yang masuk.</p>
                            <div class="flex flex-wrap items-center gap-3">
                                <a href="{{ route('proyek.create') }}"
                                class="inline-flex items-center justify-center rounded-full bg-amber-700 px-7 py-3 text-sm font-semibold text-white shadow-lg shadow-stone-900/10 transition hover:bg-amber-800">
                                    Buat Proyek Baru
                                </a>
                                <a href="{{ route('proyek.my') }}" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-7 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-50">Proyek Saya</a>
                            </div>
                        </div>

                        <div class="rounded-[2rem] border border-slate-100/70 bg-white/80 p-6 shadow-[0_14px_45px_rgba(15,23,42,0.10)] backdrop-blur-md">
                            <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Profil Klien</p>
                            <div class="mt-6 space-y-4">
                                <div class="rounded-[1.75rem] border border-slate-100/70 bg-white/90 p-5 shadow-md">
                                    <p class="text-sm text-slate-500">Nama</p>
                                    <p class="mt-2 text-xl font-bold text-slate-950">{{ $user?->name ?? 'Klien Platform' }}</p>
                                </div>
                                <div class="rounded-[1.75rem] border border-slate-100/70 bg-white/90 p-5 shadow-md">
                                    <p class="text-sm text-slate-500">Total Anggaran Dialokasikan</p>
                                    <p class="mt-2 text-xl font-bold text-emerald-700">Rp {{ number_format($totalAnggaran ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <article class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_12px_40px_rgba(15,23,42,0.08)] backdrop-blur-md">
                        <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Total Proyek</p>
                        <h2 class="mt-4 text-4xl font-extrabold text-slate-950">{{ $totalProyek ?? 0 }}</h2>
                        <p class="mt-3 text-sm leading-6 text-slate-600">Seluruh lowongan proyek yang telah Anda daftarkan.</p>
                    </article>
                    <article class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_12px_40px_rgba(15,23,42,0.08)] backdrop-blur-md">
                        <p class="text-base font-bold uppercase tracking-[0.14em] text-amber-600">Proyek Berjalan</p>
                        <h2 class="mt-4 text-4xl font-extrabold text-slate-950">{{ $proyekAktif ?? 0 }}</h2>
                        <p class="mt-3 text-sm leading-6 text-slate-600">Proyek yang sedang dikerjakan oleh arsitek pilihan Anda.</p>
                    </article>
                    <article class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_12px_40px_rgba(15,23,42,0.08)] backdrop-blur-md">
                        <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950">Proposal Masuk</p>
                        <h2 class="mt-4 text-4xl font-extrabold text-slate-950">{{ $proposalMasuk ?? 0 }}</h2>
                        <p class="mt-3 text-sm leading-6 text-slate-600">Proposal penawaran baru yang masuk dari arsitek dan butuh respons Anda.</p>
                    </article>
                </section>

                <section class="grid gap-6 lg:grid-cols-[1.45fr_1fr]">
                    <div class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_8px_30px_rgba(15,23,42,0.04)] backdrop-blur-md">
                        <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950 mb-6">Pekerjaan Proyek Aktif</p>
                        <div class="space-y-6">
                            @forelse($projectsInProgress ?? [] as $proyek)
                                <div class="rounded-[1.75rem] border border-slate-100/70 bg-white p-6 shadow-md">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                        <div>
                                            <h3 class="text-xl font-bold text-slate-950">{{ $proyek->judul }}</h3>
                                            <p class="text-sm text-slate-500 mt-1">
                                                Arsitek Terpilih: <span class="font-semibold text-slate-700">{{ $proyek->arsitekTerpilih?->name ?? 'Belum ditentukan' }}</span>
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="rounded-full bg-emerald-50 border border-emerald-200 px-3 py-1.5 text-xs font-semibold text-emerald-700 tracking-wide">
                                                Sedang Berjalan
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-6">
                                        <div class="flex items-center justify-between text-sm text-slate-500 mb-2">
                                            <span>Kemajuan Proyek</span>
                                            <span class="font-semibold text-slate-950">{{ $proyek->progress_percent ?? 0 }}%</span>
                                        </div>
                                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                            <div class="bg-emerald-600 h-2.5 rounded-full" style="width: {{ $proyek->progress_percent ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                                        <a href="{{ route('proyek.show', $proyek) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 underline underline-offset-4">Buka Ruang Kerja</a>
                                        <span class="text-xs text-slate-400">Tenggat: {{ $proyek->deadline ? \Carbon\Carbon::parse($proyek->deadline)->format('d M Y') : '-' }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-[1.75rem] border border-slate-100/70 bg-white p-8 text-center text-slate-500 shadow-md">
                                    Tidak ada proyek yang sedang berjalan saat ini.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-slate-100/70 bg-white/90 p-6 shadow-[0_8px_30px_rgba(15,23,42,0.04)] backdrop-blur-md">
                        <p class="text-base font-bold uppercase tracking-[0.14em] text-slate-950 mb-6">Aktivitas Pekerjaan Terbaru</p>
                        <div class="space-y-4">
                            @forelse($recentTasks ?? [] as $task)
                                <div class="rounded-[1.75rem] border border-slate-100/70 bg-white p-4 shadow-sm">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="space-y-1">
                                            <p class="text-sm font-semibold text-slate-950">{{ $task->title }}</p>
                                            <p class="text-xs text-slate-500">Bobot: {{ $task->weight }}%</p>
                                        </div>
                                        <span class="rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider
                                            {{ $task->is_done ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                            {{ $task->is_done ? 'Selesai' : 'Belum' }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-[1.75rem] border border-slate-100/70 bg-white p-8 text-center text-slate-500 shadow-md">
                                    Belum ada aktivitas tugas terbaru.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </section>

            @elseif(auth()->user()->role === 'arsitek')
                <!-- ARSITEK REDIRECT/GRACEFUL NOTICE -->
                <section class="relative overflow-hidden rounded-[2rem] border border-slate-100/70 bg-white/80 p-8 shadow-[0_18px_70px_rgba(15,23,42,0.12)] text-center">
                    <p class="text-sm font-bold uppercase tracking-[0.14em] text-amber-700">Studio Kerja Arsitek</p>
                    <h2 class="mt-4 text-3xl font-extrabold text-slate-950">Memuat Ruang Kerja Anda...</h2>
                    <p class="mt-2 text-slate-600">Anda sedang dialihkan ke Workspace Proyek Arsitek Anda.</p>
                    <div class="mt-6">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-full bg-amber-700 px-6 py-3 text-sm font-semibold text-white shadow-md">Buka Workspace</a>
                    </div>
                </section>
            @endif

        </div>
    </main>
</x-app-layout>