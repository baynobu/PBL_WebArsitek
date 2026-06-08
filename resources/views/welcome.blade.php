<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Architects Studio</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=alatsi:400&family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .architect-title {
            font-family: 'Alatsi', sans-serif;
            letter-spacing: 0.15em;
        }

        .soft-shadow {
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            font-family: 'Alatsi', sans-serif;
            letter-spacing: 0.08em;
        }

        .snap-track {
            scroll-snap-type: x mandatory;
        }

        .snap-card {
            scroll-snap-align: start;
        }

        .hide-scrollbar {
            scrollbar-width: none;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body class="bg-white text-[#000000] antialiased font-[Inter] overflow-x-hidden">
    @php
        $navLabel = data_get($landingContents ?? [], 'navbar.brand.value', 'ARCHTCS.');
        $navCta = data_get($landingContents ?? [], 'navbar.cta.value', 'GET IN TOUCH');

        $heroEyebrow = data_get($landingContents ?? [], 'hero.eyebrow.value', 'Architects Studio');
        $heroHeadline = data_get($landingContents ?? [], 'hero.headline.value', 'ARCHITECTS');
        $heroImage = data_get($landingContents ?? [], 'hero.image.value', 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1400&q=80');

        $featureStrip = [
            ['label' => 'Architects Studio', 'href' => '#featured-projects'],
            ['label' => 'Your Next Architecture Journey Starts Here', 'href' => '#hero-content'],
            ['label' => 'Featured Works', 'href' => '#featured-projects'],
            ['label' => 'About', 'href' => '#about'],
        ];

        $contentIntroTitle = data_get($landingContents ?? [], 'intro.title.value', 'WHERE THE ARCHITECTS GET DISCOVERED');
        $contentIntroEyebrow = data_get($landingContents ?? [], 'intro.eyebrow.value', 'OFFICIAL WEBSITE OF ARCHITECTS STUDIO');
        $contentIntroText = data_get($landingContents ?? [], 'intro.text.value', 'Connect with top architecture firms, creative studios, and construction companies through one modern platform built for architects and design professionals. Whether you are a fresh graduate, freelance designer, or experienced architect, our platform helps you discover opportunities that match your creativity, skills, and ambitions. We make recruitment faster, smarter, and more connected for the architecture industry.');
        $contentIntroImage = data_get($landingContents ?? [], 'intro.image.value', 'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=1400&q=80');

        $contentProfileTitle = data_get($landingContents ?? [], 'profile.title.value', 'DISCOVER OUR COMPANY PROFILE');
        $contentProfileEyebrow = data_get($landingContents ?? [], 'profile.eyebrow.value', 'OFFICIAL WEBSITE OF ARCHITECTS STUDIO');
        $contentProfileText = data_get($landingContents ?? [], 'profile.text.value', 'Architects is a modern architectural platform dedicated to connecting visionary architects with innovative projects. We create spaces that combine aesthetics, functionality, and timeless design to shape better living experiences. Architects Studio delivers contemporary architectural solutions through thoughtful design, clean aesthetics, and innovative spatial experiences. We believe architecture should inspire people and elevate everyday life.');
        $contentProfileImage = data_get($landingContents ?? [], 'profile.image.value', 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1400&q=80');

        $featureRole = data_get($landingContents ?? [], 'feature.account_role.value', 'Daftar sebagai Arsitek, Client, atau Admin. Verifikasi akun untuk keamanan maksimal.');
        $featureMarketplace = data_get($landingContents ?? [], 'feature.marketplace.value', 'Client posting lowongan dengan judul, deskripsi, budget, deadline, dan lokasi yang jelas.');
        $featureProposal = data_get($landingContents ?? [], 'feature.proposal_system.value', 'Arsitek submit proposal dengan harga, durasi, dan penawaran unik mereka untuk setiap proyek.');

        $featureCards = [
            ['icon' => '✦', 'title' => 'Manajemen Akun & Role', 'text' => $featureRole ?? 'Daftar sebagai Arsitek, Client, atau Admin. Verifikasi akun untuk keamanan maksimal.'],
            ['icon' => '◫', 'title' => 'Marketplace Lowongan Proyek', 'text' => $featureMarketplace ?? 'Client posting lowongan dengan judul, deskripsi, budget, deadline, dan lokasi yang jelas.'],
            ['icon' => '✉', 'title' => 'Sistem Proposal', 'text' => $featureProposal ?? 'Arsitek submit proposal dengan harga, durasi, dan penawaran unik mereka untuk setiap proyek.'],
            ['icon' => '◌', 'title' => 'Profil & Portofolio Digital', 'text' => 'Arsitek showcase diri dengan foto, skill, pengalaman, dan gallery proyek-proyek terbaik mereka.'],
            ['icon' => '◈', 'title' => 'Tracking Status Proyek', 'text' => 'Monitor progress proyek dari Open ke On Progress ke Completed dengan transparansi penuh.'],
        ];

        $projects = [
            ['image' => 'https://images.unsplash.com/photo-1511818966892-d7d671e672a2?auto=format&fit=crop&w=1000&q=80', 'title' => 'Contemporary Residence'],
            ['image' => 'https://images.unsplash.com/photo-1486325212027-8081e485255e?auto=format&fit=crop&w=1000&q=80', 'title' => 'Minimal Office Space'],
            ['image' => 'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=1000&q=80', 'title' => 'Urban Lobby Concept'],
            ['image' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1000&q=80', 'title' => 'Warm Interior Study'],
            ['image' => 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=1000&q=80', 'title' => 'Architects Studio'],
        ];
    @endphp

    <div class="min-h-screen bg-white">
        <a href="#top" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[60] focus:rounded-full focus:bg-black focus:px-4 focus:py-2 focus:text-white">
            Skip to content
        </a>

        @include('partials.header')

        <!-- Main Content -->
        <main id="top" class="w-full">
            <section class="px-5 py-12 sm:px-8 lg:px-12 xl:px-16 2xl:px-20">
                <div class="mx-auto grid max-w-[1600px] gap-10 xl:grid-cols-[0.92fr_1.08fr] xl:items-center xl:gap-14">
                    <div class="min-w-0 space-y-6 xl:pt-12">
                        <p class="text-sm font-semibold tracking-[0.35em] text-[#3B3B3B] sm:text-base">{{ $heroEyebrow }}</p>
                        <h1 class="architect-title max-w-[9ch] text-[clamp(3rem,7vw,7.5rem)] leading-[0.92] text-black lg:max-w-[9ch]">
                            {{ $heroHeadline }}
                        </h1>
                    </div>

                    {{-- <div class="min-w-0 xl:pt-4">
                        <div class="ml-auto w-full max-w-[820px] overflow-hidden rounded-[28px] bg-gray-100 soft-shadow aspect-[4/3] sm:aspect-[16/10] xl:aspect-[5/4]">
                            <img src="{{ $heroImage }}" alt="Architects hero image" class="block h-full w-full object-cover object-center">
                        </div>
                    </div>
                </div> --}}
            </section>

            <section class="px-4 pb-16 sm:px-6 lg:px-12 lg:pb-24">
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    @foreach ($featureStrip as $index => $item)
                        <a href="{{ $item['href'] }}" class="rounded-[24px] border border-black/10 bg-white px-5 py-4 text-center text-sm font-medium text-[#3B3B3B] soft-shadow transition hover:-translate-y-1 hover:border-black/20 hover:text-black sm:px-6 sm:py-5 sm:text-base">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </section>

            <section class="px-4 pb-16 sm:px-6 lg:px-12 lg:pb-24" id="about">
                <div class="grid gap-8 lg:grid-cols-[1.15fr_0.95fr] lg:items-center">
                    <div class="order-2 space-y-6 lg:order-1">
                        <h2 class="section-title max-w-4xl text-[clamp(2.4rem,5vw,5.625rem)] leading-[1.02] text-black">
                            {{ $contentIntroTitle }}
                        </h2>
                        <p class="max-w-3xl text-base leading-8 text-[#3B3B3B] sm:text-lg lg:text-[1.625rem] lg:leading-[1.45]">
                            {{ $contentIntroText }}
                        </p>
                    </div>

                    <div class="order-1 overflow-hidden rounded-[28px] soft-shadow lg:order-2">
                        <img src="{{ $contentIntroImage }}" alt="Architecture studio image" class="h-[320px] w-full object-cover sm:h-[460px] lg:h-[720px]">
                    </div>
                </div>

                <div class="mt-6 text-center lg:mt-8 lg:text-left">
                    <p class="text-sm font-semibold tracking-[0.25em] text-[#3B3B3B] sm:text-base lg:text-[1.875rem]">
                        {{ $contentIntroEyebrow }}
                    </p>
                </div>
            </section>

            <section class="px-4 pb-16 sm:px-6 lg:px-12 lg:pb-24">
                <div class="grid gap-8 lg:grid-cols-[0.95fr_1.15fr] lg:items-center">
                    <div class="overflow-hidden rounded-[28px] soft-shadow">
                        <img src="{{ $contentProfileImage }}" alt="Company profile image" class="h-[320px] w-full object-cover sm:h-[460px] lg:h-[720px]">
                    </div>

                    <div class="space-y-6">
                        <div class="text-right">
                            <h2 class="section-title text-[clamp(2.4rem,5vw,5.625rem)] leading-[1.02] text-black">
                                {{ $contentProfileTitle }}
                            </h2>
                        </div>
                        <p class="text-base leading-8 text-[#3B3B3B] sm:text-lg lg:text-[1.625rem] lg:leading-[1.45]">
                            {{ $contentProfileText }}
                        </p>
                        <p class="text-sm font-semibold tracking-[0.25em] text-[#3B3B3B] sm:text-base lg:text-[1.875rem]">
                            {{ $contentProfileEyebrow }}
                        </p>
                    </div>
                </div>
            </section>

            <section class="px-4 pb-16 sm:px-6 lg:px-12 lg:pb-24">
                <div class="mb-8 flex items-end justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold tracking-[0.35em] text-[#3B3B3B] sm:text-base">FEATURES</p>
                        <h2 class="section-title mt-3 text-[clamp(2.2rem,4vw,4.875rem)] leading-[1.02] text-black">OUR FEATURES</h2>
                    </div>
                </div>

                <div class="hide-scrollbar snap-track -mx-4 flex gap-4 overflow-x-auto px-4 pb-3 sm:-mx-6 sm:px-6 lg:grid lg:grid-cols-3 lg:gap-6 lg:overflow-visible lg:px-0">
                    @foreach ($featureCards as $card)
                        <article class="snap-card min-w-[280px] flex-1 rounded-[28px] border border-black/10 bg-[#D9D9D9] p-6 soft-shadow transition-transform duration-300 hover:-translate-y-1 sm:min-w-[340px] sm:p-8 lg:min-w-0">
                            <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-full bg-white text-2xl text-[#3B3B3B] shadow-sm">{{ $card['icon'] }}</div>
                            <h3 class="text-2xl font-semibold text-black sm:text-[2rem]">{{ $card['title'] }}</h3>
                            <p class="mt-4 text-sm leading-7 text-[#3B3B3B] sm:text-base lg:text-lg">
                                {{ $card['text'] }}
                            </p>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="px-4 pb-16 sm:px-6 lg:px-12 lg:pb-24" id="featured-projects">
                <div class="mb-8 text-center">
                    <p class="text-sm font-semibold tracking-[0.35em] text-[#3B3B3B] sm:text-base">PROJECTS</p>
                    <h2 class="section-title mt-3 text-[clamp(2.2rem,4vw,4.875rem)] leading-[1.02] text-black">FEATURED PROJECTS</h2>
                </div>

                <div class="hide-scrollbar snap-track -mx-4 flex gap-4 overflow-x-auto px-4 pb-3 sm:-mx-6 sm:px-6 lg:-mx-12 lg:px-12">
                    @foreach ($projects as $project)
                        <article class="snap-card min-w-[78vw] overflow-hidden rounded-[28px] bg-white soft-shadow transition-transform duration-300 hover:-translate-y-1 sm:min-w-[420px] lg:min-w-[540px]">
                            <img src="{{ $project['image'] }}" alt="{{ $project['title'] }}" class="h-[240px] w-full object-cover sm:h-[320px] lg:h-[380px]">
                            <div class="flex items-center justify-between px-5 py-4 sm:px-6 sm:py-5">
                                <h3 class="text-lg font-semibold text-black sm:text-xl">{{ $project['title'] }}</h3>
                                <span class="text-xs font-semibold uppercase tracking-[0.3em] text-[#3B3B3B]">View</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="px-4 pb-20 sm:px-6 lg:px-12 lg:pb-28">
                <div class="rounded-[36px] bg-[#002643] px-6 py-10 text-white sm:px-10 sm:py-14 lg:rounded-[64px] lg:px-14 lg:py-16">
                    <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                        <div>
                            <p class="text-sm font-semibold tracking-[0.35em] text-white/70">GET STARTED</p>
                            <h2 class="section-title mt-4 text-[clamp(2.2rem,4vw,4.875rem)] leading-[1.02] text-white">Ready to explore more?</h2>
                            <p class="mt-5 max-w-2xl text-base leading-8 text-white/80 sm:text-lg lg:text-xl">
                                Bergabung untuk melihat proyek, mencari kesempatan kerja arsitektur, dan mengelola profil profesional Anda dengan lebih rapi.
                            </p>
                        </div>

                        <div class="flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:justify-start lg:justify-end">
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3 text-sm font-semibold tracking-[0.2em] text-[#002643] transition hover:bg-white/90">
                                    DASHBOARD
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3 text-sm font-semibold tracking-[0.2em] text-[#002643] transition hover:bg-white/90">
                                    REGISTER
                                </a>
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full border border-white px-6 py-3 text-sm font-semibold tracking-[0.2em] text-white transition hover:bg-white/10">
                                    LOGIN
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </section>

            
            @include('partials.footer')

        </main>
    </div>
</body>
</html>