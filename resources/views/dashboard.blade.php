<x-app-layout>
    <x-slot name="header">
        @php
            $user = auth()->user();
            $role = $user?->role;
        @endphp

        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $user?->email_verified_at ? 'Akun Anda sudah terverifikasi.' : 'Akun Anda masih menunggu verifikasi admin.' }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-lg font-semibold">{{ __("You're logged in!") }}</p>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ $user?->name }} · {{ ucfirst($role ?? 'guest') }}
                        </p>
                    </div>
                    <span class="inline-flex w-fit items-center rounded-full px-3 py-1 text-xs font-semibold {{ $user?->email_verified_at ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $user?->email_verified_at ? 'Terverifikasi' : 'Belum diverifikasi' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
