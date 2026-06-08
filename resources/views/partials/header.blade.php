<!-- Header -->
<header class="sticky top-0 z-50 border-b border-black/5 bg-white/90 backdrop-blur-lg">
    <div class="mx-auto flex h-20 w-full max-w-[1600px] items-center justify-between px-5 sm:px-8 lg:px-12 xl:px-16">
        <a href="#top" class="flex shrink-0 items-center gap-3">
            <span class="h-10 w-10 rounded-full bg-[#3B3B3B]"></span>

            <span class="architect-title text-xl text-[#3B3B3B] sm:text-2xl">
                {{ $navLabel }}
            </span>
        </a>

        <nav class="hidden items-center gap-10 xl:flex">
            @foreach ($featureStrip as $item)
                <a href="{{ $item['href'] }}" class="relative text-base font-medium text-[#3B3B3B] transition duration-200 hover:text-black after:absolute after:-bottom-1 after:left-0 after:h-[2px] after:w-0 after:bg-black after:transition-all hover:after:w-full">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-3">
            <a href="#featured-projects" class="hidden lg:inline-flex items-center justify-center rounded-full border border-black/10 px-5 py-2.5 text-sm font-semibold text-[#3B3B3B] transition hover:border-black hover:bg-black hover:text-white">
                Featured
            </a>

            @auth
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-full bg-[#3B3B3B] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-black">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full bg-[#3B3B3B] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-black">
                    {{ $navCta }}
                </a>
            @endauth

            <button class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-black/10 xl:hidden" type="button" aria-label="Open menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>
</header>