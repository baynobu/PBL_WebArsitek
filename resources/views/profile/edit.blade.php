<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Profile') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola informasi akun, sandi, dan hapus akun dari satu tempat.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-2xl bg-gradient-to-r from-slate-900 to-slate-700 px-6 py-5 text-white shadow-lg">
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-200">Profile Hub</p>
                        <h3 class="mt-1 text-2xl font-bold">Kontak dan identitas akun</h3>
                    </div>
                    <div class="text-sm text-slate-200">
                        Telepon: {{ $user->phone_number ?? '-' }} · WhatsApp: {{ $user->whatsapp_number ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-200 sm:p-8 dark:bg-gray-800 dark:ring-gray-700">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-200 sm:p-8 dark:bg-gray-800 dark:ring-gray-700">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-200 sm:p-8 dark:bg-gray-800 dark:ring-gray-700">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
