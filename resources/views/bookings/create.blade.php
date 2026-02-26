<x-layout :title="'Reservasi - ' . $location->name">
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
                        <a href="{{ route('locations.index') }}" class="text-slate-500 dark:text-slate-400 hover:text-blue-600">Lokasi</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-slate-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-slate-900 dark:text-white font-medium">Reservasi</span>
                    </li>
                </ol>
            </nav>

            <!-- Main Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="bg-emerald-600 text-white p-6 text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold">Buat Reservasi</h1>
                    <p class="text-emerald-200 mt-1">{{ $location->name }}</p>
                </div>

                <!-- Form -->
                <div class="p-6">
                    <form method="POST" action="{{ route('bookings.store', $location) }}">
                        @csrf

                        <div class="space-y-5">
                            @if($serviceCategories->count() > 0)
                            <div>
                                <label for="service_category_id" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    Kategori Layanan
                                </label>
                                <select
                                    id="service_category_id"
                                    name="service_category_id"
                                    class="w-full px-4 py-3.5 border-2 border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors bg-white dark:bg-slate-700 dark:text-white"
                                >
                                    <option value="">— Pilih kategori —</option>
                                    @foreach($serviceCategories as $category)
                                        <option value="{{ $category->id }}" {{ old('service_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                            @if($category->description) — {{ $category->description }} @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_category_id')
                                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                            <div>
                                <label for="customer_name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="customer_name"
                                    name="customer_name"
                                    value="{{ old('customer_name') }}"
                                    class="w-full px-4 py-3.5 border-2 border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors bg-white dark:bg-slate-700 dark:text-white"
                                    placeholder="Masukkan nama lengkap"
                                    required
                                >
                                @error('customer_name')
                                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="customer_phone" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    Nomor Telepon <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="tel"
                                    id="customer_phone"
                                    name="customer_phone"
                                    value="{{ old('customer_phone') }}"
                                    class="w-full px-4 py-3.5 border-2 border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors bg-white dark:bg-slate-700 dark:text-white"
                                    placeholder="08xxxxxxxxxx"
                                    required
                                >
                                @error('customer_phone')
                                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="booking_date" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    Tanggal Kunjungan <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="date"
                                    id="booking_date"
                                    name="booking_date"
                                    value="{{ old('booking_date', today()->addDay()->format('Y-m-d')) }}"
                                    min="{{ today()->format('Y-m-d') }}"
                                    class="w-full px-4 py-3.5 border-2 border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors bg-white dark:bg-slate-700 dark:text-white"
                                    required
                                >
                                @error('booking_date')
                                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="booking_time" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    Waktu Kunjungan <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="booking_time"
                                    name="booking_time"
                                    class="w-full px-4 py-3.5 border-2 border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors bg-white dark:bg-slate-700 dark:text-white"
                                    required
                                >
                                    <option value="">— Pilih waktu —</option>
                                    @foreach($slots as $slot)
                                        <option value="{{ $slot }}" {{ old('booking_time') == $slot ? 'selected' : '' }}>
                                            {{ $slot }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('booking_time')
                                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3.5 px-6 rounded-xl transition-all duration-200 hover:shadow-lg flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Buat Reservasi</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Info -->
                <div class="px-6 pb-6">
                    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm text-amber-800 dark:text-amber-300 font-medium">Informasi Reservasi</p>
                                <p class="text-sm text-amber-700 dark:text-amber-400 mt-1">
                                    Silakan datang tepat waktu sesuai jadwal. Anda bisa melakukan check-in pada hari kunjungan untuk mendapatkan tiket antrian.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
