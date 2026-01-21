@php
    $this->form->fill();
@endphp

<div>
    {{-- Custom Login Layout dengan INLINE STYLES --}}
    <div id="custom-login-wrapper"
        style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 99999; display: flex; width: 100%; height: 100vh; background-color: #ffffff; overflow-y: auto;">

        {{-- Left Panel: Branding (Emerald Theme) --}}
        <div class="login-branding-panel"
            style="display: none; width: 50%; background: linear-gradient(135deg, #0f172a 0%, #064e3b 50%, #0f172a 100%); position: relative; overflow: hidden; flex-shrink: 0;">
            {{-- Grid Pattern --}}
            <div
                style="position: absolute; inset: 0; opacity: 0.1; background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 40px 40px;">
            </div>

            {{-- Content --}}
            <div
                style="position: relative; z-index: 10; display: flex; flex-direction: column; justify-content: center; padding: 3rem 4rem; color: white; width: 100%; height: 100%;">
                <div style="margin-bottom: 3rem;">
                    <div
                        style="width: 3rem; height: 0.25rem; background-color: #10b981; border-radius: 9999px; margin-bottom: 1.5rem;">
                    </div>
                    <h1
                        style="font-size: 2.25rem; font-weight: 600; margin-bottom: 0.75rem; letter-spacing: -0.025em; color: white;">
                        Portal Pembimbing</h1>
                    <p style="font-size: 1.125rem; color: #94a3b8; font-weight: 300; max-width: 24rem;">
                        Portal Pembimbing untuk Monitoring Halaqah
                    </p>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1rem; max-width: 24rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; color: #cbd5e1;">
                        <div
                            style="width: 0.375rem; height: 0.375rem; border-radius: 9999px; background-color: #34d399;">
                        </div>
                        <p style="font-size: 0.875rem; margin: 0;">Kelola sesi halaqah</p>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem; color: #cbd5e1;">
                        <div
                            style="width: 0.375rem; height: 0.375rem; border-radius: 9999px; background-color: #34d399;">
                        </div>
                        <p style="font-size: 0.875rem; margin: 0;">Input kehadiran santri</p>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem; color: #cbd5e1;">
                        <div
                            style="width: 0.375rem; height: 0.375rem; border-radius: 9999px; background-color: #34d399;">
                        </div>
                        <p style="font-size: 0.875rem; margin: 0;">Monitor progres hafalan</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Panel: Login Form --}}
        <div class="login-form-panel"
            style="width: 100%; display: flex; align-items: center; justify-content: center; padding: 2rem; background-color: #ffffff; overflow-y: auto;">
            <div style="width: 100%; max-width: 28rem;">
                {{-- Mobile Brand --}}
                <div class="mobile-brand" style="display: block; margin-bottom: 2.5rem; text-align: center;">
                    <h1 style="font-size: 1.5rem; font-weight: 700; color: #0f172a; margin: 0;">Portal Pembimbing</h1>
                    <p style="font-size: 0.875rem; color: #64748b; margin-top: 0.25rem;">Mentor Access</p>
                </div>

                {{-- Form Header --}}
                <div style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; font-weight: 700; color: #0f172a; margin: 0 0 0.5rem 0;">Sign In</h2>
                    <p style="color: #64748b; font-size: 0.875rem; margin: 0;">Masuk ke dashboard mentor</p>
                </div>

                {{-- Form Content --}}
                <div class="filament-form-content">
                    <form wire:submit="authenticate" style="display: flex; flex-direction: column; gap: 1.5rem;">
                        {{ $this->form }}

                        <div style="margin-top: 1rem;">
                            <x-filament::button type="submit" style="width: 100%;">
                                Sign in
                            </x-filament::button>
                        </div>
                    </form>
                </div>

                <p style="margin-top: 2rem; text-align: center; font-size: 0.75rem; color: #94a3b8;">
                    © 2026 Portal Pembimbing
                </p>
            </div>
        </div>
    </div>

    {{-- Loading Overlay --}}
    <div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 100000; display: flex; align-items: center; justify-content: center;">
        <div style="background-color: white; border-radius: 1rem; padding: 2.5rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); text-align: center; min-width: 18rem;">
            <div style="display: flex; justify-content: center; margin-bottom: 1.5rem;">
                <div class="spinner" style="width: 3rem; height: 3rem; border: 4px solid #e5e7eb; border-top-color: #059669; border-radius: 50%; animation: spin 1s linear infinite;"></div>
            </div>
            <p style="color: #1e293b; font-weight: 600; font-size: 1rem; margin: 0;">Loading...</p>
            <p style="color: #64748b; font-size: 0.875rem; margin-top: 0.5rem; margin-bottom: 0;">Mohon tunggu, kami sedang memproses login Anda</p>
        </div>
    </div>

    {{-- CSS Styling --}}
    <style>
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive: Show branding panel on large screens */
        @media (min-width: 1024px) {
            .login-branding-panel {
                display: flex !important;
            }

            .login-form-panel {
                width: 50% !important;
            }

            .mobile-brand {
                display: none !important;
            }
        }

        /* ===== INPUT FIELD STYLING ===== */
        .filament-form-content input,
        .fi-input input,
        .fi-fo-text-input input,
        input[type="email"],
        input[type="password"],
        input[type="text"] {
            background-color: #f8fafc !important;
            border: 2px solid #e2e8f0 !important;
            border-radius: 0.5rem !important;
            padding: 0.875rem 1rem !important;
            font-size: 1rem !important;
            color: #1e293b !important;
            transition: all 0.2s ease !important;
            width: 100% !important;
        }

        .filament-form-content input:hover,
        .fi-input input:hover,
        input:hover {
            border-color: #cbd5e1 !important;
            background-color: #ffffff !important;
        }

        .filament-form-content input:focus,
        .fi-input input:focus,
        input:focus {
            border-color: #10b981 !important;
            background-color: #ffffff !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15) !important;
            outline: none !important;
            color: #0f172a !important;
        }

        /* Placeholder */
        input::placeholder {
            color: #94a3b8 !important;
            opacity: 1 !important;
        }

        /* ===== LABEL STYLING ===== */
        .fi-fo-field-wrp label,
        .fi-input-wrp label,
        label {
            color: #334155 !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
            margin-bottom: 0.5rem !important;
            display: block !important;
        }

        .fi-fo-field-wrp label span,
        label span {
            color: #334155 !important;
        }

        .fi-fo-field-wrp-label sup,
        label sup {
            color: #ef4444 !important;
        }

        /* ===== SUBMIT BUTTON ===== */
        .filament-form-content button[type="submit"],
        .fi-btn,
        button[type="submit"] {
            background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
            border-radius: 0.5rem !important;
            padding: 0.875rem 1.5rem !important;
            font-weight: 600 !important;
            font-size: 1rem !important;
            color: white !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(4, 120, 87, 0.3) !important;
            transition: all 0.3s ease !important;
            width: 100% !important;
            cursor: pointer !important;
        }

        .filament-form-content button[type="submit"]:hover,
        .fi-btn:hover,
        button[type="submit"]:hover {
            background: linear-gradient(135deg, #047857 0%, #059669 100%) !important;
            box-shadow: 0 6px 16px rgba(4, 120, 87, 0.4) !important;
            transform: translateY(-1px) !important;
        }

        /* Icon dalam input */
        .fi-input-wrp svg,
        .fi-fo-text-input svg {
            color: #64748b !important;
        }

        /* Error message */
        .fi-fo-field-wrp-error-message {
            color: #dc2626 !important;
            font-size: 0.875rem !important;
        }

        /* Form field wrapper spacing */
        .fi-fo-field-wrp {
            margin-bottom: 1.25rem !important;
        }

        /* Hide Remember Me checkbox */
        .filament-form-content [type="checkbox"],
        .fi-fo-checkbox-wrp,
        input[type="checkbox"],
        label:has([type="checkbox"]) {
            display: none !important;
        }
    </style>

    {{-- JavaScript for Loading Overlay --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[wire\\:submit]');
            const loadingOverlay = document.getElementById('loading-overlay');

            if (form && loadingOverlay) {
                form.addEventListener('submit', function() {
                    // Show loading overlay
                    loadingOverlay.style.display = 'flex';
                });

                // Listen for Livewire events to hide loading on error
                if (window.Livewire) {
                    Livewire.hook('commit.response', ({respond, skip}) => {
                        // Hide loading overlay after response
                        if (loadingOverlay) {
                            setTimeout(() => {
                                loadingOverlay.style.display = 'none';
                            }, 300);
                        }
                    });
                }
            }
        });
    </script>
</div>
