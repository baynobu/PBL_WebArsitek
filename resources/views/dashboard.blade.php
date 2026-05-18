<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
                <div class="p-6 border-t bg-gray-50 dark:bg-gray-900">
                    <h3 class="font-semibold mb-3">Quick Links</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('proyek.index') }}" class="rounded bg-blue-600 px-3 py-2 text-sm text-white">Daftar Proyek</a>
                        <a href="{{ route('proyek.my') }}" class="rounded bg-indigo-600 px-3 py-2 text-sm text-white">Proyek Saya</a>
                        <a href="{{ route('proyek.create') }}" class="rounded bg-green-600 px-3 py-2 text-sm text-white">Buat Proyek</a>
                        <a href="{{ route('proposal.index') }}" class="rounded bg-yellow-600 px-3 py-2 text-sm text-white">Daftar Proposal</a>
                        <a href="{{ route('portofolio.index') }}" class="rounded bg-pink-600 px-3 py-2 text-sm text-white">Portofolio Saya</a>
                        <a href="{{ route('portofolio.create') }}" class="rounded bg-pink-500 px-3 py-2 text-sm text-white">Tambah Portofolio</a>
                        <a href="{{ route('arsitek.profile.edit') }}" class="rounded bg-gray-700 px-3 py-2 text-sm text-white">Edit Profil Arsitek</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
