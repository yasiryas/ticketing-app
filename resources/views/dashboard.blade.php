<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">

        <div class="flex justify-between mb-6">
            <h1 class="text-2xl font-bold">{{ $title }}</h1>
            <a href="{{ route('tickets.index') }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                Lihat Semua Ticket
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <!-- Total Tickets -->
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Ticket</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $total }}</p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Open -->
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Open</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $open }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2">{{ $progress['open'] }}% dari total</p>
            </div>

            <!-- In Progress -->
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Progress</p>
                        <p class="text-2xl font-bold text-yellow-500">{{ $in_progress }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2">{{ $progress['in_progress'] }}% dari total</p>
            </div>

            <!-- Closed -->
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Closed</p>
                        <p class="text-2xl font-bold text-green-600">{{ $closed }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2">{{ $progress['closed'] }}% dari total</p>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

            <!-- Progress Chart -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Progress Ticket
                </h3>

                <!-- Open -->
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-500 flex items-center gap-1">
                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span> Open
                        </span>
                        <span class="font-medium text-gray-700">{{ $open }} Tickets
                            ({{ $progress['open'] }}%)</span>
                    </div>
                    <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 transition-all duration-700 ease-out"
                            style="width: {{ $progress['open'] }}%"></div>
                    </div>
                </div>

                <!-- In Progress -->
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-500 flex items-center gap-1">
                            <span class="w-2 h-2 bg-yellow-500 rounded-full"></span> In Progress
                        </span>
                        <span class="font-medium text-gray-700">{{ $in_progress }} Tickets
                            ({{ $progress['in_progress'] }}%)</span>
                    </div>
                    <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-yellow-500 transition-all duration-700 ease-out"
                            style="width: {{ $progress['in_progress'] }}%"></div>
                    </div>
                </div>

                <!-- Closed -->
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-500 flex items-center gap-1">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span> Closed
                        </span>
                        <span class="font-medium text-gray-700">{{ $closed }} Tickets
                            ({{ $progress['closed'] }}%)</span>
                    </div>
                    <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 transition-all duration-700 ease-out"
                            style="width: {{ $progress['closed'] }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Unit Chart -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Ticket per Unit
                </h3>

                @if ($unitStats->count() > 0)
                    <div class="space-y-3">
                        @foreach ($unitStats as $index => $unit)
                            @php
                                $maxCount = $unitStats->max('tickets_count');
                                $percentage = $maxCount > 0 ? ($unit->tickets_count / $maxCount) * 100 : 0;
                                $colors = [
                                    'bg-indigo-500',
                                    'bg-blue-500',
                                    'bg-green-500',
                                    'bg-yellow-500',
                                    'bg-red-500',
                                    'bg-purple-500',
                                    'bg-pink-500',
                                    'bg-teal-500',
                                ];
                                $color = $colors[$index % count($colors)];
                            @endphp
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600 font-medium">{{ $unit->name }}</span>
                                    <span class="text-gray-500">{{ $unit->tickets_count }}
                                        ticket{{ $unit->tickets_count > 1 ? 's' : '' }}</span>
                                </div>
                                <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full {{ $color }} transition-all duration-700 ease-out"
                                        style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center h-40 text-gray-400">
                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p>Belum ada ticket</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Latest Tickets Table -->
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Ticket Terbaru
                </h3>
            </div>

            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul
                        </th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Unit
                        </th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pembuat
                        </th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal
                        </th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($latestTickets as $ticket)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4">
                                <p class="font-medium text-gray-800">{{ $ticket->title }}</p>
                                <p class="text-sm text-gray-400">{{ Str::limit($ticket->description, 50) }}</p>
                            </td>
                            <td class="p-4">
                                <span class="text-sm text-gray-600">{{ $ticket->unit->name ?? '-' }}</span>
                            </td>
                            <td class="p-4">
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $ticket->status == 'open'
                                        ? 'bg-blue-100 text-blue-700'
                                        : ($ticket->status == 'in_progress'
                                            ? 'bg-yellow-100 text-yellow-700'
                                            : 'bg-green-100 text-green-700') }}">
                                    {{ $ticket->status == 'open' ? 'Open' : ($ticket->status == 'in_progress' ? 'Progress' : 'Closed') }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="text-sm text-gray-600">{{ $ticket->user->name ?? '-' }}</span>
                            </td>
                            <td class="p-4">
                                <span class="text-sm text-gray-500">{{ $ticket->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="p-4">
                                <a href="{{ route('tickets.show', $ticket) }}"
                                    class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p>Belum ada ticket</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
