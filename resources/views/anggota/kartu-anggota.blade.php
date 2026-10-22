@extends('layouts.app')

@section('title', __('messages.id_card_title'))

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('messages.id_card_title') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('messages.id_card_subtitle') }}</p>
            </div>
        </div>

        <!-- ID Card & Informasi Tambahan - Side by Side -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

            <!-- ID Card Component -->
            <div class="flex justify-center w-full">
                <x-id-card :user="$user" :anggota="$anggota" />
            </div>

            <!-- Additional Information -->
            @if($user->isActive())
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 h-full">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.id_card_additional_info') }}</h3>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-gray-50 dark:border-gray-700/50">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.id_card_number') }}</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white font-mono">{{ $user->nomor_anggota }}</span>
                        </div>

                        <div class="flex justify-between items-center py-2 border-b border-gray-50 dark:border-gray-700/50">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.id_card_membership_status') }}</span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                                {{ __('messages.id_card_active') }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center py-2 border-b border-gray-50 dark:border-gray-700/50">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.id_card_joined_date') }}</span>
                            <span
                                class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->dibuat_pada->format('d F Y') }}</span>
                        </div>

                        @if($anggota)
                            <div class="flex justify-between items-center py-2 border-b border-gray-50 dark:border-gray-700/50">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.email') }}</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->email }}</span>
                            </div>

                            <div class="flex justify-between items-center py-2 border-b border-gray-50 dark:border-gray-700/50">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.phone') }}</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $anggota->nomor_telepon }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-2 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ __('messages.id_card_validity_note') }}
                        </div>
                    </div>
                </div>
            @else
                <!-- Placeholder kosong jika tidak aktif agar grid tetap rapi -->
                <div></div>
            @endif


        </div>
    </div>
@endsection