<x-layout :title="'Reservasi ' . $booking->booking_code">
    <div class="min-h-screen bg-slate-50 dark:bg-slate-900 py-8">
        <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li><a href="{{ route('home') }}" class="text-slate-500 dark:text-slate-400 hover:text-blue-600">Beranda</a></li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-slate-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-slate-900 dark:text-white font-medium">Detail Reservasi</span>
                    </li>
                </ol>
            </nav>

            <!-- Main Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                @php
                    $statusColor = match($booking->status) {
                        'pending' => 'bg-amber-500',
                        'confirmed' => 'bg-emerald-600',
                        'checked_in' => 'bg-blue-600',
                        'completed' => 'bg-slate-600',
                        'cancelled' => 'bg-red-500',
                        default => 'bg-slate-500',
                    };
                    $statusLabel = match($booking->status) {
                        'pending' => 'Menunggu Konfirmasi',
                        'confirmed' => 'Dikonfirmasi',
                        'checked_in' => 'Sudah Check-in',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => $booking->status,
                    };
                @endphp

                <div class="{{ $statusColor }} text-white p-6 text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold font-mono tracking-wider">{{ $booking->booking_code }}</h1>
                    <span class="inline-flex items-center mt-2 bg-white/20 text-white text-sm font-medium px-3 py-1 rounded-full">
                        {{ $statusLabel }}
                    </span>
                </div>

                <!-- Booking Details -->
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 dark:bg-slate-700 rounded-xl p-4">
                            <p class="text-sm text-slate-500 dark:text-slate-400">Lokasi</p>
                            <p class="font-semibold text-slate-900 dark:text-white mt-1">{{ $booking->location->name }}</p>
                        </div>
                        @if($booking->serviceCategory)
                        <div class="bg-slate-50 dark:bg-slate-700 rounded-xl p-4">
                            <p class="text-sm text-slate-500 dark:text-slate-400">Kategori</p>
                            <p class="font-semibold text-slate-900 dark:text-white mt-1">{{ $booking->serviceCategory->name }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 dark:bg-slate-700 rounded-xl p-4">
                            <p class="text-sm text-slate-500 dark:text-slate-400">Tanggal</p>
                            <p class="font-semibold text-slate-900 dark:text-white mt-1">{{ $booking->booking_date->format('d M Y') }}</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-slate-700 rounded-xl p-4">
                            <p class="text-sm text-slate-500 dark:text-slate-400">Waktu</p>
                            <p class="font-semibold text-slate-900 dark:text-white mt-1">{{ is_string($booking->booking_time) ? $booking->booking_time : $booking->booking_time->format('H:i') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 dark:bg-slate-700 rounded-xl p-4">
                            <p class="text-sm text-slate-500 dark:text-slate-400">Nama</p>
                            <p class="font-semibold text-slate-900 dark:text-white mt-1">{{ $booking->customer_name }}</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-slate-700 rounded-xl p-4">
                            <p class="text-sm text-slate-500 dark:text-slate-400">Telepon</p>
                            <p class="font-semibold text-slate-900 dark:text-white mt-1">{{ $booking->customer_phone }}</p>
                        </div>
                    </div>

                    @if($booking->ticket)
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-blue-600 dark:text-blue-400">Tiket Antrian</p>
                                <p class="text-xl font-bold text-blue-800 dark:text-blue-300 mt-1">{{ $booking->ticket->ticket_number }}</p>
                            </div>
                            <a href="{{ route('tickets.show', $booking->ticket) }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                                Lihat Tiket
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="px-6 pb-6 space-y-3">
                    @if(in_array($booking->status, ['pending', 'confirmed']) && $booking->booking_date->isToday())
                    <form method="POST" action="{{ route('bookings.check-in', $booking) }}">
                        @csrf
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3.5 px-6 rounded-xl transition-all duration-200 hover:shadow-lg flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Check-in Sekarang</span>
                        </button>
                    </form>
                    @endif

                    @if(!in_array($booking->status, ['checked_in', 'completed', 'cancelled']))
                    <form method="POST" action="{{ route('bookings.cancel', $booking) }}" onsubmit="return confirm('Yakin ingin membatalkan reservasi ini?')">
                        @csrf
                        <button type="submit" class="w-full bg-white dark:bg-slate-700 border-2 border-red-300 dark:border-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 dark:text-red-400 font-semibold py-3 px-6 rounded-xl transition-all duration-200">
                            Batalkan Reservasi
                        </button>
                    </form>
                    @endif

                    <!-- QR Code -->
                    <div class="text-center pt-4 border-t border-slate-100 dark:border-slate-700">
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">QR Code Reservasi</p>
                        <div id="booking-qr" class="inline-block"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof QRCode !== 'undefined') {
                new QRCode(document.getElementById('booking-qr'), {
                    text: '{{ route('bookings.show', $booking) }}',
                    width: 120,
                    height: 120,
                    colorDark: '#1e293b',
                    colorLight: '#ffffff',
                });
            }
        });
    </script>
    @endpush
</x-layout>
