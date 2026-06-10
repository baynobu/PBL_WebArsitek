<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Register</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-[#000000] antialiased font-sans">
<main class="min-h-screen overflow-hidden bg-white">
    <div class="mx-auto flex min-h-screen w-full flex-col lg:flex-row">

        <!-- Left Side -->
        <section class="relative flex min-h-[38vh] w-full items-start justify-start overflow-hidden bg-[#042640] lg:min-h-screen lg:w-[50.05%]">

            <div
                class="absolute inset-0 bg-cover bg-center"
                style="background-image: linear-gradient(180deg, rgba(4, 38, 64, 0.22), rgba(4, 38, 64, 0.5)), url('https://images.unsplash.com/photo-1502672023488-70e25813eb80?auto=format&fit=crop&w=1100&q=80');"
            ></div>

            <div class="absolute inset-0 bg-gradient-to-b from-black/10 via-transparent to-black/35"></div>

            <div class="relative z-10 flex h-full w-full flex-1 flex-col justify-between p-6 sm:p-10 lg:p-12 xl:p-16">

                <div class="max-w-sm pt-2 sm:pt-4 lg:pt-0">
                    <p class="text-[clamp(3rem,7vw,5.625rem)] font-medium leading-none tracking-tight text-white">
                        Mari
                    </p>
                    <p class="text-[clamp(3.25rem,7.5vw,6.25rem)] font-medium leading-none tracking-tight text-white">
                        Bergabung.
                    </p>
                </div>

                <div class="hidden max-w-md lg:block">
                    <p class="text-sm font-medium uppercase tracking-[0.4em] text-white/70">
                        Architects Studio
                    </p>

                    <p class="mt-3 max-w-sm text-lg leading-relaxed text-white/85">
                        Daftarkan akun Anda untuk menemukan arsitek profesional,
                        mengelola proyek, dan membangun portofolio dalam satu platform.
                    </p>
                </div>

            </div>
        </section>

        <!-- Right Side -->
        <section class="flex w-full items-center justify-center px-4 py-8 sm:px-6 sm:py-10 lg:w-[49.95%] lg:px-8 lg:py-0">

            <div class="w-full max-w-[28rem]">

                <div class="rounded-[28px] border border-[#C6C6C6] bg-[#D9D9D9] p-6 shadow-[0_20px_50px_rgba(0,0,0,0.08)] sm:p-8 lg:rounded-[36px]">

                    <div class="mx-auto w-full">

                        <!-- Heading -->
                        <div class="mb-6 text-center">
                            <h1 class="text-3xl font-semibold leading-tight text-black sm:text-4xl">
                                Daftar
                            </h1>
                        </div>

                        <form method="POST" action="{{ route('register') }}" class="space-y-4">
                            @csrf

                            <!-- Name -->
                            <div class="space-y-1">
                                <label for="name"
                                    class="block text-sm font-medium text-[#4A4A4A]">
                                    Nama Lengkap
                                </label>

                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    autofocus
                                    autocomplete="name"
                                    placeholder="Nama Lengkap Anda"
                                    class="block w-full rounded-xl border border-gray-300 bg-white/70 px-4 py-2.5 text-sm text-black placeholder:text-gray-400 focus:border-[#002643] focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#002643] transition-all"
                                >

                                <x-input-error :messages="$errors->get('name')" class="pt-1 text-xs" />
                            </div>

                            <!-- Email -->
                            <div class="space-y-1">
                                <label for="email"
                                    class="block text-sm font-medium text-[#4A4A4A]">
                                    Pos-el
                                </label>

                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="username"
                                    placeholder="example@email.com"
                                    class="block w-full rounded-xl border border-gray-300 bg-white/70 px-4 py-2.5 text-sm text-black placeholder:text-gray-400 focus:border-[#002643] focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#002643] transition-all"
                                >

                                <x-input-error :messages="$errors->get('email')" class="pt-1 text-xs" />
                            </div>

                            <!-- Role -->
                            <div class="space-y-1">
                                <label for="role"
                                    class="block text-sm font-medium text-[#4A4A4A]">
                                    Daftar Sebagai
                                </label>

                                <select
                                    id="role"
                                    name="role"
                                    class="block w-full rounded-xl border border-gray-300 bg-white/70 px-4 py-2.5 text-sm text-black focus:border-[#002643] focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#002643] transition-all"
                                >
                                    <option value="client"
                                        {{ old('role') == 'client' ? 'selected' : '' }}>
                                        Klien
                                    </option>

                                    <option value="arsitek"
                                        {{ old('role') == 'arsitek' ? 'selected' : '' }}>
                                        Arsitek
                                    </option>
                                </select>

                                <x-input-error :messages="$errors->get('role')" class="pt-1 text-xs" />
                            </div>

                            <!-- Password -->
                            <div class="space-y-1">
                                <label for="password"
                                    class="block text-sm font-medium text-[#4A4A4A]">
                                    Kata Sandi
                                </label>

                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    placeholder="*******"
                                    class="block w-full rounded-xl border border-gray-300 bg-white/70 px-4 py-2.5 text-sm text-black placeholder:text-gray-400 focus:border-[#002643] focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#002643] transition-all"
                                >

                                <x-input-error :messages="$errors->get('password')" class="pt-1 text-xs" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="space-y-1">
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-[#4A4A4A]">
                                    Konfirmasi Kata Sandi
                                </label>

                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    placeholder="*******"
                                    class="block w-full rounded-xl border border-gray-300 bg-white/70 px-4 py-2.5 text-sm text-black placeholder:text-gray-400 focus:border-[#002643] focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#002643] transition-all"
                                >

                                <x-input-error :messages="$errors->get('password_confirmation')" class="pt-1 text-xs" />
                            </div>

                            <!-- Button -->
                            <div class="pt-3">
                                <button
                                    type="submit"
                                    class="flex h-[48px] w-full items-center justify-center rounded-xl bg-[#002643] px-6 text-base font-semibold text-white transition duration-150 hover:bg-[#00182b] focus:outline-none focus:ring-2 focus:ring-[#002643] focus:ring-offset-2 focus:ring-offset-[#D9D9D9]"
                                >
                                    Daftar
                                </button>
                            </div>

                            <!-- Login Link -->
                            <div class="pt-2 text-center">
                                <a href="{{ route('login') }}"
                                   class="text-sm font-normal text-black">
                                    Sudah memiliki akun?
                                    <span class="font-semibold underline decoration-black/40 underline-offset-4">
                                        Masuk
                                    </span>
                                </a>
                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </section>

    </div>
</main>
</body>
</html>