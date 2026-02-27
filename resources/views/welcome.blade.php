<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="min-h-screen flex flex-col" x-data="welcomePage()">
        <!-- Navbar -->
        <nav class="bg-white border-b border-gray-200 px-6 py-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <h1 class="text-xl font-bold text-indigo-600">Ticketing App</h1>
                <div class="flex gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 max-w-7xl mx-auto w-full p-6">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Tickets -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 cursor-pointer hover:shadow-md transition-shadow"
                    @click="filterStatus = ''; applyFilters()">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Tickets</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $total }}</p>
                        </div>
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Open Tickets -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 cursor-pointer hover:shadow-md transition-shadow"
                    @click="filterStatus = 'open'; applyFilters()">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Open</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $open }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $progress['open'] }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ $progress['open'] }}%</p>
                    </div>
                </div>

                <!-- In Progress Tickets -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 cursor-pointer hover:shadow-md transition-shadow"
                    @click="filterStatus = 'in_progress'; applyFilters()">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">In Progress</p>
                            <p class="text-3xl font-bold text-yellow-600">{{ $in_progress }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $progress['in_progress'] }}%">
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ $progress['in_progress'] }}%</p>
                    </div>
                </div>

                <!-- Closed Tickets -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 cursor-pointer hover:shadow-md transition-shadow"
                    @click="filterStatus = 'closed'; applyFilters()">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Closed</p>
                            <p class="text-3xl font-bold text-green-600">{{ $closed }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $progress['closed'] }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ $progress['closed'] }}%</p>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1 relative">
                        <svg class="w-5 h-5 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" x-model="searchQuery" @input.debounce.300ms="applyFilters()"
                            placeholder="Cari ticket..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:outline-none">
                    </div>

                    <!-- Status Filter Buttons -->
                    <div class="flex rounded-xl overflow-hidden border border-gray-200">
                        <button @click="filterStatus = ''; applyFilters()"
                            :class="filterStatus === '' ? 'bg-indigo-600 text-white' :
                                'bg-white text-gray-600 hover:bg-gray-50'"
                            class="px-4 py-2 text-sm font-medium transition-colors">
                            Semua
                        </button>
                        <button @click="filterStatus = 'open'; applyFilters()"
                            :class="filterStatus === 'open' ? 'bg-blue-600 text-white' :
                                'bg-white text-gray-600 hover:bg-gray-50'"
                            class="px-4 py-2 text-sm font-medium transition-colors border-l border-r border-gray-200">
                            Open
                        </button>
                        <button @click="filterStatus = 'in_progress'; applyFilters()"
                            :class="filterStatus === 'in_progress' ? 'bg-yellow-500 text-white' :
                                'bg-white text-gray-600 hover:bg-gray-50'"
                            class="px-4 py-2 text-sm font-medium transition-colors border-r border-gray-200">
                            Progress
                        </button>
                        <button @click="filterStatus = 'closed'; applyFilters()"
                            :class="filterStatus === 'closed' ? 'bg-green-600 text-white' :
                                'bg-white text-gray-600 hover:bg-gray-50'"
                            class="px-4 py-2 text-sm font-medium transition-colors">
                            Closed
                        </button>
                    </div>

                    <!-- Reset Button -->
                    <button @click="resetFilters()"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        Reset
                    </button>
                </div>
            </div>

            <!-- Tickets List -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">
                        <span
                            x-text="filterStatus === '' ? 'Semua Tickets' : (filterStatus === 'open' ? 'Open' : (filterStatus === 'in_progress' ? 'In Progress' : 'Closed'))"></span>
                        <span class="text-sm font-normal text-gray-500"
                            x-text="'(' + filteredTickets.length + ' tickets)'"></span>
                    </h2>
                </div>

                <div x-show="loading" class="text-center py-8">
                    <svg class="animate-spin h-8 w-8 text-indigo-600 mx-auto" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <p class="text-gray-500 mt-2">Memuat...</p>
                </div>

                <div x-show="!loading && filteredTickets.length > 0" class="space-y-4">
                    <template x-for="ticket in filteredTickets" :key="ticket.id">
                        <div class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                                        :class="ticket.status === 'open' ? 'bg-blue-100 text-blue-600' : (ticket
                                            .status === 'in_progress' ? 'bg-yellow-100 text-yellow-600' :
                                            'bg-green-100 text-green-600')">
                                        <svg x-show="ticket.status === 'open'" class="w-5 h-5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <svg x-show="ticket.status === 'in_progress'" class="w-5 h-5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <svg x-show="ticket.status === 'closed'" class="w-5 h-5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-semibold text-gray-800 truncate" x-text="ticket.title"></h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="inline-flex items-center gap-1 text-sm text-gray-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                                <span x-text="ticket.unit ? ticket.unit.name : 'No Unit'"></span>
                                            </span>
                                            <span class="text-gray-300">•</span>
                                            <span class="inline-flex items-center gap-1 text-sm text-gray-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span x-text="ticket.user ? ticket.user.name : 'Unknown'"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-2 ml-4">
                                    <span class="px-3 py-1 text-xs rounded-full whitespace-nowrap"
                                        :class="ticket.status === 'open' ? 'bg-blue-100 text-blue-700' : (ticket
                                            .status === 'in_progress' ? 'bg-yellow-100 text-yellow-700' :
                                            'bg-green-100 text-green-700')"
                                        x-text="ticket.status === 'open' ? 'Open' : (ticket.status === 'in_progress' ? 'In Progress' : 'Closed')">
                                    </span>
                                    <span class="text-xs text-gray-400 whitespace-nowrap"
                                        x-text="formatDate(ticket.created_at)"></span>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-gray-200" x-show="ticket.description">
                                <p class="text-sm text-gray-600 line-clamp-2" x-text="ticket.description"></p>
                            </div>
                            <div class="mt-3 flex items-center justify-between text-xs text-gray-400">
                                <span>Dibuat: <span x-text="formatDate(ticket.created_at)"></span></span>
                                <span x-show="ticket.updated_at && ticket.updated_at !== ticket.created_at">Diupdate:
                                    <span x-text="formatDate(ticket.updated_at)"></span></span>
                            </div>
                        </div>
                    </template>
                </div>

                <div x-show="!loading && filteredTickets.length === 0" class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-gray-500">Tidak ada ticket yang ditemukan</p>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="mt-8 text-center">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                        </svg>
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Login to Create Ticket
                    </a>
                @endauth
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-4 mt-auto">
            <div class="max-w-7xl mx-auto px-6 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Ticketing App. All rights reserved.
            </div>
        </footer>
    </div>

    <script>
        function welcomePage() {
            return {
                searchQuery: '',
                filterStatus: '',
                loading: false,
                allTickets: @json($tickets),
                filteredTickets: [],

                init() {
                    this.filteredTickets = this.allTickets;
                },

                applyFilters() {
                    this.loading = true;

                    // Simulate slight delay for UX
                    setTimeout(() => {
                        let tickets = this.allTickets;

                        // Filter by search query
                        if (this.searchQuery) {
                            const query = this.searchQuery.toLowerCase();
                            tickets = tickets.filter(ticket =>
                                ticket.title.toLowerCase().includes(query) ||
                                (ticket.unit && ticket.unit.name.toLowerCase().includes(query))
                            );
                        }

                        // Filter by status
                        if (this.filterStatus) {
                            tickets = tickets.filter(ticket => ticket.status === this.filterStatus);
                        }

                        this.filteredTickets = tickets;
                        this.loading = false;
                    }, 100);
                },

                resetFilters() {
                    this.searchQuery = '';
                    this.filterStatus = '';
                    this.applyFilters();
                },

                formatDate(dateString) {
                    const date = new Date(dateString);
                    const now = new Date();
                    const diff = now - date;
                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));

                    if (days === 0) {
                        const hours = Math.floor(diff / (1000 * 60 * 60));
                        if (hours === 0) {
                            const minutes = Math.floor(diff / (1000 * 60));
                            return minutes + ' menit yang lalu';
                        }
                        return hours + ' jam yang lalu';
                    } else if (days === 1) {
                        return 'Kemarin';
                    } else if (days < 7) {
                        return days + ' hari yang lalu';
                    } else {
                        return date.toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric'
                        });
                    }
                }
            }
        }
    </script>
</body>

</html>
