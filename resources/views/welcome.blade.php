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

        .section-title{
            font-family:'Inter',sans-serif;
            font-weight:200;
            letter-spacing:-0.03em;
            line-height:0.95;
        }

        .eyebrow-text {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            letter-spacing: 0.25em;
        }

       .body-text {
        font-family: 'Inter', sans-serif;
        color: #3B3B3B;
        line-height: 1.8;
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
        $navCta = data_get($landingContents ?? [], 'navbar.cta.value', 'TEMUKAN PROYEKMU');

        $heroEyebrow = data_get($landingContents ?? [], 'hero.eyebrow.value', '');
        $heroHeadline = data_get($landingContents ?? [], 'hero.headline.value', 'ARCHITECTS');
        $heroImage = data_get($landingContents ?? [], 'hero.image.value', 'https://images.unsplash.com/photo-1571989139085-cfedbbe6c282?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');

        $featureStrip = [
            ['label' => 'Tentang', 'href' => '#about'],
            ['label' => 'Fitur Utama', 'href' => '#features'],
            ['label' => 'Proyek Unggulan', 'href' => '#featured-projects'],
        ];

        $contentIntroTitle = data_get($landingContents ?? [], 'intro.title.value', 'TEMPAT DI MANA ARSITEK DITEMUKAN');
        $contentIntroEyebrow = data_get($landingContents ?? [], 'intro.eyebrow.value', 'WEBSITE RESMI DARI ARCHITECTS STUDIO');
        $contentIntroText = data_get($landingContents ?? [], 'intro.text.value', 'Terhubunglah dengan berbagai perusahaan arsitektur terkemuka, studio kreatif, dan perusahaan konstruksi melalui satu platform modern yang dirancang khusus untuk para arsitek dan profesional desain. Kami menyediakan ruang yang mempertemukan talenta terbaik dengan berbagai peluang kerja dan proyek yang sesuai dengan keahlian serta minat mereka. Baik Anda seorang lulusan baru yang sedang memulai perjalanan karier, desainer lepas yang ingin memperluas jaringan profesional, maupun arsitek berpengalaman yang mencari tantangan baru, platform kami siap membantu Anda menemukan kesempatan yang tepat. Dengan sistem yang terintegrasi dan mudah digunakan, kami menghadirkan proses rekrutmen yang lebih efektif, efisien, dan transparan, sehingga dapat memperkuat kolaborasi antara perusahaan dan para profesional di bidang arsitektur. Melalui platform ini, kami berkomitmen untuk mendukung pertumbuhan karier individu sekaligus mendorong kemajuan industri arsitektur yang lebih inovatif dan berkelanjutan.');
        $contentIntroImage = data_get($landingContents ?? [], 'intro.image.value', 'https://images.unsplash.com/photo-1636622017988-94c471d9d955?q=80&w=686&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');

        $contentProfileTitle = data_get($landingContents ?? [], 'profile.title.value', 'MENGENAL PROFIL PERUSAHAAN KAMI');
        $contentProfileEyebrow = data_get($landingContents ?? [], 'profile.eyebrow.value', '');
        $contentProfileText = data_get($landingContents ?? [], 'profile.text.value', 'Architects merupakan platform arsitektur modern yang berfokus pada penghubungan arsitek visioner dengan berbagai proyek inovatif. Kami menghadirkan ruang yang menggabungkan nilai estetika, fungsi, dan desain yang berkelanjutan untuk menciptakan pengalaman hidup yang lebih berkualitas. Melalui pendekatan desain yang terencana, estetika yang elegan, serta inovasi dalam pengolahan ruang, Architects Studio berkomitmen untuk memberikan solusi arsitektur kontemporer yang relevan dengan kebutuhan masa kini. Kami percaya bahwa arsitektur tidak hanya membentuk lingkungan fisik, tetapi juga mampu menginspirasi serta meningkatkan kualitas hidup masyarakat.');
        $contentProfileImage = data_get($landingContents ?? [], 'profile.image.value', 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1400&q=80');

        $featureRole = data_get($landingContents ?? [], 'feature.account_role.value', 'Daftar sebagai Arsitek, Klien, atau Admin. Verifikasi akun untuk keamanan maksimal.');
        $featureMarketplace = data_get($landingContents ?? [], 'feature.marketplace.value', 'Klien mempublikasikan lowongan dengan judul, deskripsi, anggaran, tenggat waktu, dan lokasi yang jelas.');
        $featureProposal = data_get($landingContents ?? [], 'feature.proposal_system.value', 'Arsitek mengirimkan proposal dengan harga, durasi, dan penawaran unik mereka untuk setiap proyek.');

        $featureCards = [
            ['icon' => '✦', 'title' => 'Manajemen Akun & Peran', 'text' => $featureRole ?? 'Daftar sebagai Arsitek, Klien, atau Admin. Verifikasi akun untuk keamanan maksimal.'],
            ['icon' => '◫', 'title' => 'Pasar Lowongan Proyek', 'text' => $featureMarketplace ?? 'Klien mempublikasikan lowongan dengan judul, deskripsi, anggaran, tenggat waktu, dan lokasi yang jelas.'],
            ['icon' => '✉', 'title' => 'Sistem Proposal', 'text' => $featureProposal ?? 'Arsitek mengirimkan proposal dengan harga, durasi, dan penawaran unik mereka untuk setiap proyek.'],
            ['icon' => '◌', 'title' => 'Profil & Portofolio Digital', 'text' => 'Arsitek menampilkan profil dengan foto, keahlian, pengalaman, dan galeri proyek-proyek terbaik mereka.'],
            ['icon' => '◈', 'title' => 'Pelacakan Status Proyek', 'text' => 'Pantau kemajuan proyek dari Terbuka ke Sedang Berjalan hingga Selesai dengan transparansi penuh.'],
        ];

        // $projects = [
        //     ['image' => 'https://images.unsplash.com/photo-1511818966892-d7d671e672a2?auto=format&fit=crop&w=1000&q=80', 'title' => 'Contemporary Residence'],
        //     ['image' => 'https://images.unsplash.com/photo-1486325212027-8081e485255e?auto=format&fit=crop&w=1000&q=80', 'title' => 'Minimal Office Space'],
        //     ['image' => 'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=1000&q=80', 'title' => 'Urban Lobby Concept'],
        //     ['image' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1000&q=80', 'title' => 'Warm Interior Study'],
        //     ['image' => 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=1000&q=80', 'title' => 'Architects Studio'],
        // ];

    @endphp

        <!-- Header -->
        @include('partials.header')

        <!-- Hero Section -->
        <main id="top" class="w-full">
            <section class="px-5 py-12 sm:px-8 lg:px-12 xl:px-16 2xl:px-20">
                <div class="mx-auto max-w-[1600px] space-y-8">
                    <!-- Text Section -->
                    <div class="space-y-6">
                        <p class="text-sm font-semibold tracking-[0.35em] text-[#3B3B3B] sm:text-base">{{ $heroEyebrow }}</p>
                        <h1 class="architect-title max-w-[12ch] text-[clamp(3.5rem,8vw,8rem)] leading-[0.92] text-black">
                            {{ $heroHeadline }}
                        </h1>
                    </div>

                    <!-- Hero Image Section -->
                    <div class="w-full">
                        <div class="w-full overflow-hidden bg-gray-100 soft-shadow aspect-[16/9] sm:aspect-[16/8] lg:aspect-[2/1]">
                            <img src="{{ $heroImage }}" alt="Architects hero image" class="block h-full w-full object-cover object-center">
                        </div>
                    </div>
                </div>
            </section>
            <br><br><br><br>

            <!-- Feature Strip Section -->
            {{-- <section class="px-4 py-16 sm:px-6 lg:px-12 lg:py-20 bg-gradient-to-b from-white to-gray-50">
                <div class="mx-auto max-w-[1600px]">
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($featureStrip as $index => $item)
                            <a href="{{ $item['href'] }}" class="group rounded-[24px] border border-black/8 bg-white px-6 py-6 text-center text-sm font-semibold text-[#3B3B3B] soft-shadow transition-all duration-300 hover:-translate-y-1 hover:border-black/15 hover:text-black hover:shadow-lg sm:px-7 sm:py-7 sm:text-base">
                                <span class="block leading-relaxed">{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section> --}}

            <!-- Content Sections 1 -->
            <section class="px-4 pb-16 sm:px-6 lg:px-12 lg:pb-24" id="about">
                <div class="space-y-8">
                    <!-- Title -->
                    <div>
                        <h2 class="section-title max-w-4xl text-[clamp(2.4rem,5vw,5.625rem)] leading-[1.02] text-black">
                            {{ $contentIntroTitle }}
                        </h2>
                    </div>

                    <!-- Image and Text Grid -->
                    <div class="grid gap-8 lg:grid-cols-[0.95fr_1.15fr] lg:items-start">
                        <!-- Image Left -->
                        <div class="overflow-hidden rounded-[0px] soft-shadow">
                            <img src="{{ $contentIntroImage }}" alt="Architecture studio image" class="h-[320px] w-full object-cover sm:h-[460px] lg:h-[500px]">
                        </div>

                        <!-- Text Right -->
                        <div class="w-full">
                            <p class="eyebrow-text text-sm text-[#3B3B3B] sm:text-base lg:text-lg">
                        {{ $contentIntroEyebrow }}
                        </p>

                            <p class="body-text w-full text-justify text-base leading-[1.9] text-[#3B3B3B] sm:text-lg lg:text-[1.125rem]">
                            {{ $contentIntroText }}
                        </p>
                    </div>
                </div>
            </section>
            <br>

           <!-- Content Section 2 -->
            <section class="px-4 pb-16 sm:px-6 lg:px-12 lg:pb-24">

            <!-- Title -->
            <div class="mb-10 flex justify-end">
                <h2 class="section-title max-w-5xl text-right text-[clamp(2.4rem,5vw,5.625rem)] leading-[0.95] text-black">
            {{ $contentProfileTitle }}
        </h2>
    </div>

            <!-- Content -->
            <div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr] lg:items-stretch">

            <!-- Text Left -->
            <div class="flex flex-col justify-start">
            @if(!empty($contentProfileEyebrow))
                <p class="eyebrow-text mb-6 text-sm text-[#3B3B3B] sm:text-base lg:text-lg">
                    {{ $contentProfileEyebrow }}
                </p>
            @endif

            <p class="body-text w-full text-justify text-base leading-[1.9] text-[#3B3B3B] sm:text-lg lg:text-[1.125rem]">
                {{ $contentProfileText }}
            </p>
        </div>

            <!-- Image Right -->
            <div class="overflow-hidden soft-shadow">
            <img
                src="{{ $contentProfileImage }}"
                alt="Company profile image"
                class="h-full min-h-[400px] w-full object-cover lg:min-h-[500px]">
            </div>
        </div>
    </section>
            <br><br><br>

            <!-- Header Features -->
            <section class="px-4 pb-16 sm:px-6 lg:px-12 lg:pb-24">
                <div class="mx-auto mb-12 max-w-7xl text-center">
                    <h2 class="section-title text-[clamp(2.2rem,4vw,4.875rem)] leading-none text-black">
                        FITUR UTAMA PLATFORM KAMI
                </h2>
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
            <br><br>

        <!-- Featured Projects -->
        <section class="px-4 pb-16 sm:px-6 lg:px-12 lg:pb-24" id="featured-projects">
            <div class="mb-8 text-center">
                <p class="text-sm font-semibold tracking-[0.35em] text-[#3B3B3B] sm:text-base"></p>
                <h2 class="section-title mt-3 text-[clamp(2.2rem,4vw,4.875rem)] leading-[1.02] text-black">PROYEK UNGGULAN</h2>
            </div>
            <br>
            <div class="relative group/slider mx-auto max-w-[1600px]">
                <!-- Left Arrow -->
                <button id="slide-left" class="absolute -left-2 top-1/2 -translate-y-1/2 z-10 hidden md:flex h-12 w-12 items-center justify-center rounded-full bg-white/95 text-black shadow-lg hover:bg-black hover:text-white transition-all duration-300 border border-black/5" aria-label="Sebelumnya">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>

                <!-- Scrollable Container -->
                <div id="projects-slider" class="hide-scrollbar snap-track flex gap-6 overflow-x-auto pb-6 cursor-grab active:cursor-grabbing scroll-smooth select-none">
                    @foreach ($projects as $project)
                        @php
                            $statusTranslations = [
                                'open' => 'Terbuka',
                                'progress' => 'Sedang Berjalan',
                                'completed' => 'Selesai',
                            ];
                            $projectStatus = strtolower($project->status);
                            $translatedStatus = $statusTranslations[$projectStatus] ?? ucfirst($projectStatus);
                        @endphp
                        <a href="{{ route('proyek.show', $project) }}" 
                           class="group snap-card min-w-[78vw] md:min-w-[420px] lg:min-w-[480px] xl:min-w-[520px] overflow-hidden rounded-[28px] bg-white border border-black/5 soft-shadow transition-all duration-300 hover:-translate-y-2 pointer-events-auto"
                           draggable="false">
                            <!-- Image -->
                            <div class="relative overflow-hidden aspect-[16/10]" draggable="false">
                                <img src="https://images.unsplash.com/photo-1511818966892-d7d671e672a2?auto=format&fit=crop&w=1000&q=80"
                                     alt="{{ $project->judul }}"
                                     class="h-full w-full object-cover transition duration-500 group-hover:scale-105 select-none"
                                     draggable="false">
                                <!-- Overlay -->
                                <div class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 transition duration-300 group-hover:opacity-100">
                                    <span class="rounded-full border border-white px-6 py-3 text-lg font-semibold text-white">
                                        Lihat Detail Proyek
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-black line-clamp-1">
                                    {{ $project->judul }}
                                </h3>
                                <p class="mt-2 text-sm leading-relaxed text-[#3B3B3B] line-clamp-2">
                                    {{ Str::limit($project->deskripsi, 100) }}
                                </p>
                                <div class="mt-6 flex items-center justify-between pt-4 border-t border-black/5">
                                    <span class="text-sm font-medium text-gray-500 flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                        {{ $project->lokasi ?? 'Indonesia' }}
                                    </span>
                                    <span class="rounded-full bg-[#002643] px-4 py-1.5 text-xs font-semibold text-white tracking-wide">
                                        {{ $translatedStatus }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Right Arrow -->
                <button id="slide-right" class="absolute -right-2 top-1/2 -translate-y-1/2 z-10 hidden md:flex h-12 w-12 items-center justify-center rounded-full bg-white/95 text-black shadow-lg hover:bg-black hover:text-white transition-all duration-300 border border-black/5" aria-label="Berikutnya">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
            </div>
        </section>

            <section class="px-4 pb-20 sm:px-6 lg:px-12 lg:pb-28">
                <div class="rounded-[36px] bg-[#002643] px-6 py-10 text-white sm:px-10 sm:py-14 lg:rounded-[64px] lg:px-14 lg:py-16">
                    <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                        <div>
                            <p class="text-sm font-semibold tracking-[0.35em] text-white/70"></p>
                            <h2 class="section-title mt-4 text-[clamp(2.2rem,4vw,4.875rem)] leading-[1.02] text-white">Siap untuk mulai bangun proyek anda?</h2>
                            <p class="mt-5 max-w-2xl text-base leading-8 text-white/80 sm:text-lg lg:text-xl">
                                Bergabung untuk melihat proyek, mencari kesempatan kerja arsitektur, dan mengelola profil profesional Anda dengan lebih rapi.
                            </p>
                        </div>

                        <div class="flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:justify-start lg:justify-end">
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3 text-sm font-semibold tracking-[0.2em] text-[#002643] transition hover:bg-white/90">
                                    BERANDA
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3 text-sm font-semibold tracking-[0.2em] text-[#002643] transition hover:bg-white/90">
                                    DAFTAR
                                </a>
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full border border-white px-6 py-3 text-sm font-semibold tracking-[0.2em] text-white transition hover:bg-white/10">
                                    MASUK
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </section>

            
            @include('partials.footer')

        </main>
    </div>

    <!-- Interactive Projects Slider Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slider = document.getElementById('projects-slider');
            const leftArrow = document.getElementById('slide-left');
            const rightArrow = document.getElementById('slide-right');

            if (!slider) return;

            // Scroll with buttons
            if (leftArrow && rightArrow) {
                leftArrow.addEventListener('click', () => {
                    const cardWidth = slider.querySelector('.snap-card')?.offsetWidth || 400;
                    slider.scrollBy({ left: -(cardWidth + 24), behavior: 'smooth' });
                });

                rightArrow.addEventListener('click', () => {
                    const cardWidth = slider.querySelector('.snap-card')?.offsetWidth || 400;
                    slider.scrollBy({ left: (cardWidth + 24), behavior: 'smooth' });
                });

                // Toggle arrow visibility based on scroll position
                const toggleArrows = () => {
                    const maxScroll = slider.scrollWidth - slider.clientWidth;
                    if (slider.scrollLeft <= 5) {
                        leftArrow.classList.add('opacity-50');
                        leftArrow.style.pointerEvents = 'none';
                    } else {
                        leftArrow.classList.remove('opacity-50');
                        leftArrow.style.pointerEvents = 'auto';
                    }

                    if (slider.scrollLeft >= maxScroll - 5) {
                        rightArrow.classList.add('opacity-50');
                        rightArrow.style.pointerEvents = 'none';
                    } else {
                        rightArrow.classList.remove('opacity-50');
                        rightArrow.style.pointerEvents = 'auto';
                    }
                };

                slider.addEventListener('scroll', toggleArrows);
                window.addEventListener('resize', toggleArrows);
                // Initial check
                setTimeout(toggleArrows, 300);
            }

            // Mouse Drag to Scroll
            let isDown = false;
            let startX;
            let scrollLeft;

            slider.addEventListener('mousedown', (e) => {
                isDown = true;
                slider.classList.add('active');
                slider.style.scrollBehavior = 'auto'; // Disable smooth scroll during drag
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
            });

            slider.addEventListener('mouseleave', () => {
                isDown = false;
                slider.classList.remove('active');
                slider.style.scrollBehavior = 'smooth';
            });

            slider.addEventListener('mouseup', () => {
                isDown = false;
                slider.classList.remove('active');
                slider.style.scrollBehavior = 'smooth';
            });

            slider.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 2; // scroll speed multiplier
                slider.scrollLeft = scrollLeft - walk;
            });
        });
    </script>
</body>
</html>