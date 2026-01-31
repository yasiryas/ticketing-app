<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex justify-between mb-6">
            <h1 class="text-2xl font-bold">Ticket Masuk</h1>
            <a href="{{ route('tickets.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">
                + Ticket Baru
            </a>
        </div>

        <div class="bg-white shadow rounded">
            <table class="w-full">
                <thead class="">
                    <tr>
                        <th class="p-3 text-left">Judul</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
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
    </div>
</x-app-layout>
