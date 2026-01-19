<x-filament-panels::page.simple>
    {{-- FIX: Gunakan Inline Style untuk memastikan tidak ada yang menutupi (Z-Index 99999) --}}
    <div
        style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 99999; display: flex; width: 100%; height: 100vh; background-color: white; overflow-y: auto;">

        {{-- Left Panel: Branding (Blue Theme) --}}
        <div class="hidden lg:flex lg:w-1/2 bg-slate-900 relative overflow-hidden shrink-0">
            {{-- Background Gradient --}}
            <div class="absolute inset-0 bg-linear-to-br from-slate-900 via-blue-900 to-slate-900"></div>
            <div class="absolute inset-0 opacity-10"
                style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 40px 40px;">
            </div>

            {{-- Content --}}
            <div class="relative z-10 flex flex-col justify-center px-16 text-white w-full h-full">
                <div class="mb-12">
                    <div class="w-12 h-1 bg-blue-500 rounded-full mb-6"></div>
                    <h1 class="text-4xl font-semibold mb-3 tracking-tight text-white">Portal BKAP</h1>
                    <p class="text-lg text-slate-400 font-light max-w-sm">
                        Sistem Manajemen Absensi & Monitoring Akademik
                    </p>
                </div>

                <div class="space-y-4 max-w-sm">
                    <div class="flex items-center gap-3 text-slate-300">
                        <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                        <p class="text-sm">Kelola data dan laporan</p>
                    </div>
                    <div class="flex items-center gap-3 text-slate-300">
                        <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                        <p class="text-sm">Monitor kehadiran</p>
                    </div>
                    <div class="flex items-center gap-3 text-slate-300">
                        <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                        <p class="text-sm">Akses aman</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Panel: Login Form --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white overflow-y-auto">
            <div class="w-full max-w-md">
                {{-- Mobile Brand --}}
                <div class="lg:hidden mb-10 text-center">
                    <h1 class="text-2xl font-bold text-slate-900">Portal BKAP</h1>
                    <p class="text-sm text-slate-500 mt-1">Admin Access</p>
                </div>

                {{-- Form Header --}}
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 mb-2">Sign In</h2>
                    <p class="text-slate-500 text-sm">Masuk ke dashboard admin</p>
                </div>

                {{-- Form Content --}}
                <div class="filament-form-content">
                    {{ $this->form }}

                    <div class="mt-6">
                        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()"
                            :full-width="$this->hasFullWidthFormActions()" />
                    </div>

                    {{-- Validation Errors Check --}}
                    @if ($errors->any())
                        <div
                            class="mt-6 p-4 rounded-xl bg-red-50 border border-red-100 flex items-start gap-3 animate-pulse">
                            <svg class="w-5 h-5 text-red-600 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <h3 class="text-sm font-bold text-red-800">Login Gagal</h3>
                                <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>

                <p class="mt-8 text-center text-xs text-slate-400">
                    © 2026 BKAP Portal
                </p>
            </div>
        </div>
    </div>

    {{-- Strict CSS Reset untuk elemen bawaan Filament yang mungkin bocor --}}
    <style>
        .fi-simple-page,
        .fi-simple-main,
        .fi-simple-layout {
            height: 100vh !important;
            padding: 0 !important;
            margin: 0 !important;
            max-width: none !important;
        }

        /* Sembunyikan elemen header default Filament jika masih muncul */
        .fi-simple-header {
            display: none !important;
        }

        /* Styling Input agar lebih rapi */
        input[type="email"],
        input[type="password"] {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            border-radius: 0.5rem;
        }

        button[type="submit"] {
            border-radius: 0.5rem;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }
    </style>
</x-filament-panels::page.simple>