<x-app-layout>

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">
                {{ $ticket->title }}
            </h1>
            <p class="text-sm text-gray-500">
                Ticket #{{ $ticket->id }} · Dibuat {{ $ticket->created_at->diffForHumans() }}
            </p>
        </div>

        {{-- STATUS BADGE --}}
        <span
            class="px-3 py-1 text-xs rounded-full
            @if ($ticket->status === 'open') bg-red-100 text-red-600
            @elseif($ticket->status === 'in_progress')
                bg-yellow-100 text-yellow-700
            @else
                bg-green-100 text-green-600 @endif
        ">
            {{ strtoupper(str_replace('_', ' ', $ticket->status)) }}
        </span>
    </div>

    {{-- CONTENT --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT: DETAIL --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">

            <h3 class="text-sm font-semibold text-gray-700 mb-2">
                Deskripsi
            </h3>

            <p class="text-sm text-gray-600 whitespace-pre-line">
                {{ $ticket->description }}
            </p>

            {{-- REPLY SECTION --}}
            <div class="mt-8">
                {{-- flash --}}
                @if (session('success'))
                    <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <h3 class="text-sm font-semibold text-gray-700 mb-4">
                    Diskusi
                </h3>

                {{-- THREAD --}}
                <div class="space-y-4 mb-6">
                    @forelse($ticket->replies as $reply)
                        <div
                            class="p-4 rounded-lg
                            {{ $reply->user->role === 'admin' ? 'bg-indigo-50 border border-indigo-200' : 'bg-gray-100' }}">

                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span class="font-semibold">
                                    {{ $reply->user->name }}
                                    @if ($reply->user->role === 'admin')
                                        <span class="text-indigo-600">(Admin)</span>
                                    @endif
                                </span>
                                <span>{{ $reply->created_at->diffForHumans() }}</span>
                            </div>

                            <p class="text-sm text-gray-700 whitespace-pre-line">
                                {{ $reply->message }}
                            </p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">
                            Belum ada balasan.
                        </p>
                    @endforelse
                </div>

                {{-- FORM REPLY --}}
                <form method="POST" action="{{ route('tickets.reply', $ticket) }}">
                    @csrf

                    <textarea name="message" rows="3" class="w-full border rounded-lg p-3 text-sm focus:ring focus:ring-indigo-200"
                        placeholder="Tulis balasan..." required></textarea>

                    <div class="flex justify-end mt-2">
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm">
                            Kirim Balasan
                        </button>
                    </div>
                </form>

            </div>
        </div>

        {{-- RIGHT: META --}}
        <div class="bg-white rounded-xl shadow-sm p-6 text-sm">
            <h3 class="font-semibold text-gray-700 mb-4">
                Informasi Ticket
            </h3>

            <div class="space-y-3 text-gray-600">
                <div>
                    <span class="text-gray-400">Status</span>
                    <div class="font-medium">
                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                    </div>
                </div>

                <div>
                    <span class="text-gray-400">Dibuat oleh</span>
                    <div class="font-medium">
                        {{ $ticket->user->name ?? '-' }}
                    </div>
                </div>

                <div>
                    <span class="text-gray-400">Tanggal</span>
                    <div class="font-medium">
                        {{ $ticket->created_at->format('d M Y H:i') }}
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
