<nav x-data="{ open: false, profileOpen: false, searchOpen: false, notificationsOpen: false }" class="relative z-50">
    @php
        $user = auth()->user();
        $role = $user?->role;
        $verified = $user?->email_verified_at;
        $notifications = collect();
        $unreadCount = 0;

        if ($user && \Illuminate\Support\Facades\Schema::hasTable('notifications')) {
            $notifications = $user->notifications()->latest()->limit(5)->get();
            $unreadCount = $user->unreadNotifications()->count();
        }

        $menuItems = [];

        if ($role === 'client') {
            $currentProyek = request()->route('proyek');
            $isCurrentProjectOwner = request()->routeIs('proyek.show') && optional($currentProyek)->client_id === auth()->id();

            $menuItems = [
                ['label' => 'Beranda', 'href' => route('dashboard'), 'active' => request()->routeIs('dashboard')],
                ['label' => 'Daftar Proyek', 'href' => route('proyek.index'), 'active' => request()->routeIs('proyek.index') || (request()->routeIs('proyek.show') && !$isCurrentProjectOwner)],
                ['label' => 'Proyek Saya', 'href' => route('proyek.my'), 'active' => request()->routeIs('proyek.my') || $isCurrentProjectOwner],
                ['label' => 'Lihat Proposal', 'href' => route('proposal.index'), 'active' => request()->routeIs('proposal.index') || request()->routeIs('proposal.show')],
                ['label' => 'Buat Proyek', 'href' => route('proyek.create'), 'active' => request()->routeIs('proyek.create')],
            ];
        } elseif ($role === 'arsitek') {
            $menuItems = [
                ['label' => 'Beranda', 'href' => route('dashboard'), 'active' => request()->routeIs('dashboard')],
                ['label' => 'Daftar Proposal', 'href' => route('proposal.index'), 'active' => request()->routeIs('proposal.index') || request()->routeIs('proposal.show') || request()->routeIs('proposal.create')],
                ['label' => 'Proyek Saya', 'href' => route('arsitek.proyek'), 'active' => request()->routeIs('arsitek.proyek')],
                ['label' => 'Portofolio Saya', 'href' => route('portofolio.index'), 'active' => request()->routeIs('portofolio.index') || request()->routeIs('portofolio.create') || request()->routeIs('portofolio.edit')],
                ['label' => 'Edit Profil', 'href' => route('arsitek.profile.edit'), 'active' => request()->routeIs('arsitek.profile.edit')],
            ];
        } elseif ($role === 'admin') {
            $menuItems = [
                ['label' => 'Beranda', 'href' => route('dashboard'), 'active' => request()->routeIs('dashboard')],
            ];
        }
    @endphp

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-[72px] items-center justify-between rounded-full bg-stone-800 px-5 shadow-[0_22px_55px_-30px_rgba(15,23,42,0.12)] ring-1 ring-slate-200/70 transition duration-300">
            <div class="flex items-center gap-5">
                <a href="{{ route('dashboard') }}" class="text-white font-semibold uppercase tracking-[0.28em] text-sm">ARCHITECTS</a>
            </div>

            <div class="hidden xl:flex items-center gap-2">
                <div class="inline-flex items-center gap-2 rounded-full bg-white px-2 py-1 shadow-sm ring-1 ring-white">
                    @foreach ($menuItems as $item)
                        <a href="{{ $item['href'] }}" class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-medium transition duration-200 ease-out {{ $item['active'] ? 'bg-white text-slate-950 shadow-lg shadow-slate-950/10' : 'bg-white text-slate-950 hover:bg-amber-700 hover:text-white' }}">
                            @if ($item['label'] === 'Beranda')
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9.75L12 3l9 6.75M4.5 10.5v9.75a.75.75 0 00.75.75h3.75a.75.75 0 00.75-.75v-4.5h3v4.5a.75.75 0 00.75.75h3.75a.75.75 0 00.75-.75V10.5" />
                                </svg>
                            @elseif ($item['label'] === 'Daftar Proyek')
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7.5A2.25 2.25 0 015.25 5.25h3.75l1.5 1.5h8.25A2.25 2.25 0 0121 9v9.75A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75V7.5z" />
                                </svg>
                            @elseif ($item['label'] === 'Proyek Saya')
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 9V7.5A2.25 2.25 0 019 5.25h6A2.25 2.25 0 0117.25 7.5V9M4.5 9h15.75M4.5 9v9.75A2.25 2.25 0 006.75 21h10.5a2.25 2.25 0 002.25-2.25V9" />
                                </svg>
                            @elseif ($item['label'] === 'Lihat Proposal')
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.5 3h9A2.25 2.25 0 0118.75 5.25v13.5A2.25 2.25 0 0116.5 21h-9A2.25 2.25 0 015.25 18.75V5.25A2.25 2.25 0 017.5 3z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h6M9 13h4.5M9 17h6" />
                                </svg>
                            @else
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15M4.5 12h15" />
                                </svg>
                            @endif
                            <span>{{ __($item['label']) }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="hidden lg:flex items-center gap-3">
                <div class="relative">
                    <button type="button" @click="searchOpen = !searchOpen; notificationsOpen = false" class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white text-slate-950 shadow-sm shadow-slate-950/10 transition duration-200 hover:bg-slate-100">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                        </svg>
                    </button>
                    <div x-show="searchOpen" x-cloak @click.away="searchOpen = false" x-transition class="absolute right-0 z-50 mt-3 w-72 rounded-2xl border border-slate-200 bg-white p-4 shadow-xl">
                        <form method="GET" action="{{ route('proyek.index') }}" class="flex items-center gap-2">
                            <input name="q" type="search" value="{{ request('q') }}" placeholder="Cari proyek..." class="block w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-950 outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20" />
                            <button type="submit" class="inline-flex h-10 items-center justify-center rounded-2xl bg-amber-700 px-3 text-white">Go</button>
                        </form>
                    </div>
                </div>

                <div class="relative">
                    <button @click="profileOpen = ! profileOpen" @click.away="profileOpen = false" class="inline-flex items-center gap-3 rounded-full border border-white bg-white px-4 py-2 text-sm font-semibold text-slate-950 shadow-sm shadow-slate-950/10 transition duration-200 hover:bg-slate-100">
                        <span>{{ Auth::user()?->name ?? 'User' }}</span>
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="profileOpen" x-transition.opacity class="absolute right-0 z-50 mt-2 w-52 origin-top-right rounded-2xl border border-slate-800/60 bg-slate-950 p-2 shadow-xl ring-1 ring-slate-800/70">
                        <a href="{{ route('profile.edit') }}" class="block rounded-2xl bg-slate-800 px-4 py-2 text-sm text-white transition hover:bg-slate-700">Kelola Akun</a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-1">
                            @csrf
                            <button type="submit" class="w-full rounded-2xl bg-slate-800 px-4 py-2 text-left text-sm text-white transition hover:bg-slate-700">Keluar</button>
                        </form>
                    </div>
            </div>

            <button @click="open = !open" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/10 bg-white text-slate-950 shadow-sm shadow-slate-950/10 transition duration-200 hover:bg-slate-100 lg:hidden">
                <svg x-show="!open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div x-show="open" x-transition class="mt-3 lg:hidden">
        <div class="rounded-[32px] bg-slate-950 px-4 py-4 shadow-lg shadow-slate-950/20 ring-1 ring-slate-800/70">
            <div class="space-y-2">
                @foreach ($menuItems as $item)
                    <a href="{{ $item['href'] }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition duration-200 {{ $item['active'] ? 'bg-white text-slate-950' : 'bg-slate-950 text-white hover:bg-indigo-950 hover:text-white' }}">
                        @if ($item['label'] === 'Beranda')
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9.75L12 3l9 6.75M4.5 10.5v9.75a.75.75 0 00.75.75h3.75a.75.75 0 00.75-.75v-4.5h3v4.5a.75.75 0 00.75.75h3.75a.75.75 0 00.75-.75V10.5" />
                            </svg>
                        @elseif ($item['label'] === 'Daftar Proyek')
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7.5A2.25 2.25 0 015.25 5.25h3.75l1.5 1.5h8.25A2.25 2.25 0 0121 9v9.75A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75V7.5z" />
                            </svg>
                        @elseif ($item['label'] === 'Proyek Saya')
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 9V7.5A2.25 2.25 0 019 5.25h6A2.25 2.25 0 0117.25 7.5V9M4.5 9h15.75M4.5 9v9.75A2.25 2.25 0 006.75 21h10.5a2.25 2.25 0 002.25-2.25V9" />
                            </svg>
                        @elseif ($item['label'] === 'Lihat Proposal')
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.5 3h9A2.25 2.25 0 0118.75 5.25v13.5A2.25 2.25 0 0116.5 21h-9A2.25 2.25 0 015.25 18.75V5.25A2.25 2.25 0 017.5 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h6M9 13h4.5M9 17h6" />
                            </svg>
                        @else
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15M4.5 12h15" />
                            </svg>
                        @endif
                        <span>{{ __($item['label']) }}</span>
                    </a>
                @endforeach
            </div>

            @auth
                <div class="mt-4 border-t border-slate-800 pt-4">
                    <div class="flex items-center gap-3">
                        <div>
                            <p class="text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-400">{{ ucfirst(Auth::user()->role) }}</p>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2">
                        <a href="{{ route('profile.edit') }}" class="block rounded-2xl bg-stone-800 px-4 py-3 text-sm text-white transition hover:bg-stone-700">Kelola Akun</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full rounded-2xl bg-stone-800 px-4 py-3 text-left text-sm text-white transition hover:bg-stone-700">Keluar</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>
