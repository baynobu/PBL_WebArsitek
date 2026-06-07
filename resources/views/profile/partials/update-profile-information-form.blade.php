<section>
    <header>
        <h2 class="text-lg font-medium text-slate-950">
            Informasi Profil
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            Perbarui data akun Anda agar informasi profil selalu lengkap dan mudah dihubungi.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="Nama" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-slate-700">
                        Alamat email Anda belum terverifikasi.

                        <button form="send-verification" class="underline text-sm text-slate-600 hover:text-slate-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            Kirim ulang email verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-emerald-600">
                            Tautan verifikasi baru telah dikirim ke email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <x-input-label for="phone_number" value="Nomor Telepon" />
                <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20" :value="old('phone_number', $user->phone_number)" autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
            </div>

            <div>
                <x-input-label for="whatsapp_number" value="Nomor WhatsApp" />
                <x-text-input id="whatsapp_number" name="whatsapp_number" type="text" class="mt-1 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20" :value="old('whatsapp_number', $user->whatsapp_number)" autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('whatsapp_number')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Simpan</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-600"
                >Tersimpan.</p>
            @endif
        </div>
    </form>
</section>
