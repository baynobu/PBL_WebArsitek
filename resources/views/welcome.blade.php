<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PBL Arsitek - Marketplace Lowongan Kerja Arsitek Berbasis Proyek</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            @apply transition-all duration-300;
        }

        .gradient-primary {
            @apply bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600;
        }

        .gradient-text {
            @apply bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent;
        }

        .card-hover {
            @apply hover:-translate-y-2 hover:shadow-2xl;
        }

        .btn-primary {
            @apply px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:shadow-lg hover:from-blue-700 hover:to-indigo-700;
        }

        .btn-secondary {
            @apply px-8 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-blue-600;
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .navbar-blur {
            @apply backdrop-blur-md bg-white/30;
        }

        .feature-icon {
            @apply w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white text-2xl;
        }

        .role-card {
            @apply p-10 rounded-2xl bg-gradient-to-br border-2 transition-all hover:scale-105;
        }

        .role-card.arsitek {
            @apply from-blue-50 to-indigo-50 border-blue-200 hover:border-blue-500;
        }

        .role-card.client {
            @apply from-purple-50 to-pink-50 border-purple-200 hover:border-purple-500;
        }

        .feature-box {
            @apply p-8 rounded-2xl bg-white border border-gray-200 hover:border-blue-400 card-hover;
        }
    </style>
</head>

<body class="bg-white text-gray-900 overflow-x-hidden">
    @php
        $heroBadge = data_get($landingContents ?? [], 'hero.badge.value', '🏗️ Marketplace Lowongan Kerja Arsitek Profesional');
        $heroTitlePartOne = data_get($landingContents ?? [], 'hero.title_part_1.value', 'Hubungkan Ide');
        $heroTitlePartTwo = data_get($landingContents ?? [], 'hero.title_part_2.value', 'Dengan Talenta Arsitek');
        $heroSubtitle = data_get($landingContents ?? [], 'hero.subtitle.value', 'Platform terpercaya untuk menemukan, merekrut, dan berkolaborasi dengan arsitek profesional berbasis proyek kontrak dan freelance.');
        $heroPrimaryCta = data_get($landingContents ?? [], 'hero.primary_cta.value', 'Mulai Sekarang');
        $heroSecondaryCta = data_get($landingContents ?? [], 'hero.secondary_cta.value', 'Login');
        $projectsCount = data_get($landingContents ?? [], 'stats.projects_count.value', '100+ Lowongan Proyek');
        $architectCount = data_get($landingContents ?? [], 'stats.architect_count.value', '250+ Arsitek Profesional');
        $ratingScore = data_get($landingContents ?? [], 'stats.rating_score.value', '4.8/5 Rating');
        $featureRole = data_get($landingContents ?? [], 'feature.account_role.value', 'Daftar sebagai Arsitek, Client, atau Admin. Verifikasi akun untuk keamanan maksimal.');
        $featureMarketplace = data_get($landingContents ?? [], 'feature.marketplace.value', 'Client posting lowongan dengan judul, deskripsi, budget, deadline, dan lokasi yang jelas.');
        $featureProposal = data_get($landingContents ?? [], 'feature.proposal_system.value', 'Arsitek submit proposal dengan harga, durasi, dan penawaran unik mereka untuk setiap proyek.');
    @endphp

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 navbar-blur border-b border-white/20 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-600 to-purple-600"></div>
                <h1 class="text-2xl font-bold gradient-text">PBL Arsitek</h1>
            </div>

            <div class="flex gap-4 items-center">
                @auth
                    <div class="hidden md:flex items-center gap-3 mr-2">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ auth()->user()->email_verified_at ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ auth()->user()->email_verified_at ? 'Akun Terverifikasi' : 'Menunggu Verifikasi' }}
                        </span>
                        <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                    </div>
                    <a href="/dashboard" class="btn-primary">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="/login" class="px-6 py-2 text-gray-700 font-medium hover:text-blue-600">
                        Login
                    </a>
                    <a href="/register" class="btn-primary">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center px-6 overflow-hidden">
        <!-- Background Gradient -->
        <div class="absolute inset-0 gradient-primary opacity-10 -z-10"></div>

        <!-- Decorative Elements -->
        <div
            class="absolute top-20 left-10 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse">
        </div>
        <div
            class="absolute bottom-10 right-10 w-72 h-72 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse">
        </div>

        <div class="relative max-w-4xl mx-auto text-center">
            <div class="mb-8">
                <span class="inline-block px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold mb-6">
                    {{ $heroBadge }}
                </span>
            </div>

            <h2 class="text-5xl md:text-6xl lg:text-7xl font-black mb-8 leading-tight">
                <span class="gradient-text">{{ $heroTitlePartOne }}</span>
                <br>
                <span class="text-gray-900">{{ $heroTitlePartTwo }}</span>
            </h2>

            <p class="text-xl md:text-2xl text-gray-600 mb-12 leading-relaxed max-w-2xl mx-auto">
                {{ $heroSubtitle }}
            </p>

            <div class="flex flex-col md:flex-row gap-6 justify-center items-center mt-12">
                @auth
                    <a href="/dashboard" class="btn-primary text-lg">
                        {{ $heroPrimaryCta }} →
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-secondary text-lg border-gray-300 text-gray-700 hover:text-blue-600 hover:border-blue-600">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="/register" class="btn-primary text-lg">
                        {{ $heroPrimaryCta }} →
                    </a>
                    <a href="/login" class="btn-secondary text-lg">
                        {{ $heroSecondaryCta }}
                    </a>
                @endauth
            </div>

            <!-- Social Proof -->
            <div class="flex flex-wrap justify-center gap-8 mt-16 text-sm text-gray-600">
                <div>📊 {{ $projectsCount }}</div>
                <div>👥 {{ $architectCount }}</div>
                <div>⭐ {{ $ratingScore }}</div>
            </div>
        </div>
    </section>

    <!-- For Two Roles Section -->
    <section class="py-24 px-6 bg-gradient-to-r from-gray-50 to-gray-100">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Untuk Siapa Saja Ini Cocok?</h2>
                <p class="text-xl text-gray-600">Platform yang dirancang khusus untuk dua pihak berbeda dengan kebutuhan
                    unik mereka</p>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <!-- Untuk Arsitek -->
                <div class="role-card arsitek">
                    <div class="text-5xl mb-6">🎨</div>
                    <h3 class="text-3xl font-bold mb-6 text-blue-900">Untuk Arsitek</h3>
                    <p class="text-gray-700 mb-8 text-lg font-semibold">Bangun Karir Impian Anda</p>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3">
                            <span class="text-blue-600 text-xl">✓</span>
                            <span class="text-gray-700">Buat profil dan portofolio digital profesional</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-blue-600 text-xl">✓</span>
                            <span class="text-gray-700">Temukan lowongan proyek sesuai skill Anda</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-blue-600 text-xl">✓</span>
                            <span class="text-gray-700">Kirim proposal dan tawarkan keahlian Anda</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-blue-600 text-xl">✓</span>
                            <span class="text-gray-700">Kelola status proyek dengan transparan</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-blue-600 text-xl">✓</span>
                            <span class="text-gray-700">Dapatkan rating dan review dari client</span>
                        </li>
                    </ul>

                    <div class="p-4 bg-blue-100 rounded-lg border-l-4 border-blue-600">
                        <p class="text-sm text-blue-900"><strong>Fresh Graduate?</strong> Platform ini sempurna untuk
                            membangun CV digital dan pengalaman kerja pertama Anda!</p>
                    </div>
                </div>

                <!-- Untuk Client/Pemberi Kerja -->
                <div class="role-card client">
                    <div class="text-5xl mb-6">💼</div>
                    <h3 class="text-3xl font-bold mb-6 text-purple-900">Untuk Client (Pemberi Kerja)</h3>
                    <p class="text-gray-700 mb-8 text-lg font-semibold">Temukan Arsitek Terbaik Untuk Proyek Anda</p>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3">
                            <span class="text-purple-600 text-xl">✓</span>
                            <span class="text-gray-700">Post lowongan proyek dengan detail yang jelas</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-purple-600 text-xl">✓</span>
                            <span class="text-gray-700">Browse profil dan portofolio arsitek berkualitas</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-purple-600 text-xl">✓</span>
                            <span class="text-gray-700">Terima dan bandingkan proposal dari berbagai arsitek</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-purple-600 text-xl">✓</span>
                            <span class="text-gray-700">Pilih talenta terbaik sesuai budget dan kebutuhan</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-purple-600 text-xl">✓</span>
                            <span class="text-gray-700">Track progress dan berikan rating setelah selesai</span>
                        </li>
                    </ul>

                    <div class="p-4 bg-purple-100 rounded-lg border-l-4 border-purple-600">
                        <p class="text-sm text-purple-900"><strong>Tips:</strong> Semakin detail deskripsi proyek Anda,
                            semakin banyak proposal berkualitas yang diterima!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-24 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-20">
                <h3 class="text-4xl md:text-5xl font-bold mb-6">Fitur Utama Platform</h3>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Semua yang diperlukan untuk menghubungkan arsitek dengan peluang kerja terbaik
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-box">
                    <div class="text-5xl mb-4">📝</div>
                    <h4 class="text-2xl font-bold mb-4 gradient-text">Manajemen Akun & Role</h4>
                    <p class="text-gray-600 mb-4">
                        {{ $featureRole }}
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>✓ Registrasi mudah</li>
                        <li>✓ Verifikasi admin</li>
                        <li>✓ Role-based access</li>
                    </ul>
                </div>

                <!-- Feature 2 -->
                <div class="feature-box">
                    <div class="text-5xl mb-4">🏢</div>
                    <h4 class="text-2xl font-bold mb-4 gradient-text">Marketplace Lowongan Proyek</h4>
                    <p class="text-gray-600 mb-4">
                        {{ $featureMarketplace }}
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>✓ Post lowongan mudah</li>
                        <li>✓ Filter proyek fleksibel</li>
                        <li>✓ Visibility tinggi</li>
                    </ul>
                </div>

                <!-- Feature 3 -->
                <div class="feature-box">
                    <div class="text-5xl mb-4">💌</div>
                    <h4 class="text-2xl font-bold mb-4 gradient-text">Sistem Proposal</h4>
                    <p class="text-gray-600 mb-4">
                        {{ $featureProposal }}
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>✓ Submit proposal custom</li>
                        <li>✓ Compare kandidat</li>
                        <li>✓ Pilih yang terbaik</li>
                    </ul>
                </div>

                <!-- Feature 4 -->
                <div class="feature-box">
                    <div class="text-5xl mb-4">👤</div>
                    <h4 class="text-2xl font-bold mb-4 gradient-text">Profil & Portofolio Digital</h4>
                    <p class="text-gray-600 mb-4">
                        Arsitek showcase diri dengan foto, skill, pengalaman, dan gallery proyek-proyek terbaik mereka.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>✓ Profil profesional</li>
                        <li>✓ Portfolio showcase</li>
                        <li>✓ Rating & review</li>
                    </ul>
                </div>

                <!-- Feature 5 -->
                <div class="feature-box">
                    <div class="text-5xl mb-4">📊</div>
                    <h4 class="text-2xl font-bold mb-4 gradient-text">Tracking Status Proyek</h4>
                    <p class="text-gray-600 mb-4">
                        Monitor progress proyek dari Open → On Progress → Completed dengan transparansi penuh.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>✓ Real-time status</li>
                        <li>✓ Transparent tracking</li>
                        <li>✓ Completion confirmation</li>
                    </ul>
                </div>

                <!-- Feature 6 -->
                <div class="feature-box">
                    <div class="text-5xl mb-4">⭐</div>
                    <h4 class="text-2xl font-bold mb-4 gradient-text">Rating & Review System</h4>
                    <p class="text-gray-600 mb-4">
                        Client memberikan rating kepada arsitek sebagai indikator reputasi dan kualitas kerja mereka.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>✓ 5-star rating</li>
                        <li>✓ Written reviews</li>
                        <li>✓ Reputation score</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-24 px-6 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Bagaimana Cara Kerjanya?</h2>
                <p class="text-xl text-gray-600">Alur sederhana yang menghubungkan client dan arsitek profesional</p>
            </div>

            <div class="grid md:grid-cols-4 gap-6 mb-16">
                <!-- Step 1 -->
                <div class="text-center">
                    <div
                        class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 text-white font-bold text-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        1
                    </div>
                    <h3 class="text-xl font-bold mb-3">Post Lowongan</h3>
                    <p class="text-gray-600 text-sm">
                        Client membuat lowongan proyek dengan detail lengkap: judul, deskripsi, budget, deadline,
                        lokasi.
                    </p>
                </div>

                <!-- Arrow -->
                <div class="hidden md:flex items-center justify-center">
                    <div class="text-3xl text-gray-400">→</div>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div
                        class="w-20 h-20 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 text-white font-bold text-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        2
                    </div>
                    <h3 class="text-xl font-bold mb-3">Browse & Submit</h3>
                    <p class="text-gray-600 text-sm">
                        Arsitek melihat lowongan, mempelajari detail, lalu submit proposal dengan harga dan durasi
                        mereka.
                    </p>
                </div>

                <!-- Arrow -->
                <div class="hidden md:flex items-center justify-center">
                    <div class="text-3xl text-gray-400">→</div>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div
                        class="w-20 h-20 rounded-full bg-gradient-to-br from-purple-600 to-pink-600 text-white font-bold text-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        3
                    </div>
                    <h3 class="text-xl font-bold mb-3">Review & Select</h3>
                    <p class="text-gray-600 text-sm">
                        Client review proposal, lihat portofolio arsitek, bandingkan, dan pilih yang paling sesuai.
                    </p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Step 4 -->
                <div class="bg-white p-8 rounded-2xl border-2 border-blue-200 hover:border-blue-500 card-hover">
                    <div class="flex items-start gap-6">
                        <div
                            class="w-16 h-16 rounded-full bg-gradient-to-br from-pink-600 to-red-600 text-white font-bold text-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            4
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold mb-2">Proyek Dimulai</h3>
                            <p class="text-gray-600">
                                Arsitek yang dipilih akan mengerjakan proyek. Status berubah menjadi "On Progress" dan
                                dapat dipantau secara transparan.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="bg-white p-8 rounded-2xl border-2 border-purple-200 hover:border-purple-500 card-hover">
                    <div class="flex items-start gap-6">
                        <div
                            class="w-16 h-16 rounded-full bg-gradient-to-br from-red-600 to-orange-600 text-white font-bold text-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            5
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold mb-2">Selesai & Rating</h3>
                            <p class="text-gray-600">
                                Proyek selesai, status menjadi "Completed". Client memberikan rating dan review untuk
                                membangun reputasi arsitek.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 px-6 gradient-primary text-white relative overflow-hidden">
        <!-- Decorative Element -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-32 -mt-32"></div>

        <div class="max-w-4xl mx-auto text-center relative z-10">
            <h3 class="text-4xl md:text-5xl font-bold mb-8">Siap Memulai Perjalanan Anda?</h3>
            <p class="text-xl text-blue-100 mb-12 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan arsitek dan client yang sudah menemukan kesuksesan di PBL Arsitek
            </p>

            @auth
                <a href="/dashboard"
                    class="inline-block px-8 py-4 bg-white text-blue-600 font-bold rounded-lg hover:shadow-2xl hover:scale-105">
                    Buka Dashboard Sekarang
                </a>
            @else
                <a href="/register"
                    class="inline-block px-8 py-4 bg-white text-blue-600 font-bold rounded-lg hover:shadow-2xl hover:scale-105 mr-4 mb-4">
                    Daftar Sekarang - Gratis!
                </a>
                <a href="/login"
                    class="inline-block px-8 py-4 border-2 border-white text-white font-bold rounded-lg hover:bg-white/10">
                    Login Akun Existing
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 px-6 bg-gray-950 text-gray-400 border-t border-gray-800">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-5 gap-12 mb-12">
                <div>
                    <h5 class="text-white font-bold mb-4 flex items-center gap-2">
                        <div class="w-8 h-8 rounded bg-gradient-to-br from-blue-600 to-purple-600"></div>
                        PBL Arsitek
                    </h5>
                    <p class="text-sm">Marketplace lowongan kerja arsitek berbasis proyek kontrak dan freelance untuk
                        menghubungkan talent dengan peluang terbaik.</p>
                </div>
                <div>
                    <h6 class="text-white font-bold mb-4">Untuk Arsitek</h6>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Browse Lowongan</a></li>
                        <li><a href="#" class="hover:text-white">Buat Portofolio</a></li>
                        <li><a href="#" class="hover:text-white">Submit Proposal</a></li>
                        <li><a href="#" class="hover:text-white">Lihat Rating</a></li>
                    </ul>
                </div>
                <div>
                    <h6 class="text-white font-bold mb-4">Untuk Client</h6>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Post Lowongan</a></li>
                        <li><a href="#" class="hover:text-white">Browse Arsitek</a></li>
                        <li><a href="#" class="hover:text-white">Kelola Proposal</a></li>
                        <li><a href="#" class="hover:text-white">Track Proyek</a></li>
                    </ul>
                </div>
                <div>
                    <h6 class="text-white font-bold mb-4">Resources</h6>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Dokumentasi</a></li>
                        <li><a href="#" class="hover:text-white">Blog & Tips</a></li>
                        <li><a href="#" class="hover:text-white">FAQ</a></li>
                        <li><a href="#" class="hover:text-white">Support</a></li>
                    </ul>
                </div>
                <div>
                    <h6 class="text-white font-bold mb-4">Legal</h6>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white">Contact</a></li>
                        <li><a href="#" class="hover:text-white">About Us</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>© 2026 PBL Arsitek - Marketplace Lowongan Kerja Arsitek. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

</body>

</html>