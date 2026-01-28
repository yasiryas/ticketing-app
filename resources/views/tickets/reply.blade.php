<x-app-layout>
    {{-- FLASH MESSAGE --}}
    @if (session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- REPLY THREAD --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mt-6">

        <h3 class="text-sm font-semibold text-gray-700 mb-4">
            Diskusi Ticket
        </h3>

        {{-- LIST REPLY --}}
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
</x-app-layout>
