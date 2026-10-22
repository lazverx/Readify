@props(['user', 'anggota'])

@php
    $status = $user->status ?? 'pending';
    $namaLengkap = $anggota->nama_lengkap ?? $user->nama_pengguna;
    $nomorAnggota = $user->nomor_anggota ?? null;
@endphp

<!-- Status Pending State -->
@if($status === 'pending')
    <div class="max-w-2xl mx-auto w-full">
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 sm:p-8 text-center">
            <div
                class="w-16 h-16 sm:w-20 sm:h-20 bg-amber-100 dark:bg-amber-900/30 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('messages.id_card_pending_title') }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ __('messages.id_card_pending_desc') }}</p>
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4">
                <p class="text-xs sm:text-sm text-amber-800 dark:text-amber-200 leading-relaxed">
                    <strong>Status:</strong> {{ __('messages.id_card_pending_status') }}<br>
                    <strong>{{ __('messages.id_card_registered_date') }}:</strong> {{ $user->dibuat_pada->format('d F Y') }}
                </p>
            </div>
        </div>
    </div>
@else
    <!-- ID Card Active State -->
    <div class="w-full max-w-md mx-auto">
        <!-- ID Card Container -->
        <div class="relative bg-linear-to-br from-[#0f4c3a] via-[#155e49] to-[#0a3528] rounded-2xl sm:rounded-3xl shadow-xl overflow-hidden border border-emerald-400/20">
            <div class="flex flex-col">
                <!-- Top Section - Logo & Verification -->
                <div class="px-5 sm:px-6 pt-5 sm:pt-6 pb-4 flex items-center justify-between border-b border-emerald-400/20">
                    <!-- Logo Brand -->
                    <div class="flex items-center gap-2.5">
                        <img src="{{ asset('img/logo-id.svg') }}" alt="Logo" class="w-9 h-9 sm:w-11 sm:h-11">
                        <div>
                            <p class="text-white font-extrabold text-sm sm:text-base leading-tight tracking-wide">Readify</p>
                            <p class="text-emerald-200/80 text-[11px] sm:text-xs font-medium">{{ __('messages.id_card_digital_library') }}</p>
                        </div>
                    </div>
                    <!-- Verification Badge -->
                    <div class="bg-white/15 backdrop-blur-md rounded-full px-3 py-1 flex items-center space-x-1.5 border border-white/20">
                        <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-white font-bold text-[11px] sm:text-xs">{{ __('messages.id_card_verified') }}</span>
                    </div>
                </div>

                <!-- Bottom Section - Member Info -->
                <div class="px-5 sm:px-6 py-4 sm:py-5">
                    <!-- ID Number -->
                    <div class="mb-4">
                        <p class="text-emerald-200/80 text-[10px] sm:text-xs font-semibold uppercase tracking-wider mb-0.5">{{ __('messages.profile_member_id') }}</p>
                        <p class="text-white font-mono text-lg sm:text-xl font-black tracking-widest">{{ $nomorAnggota }}</p>
                    </div>

                    <!-- Member Details -->
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div>
                            <p class="text-emerald-200/80 text-[10px] sm:text-xs font-medium mb-0.5">{{ __('messages.full_name') }}</p>
                            <p class="text-white font-bold text-xs sm:text-sm leading-tight truncate">{{ $namaLengkap }}</p>
                        </div>
                        <div>
                            <p class="text-emerald-200/80 text-[10px] sm:text-xs font-medium mb-0.5">{{ __('messages.username') }}</p>
                            <p class="text-white font-bold text-xs sm:text-sm truncate">{{ $user->nama_pengguna }}</p>
                        </div>
                        <div>
                            <p class="text-emerald-200/80 text-[10px] sm:text-xs font-medium mb-0.5">{{ __('messages.registered_at') }}</p>
                            <p class="text-white font-bold text-xs sm:text-sm">{{ $user->dibuat_pada->format('Y') }}</p>
                        </div>
                        <div>
                            <p class="text-emerald-200/80 text-[10px] sm:text-xs font-medium mb-0.5">Status</p>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white">{{ __('messages.id_card_active') }}</span>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="pt-3 border-t border-emerald-400/20 text-emerald-100/70 text-[10px] sm:text-xs flex items-center justify-between">
                        <p>{{ __('messages.id_card_validity_note') }}</p>
                        <p>© {{ date('Y') }} Readify</p>
                    </div>
                </div>
            </div>

            <!-- Card Shine Effect -->
            <div
                class="absolute inset-0 bg-linear-to-tr from-transparent via-white/10 to-transparent -skew-x-12 transform translate-x-full hover:translate-x-0 transition-transform duration-1000 pointer-events-none">
            </div>
        </div>

        <!-- Card Back Info -->
        <div class="mt-3 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                {{ __('messages.id_card_validity_note') }} | Nomor: {{ $nomorAnggota }}
            </p>
        </div>
    </div>

    <!-- QR Code Script -->
    @if($nomorAnggota)
        <script type="module">
            import { generateMemberQR } from '/js/qr-code.js';

            document.addEventListener('DOMContentLoaded', async function () {
                const qrElement = document.querySelector('[data-qr-member-id="{{ $nomorAnggota }}"]');
                if (qrElement) {
                    const qrDataUrl = await generateMemberQR('{{ $nomorAnggota }}');
                    if (qrDataUrl) {
                        qrElement.innerHTML = `<img src="${qrDataUrl}" alt="QR Code" class="w-full h-full rounded">`;
                    }
                }
            });
        </script>
    @endif
@endif