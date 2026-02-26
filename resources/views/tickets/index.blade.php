<x-app-layout>
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
                        <p class="text-sm text-gray-500" x-text="ticket.unit.name"></p>
                        <div class="mt-2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="editTicket(ticket)"
                                class="text-xs bg-indigo-600 text-white px-2 py-1 rounded hover:bg-indigo-700">Edit</button>
                            <button @click="deleteTicket(ticket.id)"
                                class="text-xs bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Delete</button>
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
                        <p class="text-sm text-gray-500" x-text="ticket.unit.name"></p>
                        <div class="mt-2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="editTicket(ticket)"
                                class="text-xs bg-indigo-600 text-white px-2 py-1 rounded hover:bg-indigo-700">Edit</button>
                            <button @click="deleteTicket(ticket.id)"
                                class="text-xs bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Delete</button>
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
                        <p class="text-sm text-gray-500" x-text="ticket.unit.name"></p>
                        <div class="mt-2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="editTicket(ticket)"
                                class="text-xs bg-indigo-600 text-white px-2 py-1 rounded hover:bg-indigo-700">Edit</button>
                            <button @click="deleteTicket(ticket.id)"
                                class="text-xs bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Delete</button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>
