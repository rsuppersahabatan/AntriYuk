<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="refresh" content="30">

    <title>Display - {{ $location->name }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-white min-h-screen">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-slate-800 px-8 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">{{ $location->name }}</h1>
                    <p class="text-slate-400">{{ $location->description }}</p>
                </div>
                <div class="text-right">
                    <div class="text-4xl font-bold" id="clock">--:--:--</div>
                    <div class="text-slate-400" id="date">--</div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="grid lg:grid-cols-3 gap-8 h-full">
                <!-- Currently Calling -->
                <div class="lg:col-span-2">
                    <h2 class="text-xl font-semibold text-slate-300 mb-4">SEDANG DIPANGGIL</h2>
                    <div id="calling-tickets" class="grid md:grid-cols-2 gap-6">
                        <div class="bg-slate-800 rounded-2xl p-8 text-center">
                            <p class="text-slate-500">Memuat...</p>
                        </div>
                    </div>
                </div>

                <!-- Waiting Queue -->
                <div class="bg-slate-800 rounded-2xl p-6">
                    <h2 class="text-xl font-semibold text-slate-300 mb-4">ANTRIAN BERIKUTNYA</h2>
                    <div id="waiting-tickets" class="space-y-3">
                        <p class="text-slate-500 text-center py-4">Memuat...</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-slate-800 px-8 py-4">
            <div class="flex items-center justify-between text-slate-400">
                <span>AntriYuk - Sistem Manajemen Antrian</span>
                <span id="waiting-count">0 antrian menunggu</span>
            </div>
        </footer>
    </div>

    <script type="module">
        // Clock
        function updateClock() {
            const now = new Date();
            document.getElementById('clock').textContent = now.toLocaleTimeString('id-ID');
            document.getElementById('date').textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Load initial data
        function loadData() {
            fetch('{{ route("locations.show", $location) }}')
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    // Just reload the page for simplicity
                });
        }

        // WebSocket listeners
        window.Echo.channel('location.{{ $location->id }}')
            .listen('.ticket.called', (e) => {
                // Play sound
                const audio = new Audio('/sounds/ding.mp3');
                audio.play().catch(() => {});

                // Show notification
                const container = document.getElementById('calling-tickets');
                container.innerHTML = `
                    <div class="bg-green-600 rounded-2xl p-8 text-center animate-pulse">
                        <p class="text-green-200 mb-2">${e.counter?.name || 'Loket'}</p>
                        <p class="text-6xl font-bold">${e.ticket.ticket_number}</p>
                        ${e.ticket.customer_name ? `<p class="text-green-200 mt-2">${e.ticket.customer_name}</p>` : ''}
                    </div>
                `;

                setTimeout(() => location.reload(), 5000);
            })
            .listen('.ticket.status.changed', (e) => {
                location.reload();
            })
            .listen('.queue.updated', (e) => {
                document.getElementById('waiting-count').textContent = `${e.waiting_count} antrian menunggu`;
            });

        // Initial load simulation
        document.addEventListener('DOMContentLoaded', () => {
            const callingContainer = document.getElementById('calling-tickets');
            const waitingContainer = document.getElementById('waiting-tickets');

            // This would be populated via API or passed data
            @php
                $calling = $location->tickets()->whereIn('status', ['calling', 'serving'])->with('counter')->get();
                $waiting = $location->waitingTickets()->take(10)->get();
            @endphp

            @if($calling->isEmpty())
                callingContainer.innerHTML = `
                    <div class="bg-slate-700 rounded-2xl p-8 text-center col-span-2">
                        <p class="text-slate-400 text-xl">Tidak ada yang dipanggil</p>
                    </div>
                `;
            @else
                callingContainer.innerHTML = `
                    @foreach($calling as $ticket)
                    <div class="bg-green-600 rounded-2xl p-8 text-center">
                        <p class="text-green-200 mb-2">{{ $ticket->counter?->name }}</p>
                        <p class="text-6xl font-bold">{{ $ticket->ticket_number }}</p>
                        @if($ticket->customer_name)
                            <p class="text-green-200 mt-2">{{ $ticket->customer_name }}</p>
                        @endif
                    </div>
                    @endforeach
                `;
            @endif

            @if($waiting->isEmpty())
                waitingContainer.innerHTML = `
                    <p class="text-slate-400 text-center py-4">Tidak ada antrian</p>
                `;
            @else
                waitingContainer.innerHTML = `
                    @foreach($waiting as $ticket)
                    <div class="flex items-center justify-between py-3 border-b border-slate-700">
                        <span class="text-xl font-semibold">{{ $ticket->ticket_number }}</span>
                        <span class="text-slate-400">~{{ $ticket->estimated_wait_time }} menit</span>
                    </div>
                    @endforeach
                `;
            @endif

            document.getElementById('waiting-count').textContent = '{{ $waiting->count() }} antrian menunggu';
        });
    </script>
</body>
</html>
