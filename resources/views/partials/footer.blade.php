<footer class="w-full bg-[#D9D9D9]" id="kontak">
    <div class="mx-auto w-full max-w-[1920px] px-6 py-16">
        <div class="grid gap-8 lg:grid-cols-4">

            <!-- Logo & Deskripsi -->
            <div>
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-[#3B3B3B]"></div>

                    <div>
                        <h3 class="architect-title text-2xl text-black sm:text-[2.5rem]">
                            ARCHTCS.
                        </h3>

                        <p class="text-xs font-medium uppercase tracking-[0.3em] text-[#3B3B3B]">
                            Architects Studio
                        </p>
                    </div>
                </div>

                <p class="mt-4 max-w-sm text-sm leading-7 text-[#3B3B3B] sm:text-base">
                    Platform arsitektur modern untuk menemukan proyek,
                    membangun portofolio, dan menghubungkan arsitek
                    dengan client secara lebih cepat dan nyaman.
                </p>
            </div>

            <!-- Navigation -->
            <div>
                <h3 class="text-xl font-semibold text-black lg:text-2xl">
                    Navigation
                </h3>

                <ul class="mt-5 space-y-3 text-sm text-[#3B3B3B] sm:text-base">
                    <li>
                        <a href="#top" class="transition hover:text-black">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="#featured-projects" class="transition hover:text-black">
                            Projects
                        </a>
                    </li>

                    <li>
                        <a href="#about" class="transition hover:text-black">
                            Architects
                        </a>
                    </li>

                    <li>
                        <a href="#about" class="transition hover:text-black">
                            About
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-xl font-semibold text-black lg:text-2xl">
                    Contact
                </h3>

                <div class="mt-5 text-sm leading-7 text-[#3B3B3B] sm:text-base">
                    <p>PBL Web Arsitek</p>
                    <p>Politeknik Negeri Malang</p>
                    <p>Email: architectsstudio@gmail.com</p>
                    <p>Phone: +62 341 000 000</p>
                </div>
            </div>

            <!-- Social -->
            <div>
                <h3 class="text-xl font-semibold text-black lg:text-2xl">
                    Social
                </h3>

                <ul class="mt-5 space-y-3 text-sm text-[#3B3B3B] sm:text-base">
                    <li>
                        <a href="#" class="transition hover:text-black">
                            Instagram
                        </a>
                    </li>

                    <li>
                        <a href="#" class="transition hover:text-black">
                            Facebook
                        </a>
                    </li>

                    <li>
                        <a href="#" class="transition hover:text-black">
                            LinkedIn
                        </a>
                    </li>
                </ul>

                <div class="mt-8">
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center justify-center rounded-full bg-[#002643] px-6 py-3 text-sm font-semibold tracking-[0.15em] text-white transition hover:bg-[#001828]">
                            DASHBOARD
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center rounded-full bg-[#002643] px-6 py-3 text-sm font-semibold tracking-[0.15em] text-white transition hover:bg-[#001828]">
                            LOGIN
                        </a>
                    @endauth
                </div>
            </div>

        </div>

        <!-- Garis Pembatas -->
        <div class="my-10 border-t border-black/10"></div>

        <!-- Copyright -->
        <div class="flex flex-col items-center justify-between gap-4 text-center text-sm text-[#3B3B3B] md:flex-row md:text-left">
            <p>
                © {{ date('Y') }} ARCHTCS. All Rights Reserved.
            </p>

            <div class="flex gap-6">
                <a href="#" class="hover:text-black">
                    Privacy Policy
                </a>

                <a href="#" class="hover:text-black">
                    Terms of Service
                </a>
            </div>
        </div>

    </div>
</footer>