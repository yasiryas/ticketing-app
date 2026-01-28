<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">

        <div class="flex justify-between mb-6">
            <h1 class="text-2xl font-bold">{{ $title }}</h1>
            <a href="{{ route('tickets.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">
                + Ticket Baru
            </a>
        </div>


        <div class="bg-white shadow rounded">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Judul</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($latestTickets as $ticket)
                        <tr class="border-t">
                            <td class="p-3">{{ $ticket->title }}</td>
                            <td>
                                <span
                                    class="px-2 py-1 rounded text-white
                        {{ $ticket->status == 'open' ? 'bg-blue-500' : ($ticket->status == 'in_progress' ? 'bg-yellow-500' : 'bg-green-600') }}">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </td>
                            <td>{{ $ticket->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('tickets.show', $ticket) }}" class="text-indigo-600">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Chart Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10 mt-6">
            <!-- Chart -->
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h3 class="text-sm font-semibold mb-4 text-gray-700">
                    Ticket Progress
                </h3>

                <!-- Open -->
                <div class="mb-4">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-500">Open</span>
                        <span class="font-medium">{{ $open }} Tickets
                            <span class="text-grey-400">
                                ({{ $progress['open'] }}%)
                            </span>
                        </span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-red-500 transition-all duration-700 ease-out"
                            style="width: {{ $progress['open'] }}%">
                        </div>
                    </div>
                </div>

                <!-- In Progress -->
                <div class="mb-4">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-500">In Progress</span>
                        <span class="font-medium">{{ $in_progress }} Tickets
                            <span class="text-grey-400">
                                ({{ $progress['in_progress'] }}%)
                            </span>
                        </span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-yellow-400 transition-all duration-700 ease-out"
                            style="width: {{ $progress['in_progress'] }}%">
                        </div>
                    </div>
                </div>

                <!-- Closed -->
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-500">Closed</span>
                        <span class="font-medium">{{ $closed }} Tickets
                            <span class="text-grey-400">
                                ({{ $progress['closed'] }}%)
                            </span>
                        </span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 transition-all duration-700 ease-out"
                            style="width: {{ $progress['closed'] }}%">
                        </div>
                    </div>
                </div>



            </div>
        </div>



</x-app-layout>
