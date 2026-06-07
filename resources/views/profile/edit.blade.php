<x-app-layout>
    <div class="min-h-screen bg-slate-100 py-12">
        <div class="mx-auto max-w-6xl px-6 sm:px-8 lg:px-10 space-y-10">

            {{-- Header --}}
            <div class="rounded-[32px] border border-slate-200 bg-slate-50/90 p-10 shadow-[0_28px_60px_rgba(15,23,42,0.08)]">
                <div class="grid gap-8 lg:grid-cols-[1.8fr_0.9fr] lg:items-center">
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-amber-600"></span>
                            <p class="uppercase tracking-[0.28em] text-xs font-semibold text-slate-400">Pusat Profil</p>
                        </div>
                        <div class="space-y-3">
                            <h1 class="text-3xl font-bold text-slate-950">Kelola Profil</h1>
                            <p class="max-w-xl text-sm leading-7 text-slate-500">Ubah detail akun, nomor kontak, dan kata sandi dengan cepat.</p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3 text-sm text-slate-600 lg:items-end">
                        <div class="flex items-center gap-2 rounded-3xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.99 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.92 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 8.91a16 16 0 0 0 5.61 5.61l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            <span>{{ $user->phone_number ?? '-' }}</span>
                        </div>
                        <div class="flex items-center gap-2 rounded-3xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                            <span>{{ $user->whatsapp_number ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Update Profile --}}
            <article class="rounded-[32px] border border-slate-200 bg-white shadow-[0_18px_40px_rgba(15,23,42,0.06)] overflow-hidden">
                <div class="flex">
                    <div class="w-1 shrink-0 bg-amber-500 rounded-l-[32px]"></div>
                    <div class="flex-1 p-10">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="h-1.5 w-1.5 rounded-full bg-amber-600"></span>
                            <p class="uppercase tracking-[0.28em] text-xs font-semibold text-slate-400">Informasi Akun</p>
                        </div>
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>
            </article>

            {{-- Update Password --}}
            <article class="rounded-[32px] border border-slate-200 bg-white shadow-[0_18px_40px_rgba(15,23,42,0.06)] overflow-hidden">
                <div class="flex">
                    <div class="w-1 shrink-0 bg-amber-500 rounded-l-[32px]"></div>
                    <div class="flex-1 p-10">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="h-1.5 w-1.5 rounded-full bg-amber-600"></span>
                            <p class="uppercase tracking-[0.28em] text-xs font-semibold text-slate-400">Ubah Sandi</p>
                        </div>
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </article>

            {{-- Delete Account --}}
            <article class="rounded-[32px] border border-red-100 bg-white shadow-[0_18px_40px_rgba(15,23,42,0.06)] overflow-hidden">
                <div class="flex">
                    <div class="w-1 shrink-0 bg-red-400 rounded-l-[32px]"></div>
                    <div class="flex-1 p-10">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-400"></span>
                            <p class="uppercase tracking-[0.28em] text-xs font-semibold text-red-400">Hapus Akun</p>
                        </div>
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </article>

        </div>
    </div>
</x-app-layout>