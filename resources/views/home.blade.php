<x-layout title="Beranda">
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mb-4">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                            </svg>
                            Antrian Digital
                        </span>
                        <h1 class="text-4xl tracking-tight font-extrabold text-slate-900 sm:text-5xl md:text-6xl">
                            <span class="block">Antri Lebih</span>
                            <span class="block text-blue-600">Cerdas & Efisien</span>
                        </h1>
                        <p class="mt-3 text-base text-slate-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Tidak perlu menunggu lama di tempat. Ambil tiket digital, pantau posisi antrian dari mana saja, dan datang saat giliran Anda tiba.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-xl shadow">
                                <a href="{{ route('locations.index') }}" class="w-full flex items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                                    Ambil Tiket Sekarang
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="{{ route('tickets.check') }}" class="w-full flex items-center justify-center px-8 py-4 border border-slate-300 text-base font-medium rounded-xl text-slate-700 bg-white hover:bg-slate-50 md:py-4 md:text-lg md:px-10">
                                    Cek Antrian Saya
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <div class="h-56 w-full bg-blue-50 sm:h-72 md:h-96 lg:w-full lg:h-full flex items-center justify-center">
                <svg class="w-64 h-64 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-blue-600">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                <div class="text-center">
                    <p class="text-4xl font-extrabold text-white">{{ $stats['locations'] ?? 3 }}+</p>
                    <p class="mt-1 text-blue-200">Lokasi Layanan</p>
                </div>
                <div class="text-center">
                    <p class="text-4xl font-extrabold text-white">{{ $stats['counters'] ?? 9 }}+</p>
                    <p class="mt-1 text-blue-200">Loket Aktif</p>
                </div>
                <div class="text-center">
                    <p class="text-4xl font-extrabold text-white">{{ $stats['today_tickets'] ?? 0 }}</p>
                    <p class="mt-1 text-blue-200">Tiket Hari Ini</p>
                </div>
                <div class="text-center">
                    <p class="text-4xl font-extrabold text-white">~5</p>
                    <p class="mt-1 text-blue-200">Menit/Layanan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Fitur Unggulan</h2>
                <p class="mt-2 text-3xl font-extrabold text-slate-900 sm:text-4xl">
                    Cara Kerja AntriYuk
                </p>
                <p class="mt-4 max-w-2xl text-xl text-slate-500 mx-auto">
                    Tiga langkah mudah untuk pengalaman antri tanpa stres
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-3">
                <!-- Step 1 -->
                <div class="relative bg-white p-8 rounded-2xl border border-slate-200 hover:shadow-lg transition-shadow">
                    <div class="absolute -top-4 left-8">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white text-sm font-bold">1</span>
                    </div>
                    <div class="mt-4">
                        <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mb-5">
                            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Ambil Tiket Digital</h3>
                        <p class="text-slate-600 leading-relaxed">Pilih lokasi layanan dan ambil tiket antrian secara online. Tidak perlu datang lebih awal.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative bg-white p-8 rounded-2xl border border-slate-200 hover:shadow-lg transition-shadow">
                    <div class="absolute -top-4 left-8">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white text-sm font-bold">2</span>
                    </div>
                    <div class="mt-4">
                        <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center mb-5">
                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Pantau Real-time</h3>
                        <p class="text-slate-600 leading-relaxed">Lihat posisi antrian dan estimasi waktu tunggu langsung dari smartphone Anda.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative bg-white p-8 rounded-2xl border border-slate-200 hover:shadow-lg transition-shadow">
                    <div class="absolute -top-4 left-8">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-purple-600 text-white text-sm font-bold">3</span>
                    </div>
                    <div class="mt-4">
                        <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center mb-5">
                            <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Datang Tepat Waktu</h3>
                        <p class="text-slate-600 leading-relaxed">Terima notifikasi saat giliran hampir tiba. Datang tepat waktu tanpa menunggu lama.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Locations Preview -->
    @if(isset($locations) && $locations->count() > 0)
    <div class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Lokasi Tersedia</h2>
                <p class="mt-2 text-3xl font-extrabold text-slate-900 sm:text-4xl">
                    Pilih Layanan Anda
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($locations->take(3) as $location)
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <span class="inline-block bg-blue-600 text-white text-xs font-bold px-2.5 py-1 rounded-lg mb-2">
                                    {{ $location->code }}
                                </span>
                                <h3 class="text-xl font-bold text-slate-900">{{ $location->name }}</h3>
                            </div>
                            @if($location->isOpen())
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-green-100 text-green-800">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>
                                    Buka
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-red-100 text-red-800">
                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-1.5"></span>
                                    Tutup
                                </span>
                            @endif
                        </div>

                        @if($location->description)
                            <p class="text-slate-600 text-sm mb-4 line-clamp-2">{{ $location->description }}</p>
                        @endif

                        <div class="flex items-center text-sm text-slate-500 mb-4 space-x-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($location->open_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($location->close_time)->format('H:i') }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $location->waiting_count }} menunggu
                            </span>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                        <a href="{{ route('tickets.create', $location) }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold transition-colors">
                            Ambil Tiket
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            @if($locations->count() > 3)
            <div class="text-center mt-8">
                <a href="{{ route('locations.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold">
                    Lihat Semua Lokasi
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- CTA Section -->
    <div class="bg-blue-600">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Siap untuk menghemat waktu?</span>
                <span class="block text-blue-200">Mulai gunakan AntriYuk sekarang.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-xl shadow">
                    <a href="{{ route('locations.index') }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-xl text-blue-600 bg-white hover:bg-blue-50">
                        Mulai Sekarang
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layout>
