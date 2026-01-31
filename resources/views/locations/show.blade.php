<x-layout :title="$location->name">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('locations.index') }}" class="text-blue-600 hover:text-blue-700 text-sm mb-2 inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>
                <h1 class="text-2xl font-bold text-slate-900">{{ $location->name }}</h1>
                <p class="text-slate-600">{{ $location->description }}</p>
            </div>
            <a href="{{ route('tickets.create', $location) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                Ambil Tiket
            </a>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Currently Serving -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Sedang Dilayani</h2>

                    @if($currentlyServing->isEmpty())
                        <p class="text-slate-500 text-center py-8">Belum ada yang dilayani</p>
                    @else
                        <div class="grid sm:grid-cols-2 gap-4">
                            @foreach($currentlyServing as $ticket)
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-2xl font-bold text-green-700">{{ $ticket->ticket_number }}</span>
                                        <span class="text-sm text-green-600">{{ $ticket->counter?->name }}</span>
                                    </div>
                                    @if($ticket->customer_name)
                                        <p class="text-green-600 text-sm mt-1">{{ $ticket->customer_name }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Waiting Queue -->
                <div class="bg-white rounded-xl border border-slate-200 p-6 mt-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">
                        Antrian Menunggu
                        <span class="text-sm font-normal text-slate-500">({{ $waitingTickets->count() }} orang)</span>
                    </h2>

                    @if($waitingTickets->isEmpty())
                        <p class="text-slate-500 text-center py-8">Tidak ada antrian</p>
                    @else
                        <div class="space-y-3">
                            @foreach($waitingTickets as $index => $ticket)
                                <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-slate-100' : '' }}">
                                    <div class="flex items-center space-x-4">
                                        <span class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center text-sm font-medium text-slate-600">
                                            {{ $index + 1 }}
                                        </span>
                                        <div>
                                            <span class="font-semibold text-slate-900">{{ $ticket->ticket_number }}</span>
                                            @if($ticket->customer_name)
                                                <span class="text-slate-500 text-sm ml-2">{{ $ticket->customer_name }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="text-sm text-slate-500">~{{ $ticket->estimated_wait_time }} menit</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Location Info -->
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h3 class="font-semibold text-slate-900 mb-4">Informasi Lokasi</h3>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Kode</dt>
                            <dd class="font-medium text-slate-900">{{ $location->code }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Jam Operasional</dt>
                            <dd class="font-medium text-slate-900">
                                {{ \Carbon\Carbon::parse($location->open_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($location->close_time)->format('H:i') }}
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Rata-rata Layanan</dt>
                            <dd class="font-medium text-slate-900">{{ $location->average_service_time }} menit</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Loket Aktif</dt>
                            <dd class="font-medium text-slate-900">{{ $location->counters->count() }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Counters -->
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h3 class="font-semibold text-slate-900 mb-4">Loket</h3>
                    <div class="space-y-3">
                        @foreach($location->counters as $counter)
                            <div class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b border-slate-100' : '' }}">
                                <span class="font-medium text-slate-900">{{ $counter->name }}</span>
                                @if($counter->currentOperator)
                                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Aktif</span>
                                @else
                                    <span class="text-xs bg-slate-100 text-slate-500 px-2 py-1 rounded">Tidak Aktif</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Display Link -->
                <a href="{{ route('locations.display', $location) }}" target="_blank" class="block bg-slate-900 hover:bg-slate-800 text-white text-center py-3 rounded-lg font-medium">
                    Buka Tampilan Display
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
    <script type="module">
        window.Echo.channel('location.{{ $location->id }}')
            .listen('.ticket.created', (e) => {
                location.reload();
            })
            .listen('.ticket.called', (e) => {
                location.reload();
            })
            .listen('.ticket.status.changed', (e) => {
                location.reload();
            });
    </script>
    @endpush
</x-layout>
