<x-app-layout>
    @php
        $currentUserId = Auth::check() ? Auth::id() : null;
        $isAdmin = Auth::check() && Auth::user()->isAdmin();
    @endphp

    <script>
        window.currentUserId = {{ $currentUserId }};
        window.isAdmin = {{ $isAdmin ? 'true' : 'false' }};
    </script>

    <div x-data="ticketBoard" x-init="init()" @refresh-tickets.window="fetchTickets()">
        <div class="flex justify-between mb-6">
            <h1 class="text-2xl font-bold">Ticket Board</h1>

            <button @click="$dispatch('open-modal', 'create-ticket')"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow">
                + Create Ticket
            </button>
        </div>
        <div class="grid grid-cols-3 gap-6">

            <!-- OPEN -->
            <div>
                <h2 class="font-semibold mb-4 text-blue-600">Open</h2>

                <template x-for="ticket in open" :key="ticket.id">
                    <div class="bg-white p-4 rounded-xl shadow mb-4 relative group">
                        <h3 class="font-semibold" x-text="ticket.title"></h3>
                        <p class="text-sm text-gray-500">
                            <span x-text="ticket.unit ? ticket.unit.name : '-'"></span>
                            <span class="text-gray-400">•</span>
                            <span x-text="ticket.user ? ticket.user.name : '-'"></span>
                        </p>
                        <div class="mt-2 flex gap-2 items-center justify-center">
                            <!-- Left Arrow - Move to previous status -->
                            <button @click="moveTicketLeft(ticket)"
                                x-show="ticket.status !== 'open' && (isAdmin || ticket.user_id === currentUserId)"
                                class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors"
                                title="Kembalikan ke status sebelumnya">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <!-- Detail Button -->
                            <button @click="openDetail(ticket)"
                                class="px-3 py-1.5 text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-150 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Detail
                            </button>

                            <!-- Right Arrow - Move to next status -->
                            <button @click="moveTicketRight(ticket)"
                                x-show="isAdmin || ticket.user_id === currentUserId"
                                class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors"
                                title="Pindahkan ke status berikutnya">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- PROGRESS -->
            <div>
                <h2 class="font-semibold mb-4 text-yellow-600">Progress</h2>

                <template x-for="ticket in progress" :key="ticket.id">
                    <div class="bg-white p-4 rounded-xl shadow mb-4 relative group">
                        <h3 class="font-semibold" x-text="ticket.title"></h3>
                        <p class="text-sm text-gray-500">
                            <span x-text="ticket.unit ? ticket.unit.name : '-'"></span>
                            <span class="text-gray-400">•</span>
                            <span x-text="ticket.user ? ticket.user.name : '-'"></span>
                        </p>
                        <div class="mt-2 flex gap-2 items-center justify-center">
                            <!-- Left Arrow -->
                            <button @click="moveTicketLeft(ticket)"
                                x-show="ticket.status !== 'open' && (isAdmin || ticket.user_id === currentUserId)"
                                class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors"
                                title="Kembalikan ke status sebelumnya">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <!-- Detail Button -->
                            <button @click="openDetail(ticket)"
                                class="px-3 py-1.5 text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-150 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Detail
                            </button>

                            <!-- Right Arrow -->
                            <button @click="moveTicketRight(ticket)"
                                x-show="isAdmin || ticket.user_id === currentUserId"
                                class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors"
                                title="Pindahkan ke status berikutnya">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- CLOSED -->
            <div>
                <h2 class="font-semibold mb-4 text-green-600">Closed</h2>

                <template x-for="ticket in closed" :key="ticket.id">
                    <div class="bg-white p-4 rounded-xl shadow mb-4 opacity-70 relative group">
                        <h3 class="font-semibold" x-text="ticket.title"></h3>
                        <p class="text-sm text-gray-500">
                            <span x-text="ticket.unit ? ticket.unit.name : '-'"></span>
                            <span class="text-gray-400">•</span>
                            <span x-text="ticket.user ? ticket.user.name : '-'"></span>
                        </p>
                        <div class="mt-2 flex gap-2 items-center justify-center">
                            <!-- Left Arrow (only show for closed tickets to go back to in_progress) -->
                            <button @click="moveTicketLeft(ticket)"
                                x-show="isAdmin || ticket.user_id === currentUserId"
                                class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors"
                                title="Kembalikan ke status sebelumnya">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <!-- Detail Button -->
                            <button @click="openDetail(ticket)"
                                class="px-3 py-1.5 text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-150 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Detail
                            </button>

                            <!-- No Right Arrow for closed tickets -->
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Detail Modal -->
        <template x-teleport="body">
            <div x-show="showDetail" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4"
                x-cloak>
                <!-- Overlay -->
                <div class="fixed inset-0 bg-black bg-opacity-50" @click="closeDetail()"></div>

                <!-- Modal Content -->
                <div x-show="showDetail" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto"
                    @click.stop>
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold">Detail Ticket</h2>
                            <button @click="closeDetail()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Ticket Info -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Judul</label>
                                <p class="text-lg font-semibold" x-text="detailTicket?.title"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Deskripsi</label>
                                <p class="text-gray-700" x-text="detailTicket?.description"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Unit</label>
                                <p class="text-gray-700" x-text="detailTicket?.unit?.name || '-'"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Pembuat</label>
                                <p class="text-gray-700" x-text="detailTicket?.user?.name || '-'"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Status</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                    :class="{
                                        'bg-blue-100 text-blue-800': detailTicket?.status === 'open',
                                        'bg-yellow-100 text-yellow-800': detailTicket?.status === 'in_progress',
                                        'bg-green-100 text-green-800': detailTicket?.status === 'closed'
                                    }"
                                    x-text="detailTicket?.status === 'open' ? 'Open' : detailTicket?.status === 'in_progress' ? 'Progress' : 'Closed'">
                                </span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Dibuat</label>
                                <p class="text-gray-700 text-sm"
                                    x-text="detailTicket?.created_at ? new Date(detailTicket.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-'">
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons - Only show for admin or ticket owner with open status -->
                        <template
                            x-if="isAdmin || (detailTicket?.user_id === currentUserId && detailTicket?.status === 'open')">
                            <div class="mt-8 flex gap-3">
                                <button @click="editTicket(detailTicket); closeDetail()"
                                    class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </button>
                                <button @click="deleteTicket(detailTicket?.id); closeDetail()"
                                    class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </template>

                        <!-- Status Update Buttons - Only show for admin or ticket owner -->
                        <template x-if="isAdmin || detailTicket?.user_id === currentUserId">
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-500 mb-2">Update Status</label>
                                <div class="flex gap-2">
                                    <button @click="updateTicketStatus(detailTicket?.id, 'open')"
                                        class="flex-1 px-3 py-2 text-sm rounded-lg border transition-colors"
                                        :class="detailTicket?.status === 'open' ?
                                            'bg-blue-600 text-white border-blue-600' :
                                            'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'">
                                        Open
                                    </button>
                                    <button @click="updateTicketStatus(detailTicket?.id, 'in_progress')"
                                        class="flex-1 px-3 py-2 text-sm rounded-lg border transition-colors"
                                        :class="detailTicket?.status === 'in_progress' ?
                                            'bg-yellow-500 text-white border-yellow-500' :
                                            'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'">
                                        Progress
                                    </button>
                                    <button @click="updateTicketStatus(detailTicket?.id, 'closed')"
                                        class="flex-1 px-3 py-2 text-sm rounded-lg border transition-colors"
                                        :class="detailTicket?.status === 'closed' ?
                                            'bg-green-600 text-white border-green-600' :
                                            'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'">
                                        Closed
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-app-layout>
