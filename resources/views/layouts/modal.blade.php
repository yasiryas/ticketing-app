{{-- Modal Confirm Logout --}}
<x-modal name="confirm-logout" maxWidth="sm">
    <div class="p-6">
        <h2 class="text-lg font-semibold mb-4">
            Konfirmasi Logout
        </h2>

        <p class="text-gray-600 mb-6">
            Apakah kamu yakin ingin keluar dari aplikasi?
        </p>

        <div class="flex justify-end gap-2">
            <button type="button" @click="$dispatch('close-modal', 'confirm-logout')"
                class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                Batal
            </button>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                    Ya, Logout
                </button>
            </form>
        </div>
    </div>
</x-modal>

{{-- create ticket --}}
<x-modal name="create-ticket" maxWidth="md">
    <div x-data="{
        ...ticketBoard(),
        unitSearch: '',
        unitDropdownOpen: false,
        get filteredUnits() {
            const units = @js(\App\Models\Unit::all());
            if (!this.unitSearch) return units;
            return units.filter(u => u.name.toLowerCase().includes(this.unitSearch.toLowerCase()));
        },
        get selectedUnitName() {
            const unit = @js(\App\Models\Unit::all()).find(u => u.id == this.form.unit_id);
            return unit ? unit.name : 'Pilih Unit';
        }
    }" @click.outside="unitDropdownOpen = false" class="p-6">
        <h2 class="text-lg font-semibold mb-4">
            Create Ticket
        </h2>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
            <div class="relative">
                <button type="button" @click="unitDropdownOpen = !unitDropdownOpen"
                    class="w-full border rounded-lg px-4 py-2.5 text-left flex justify-between items-center bg-white hover:bg-gray-50 transition-colors">
                    <span x-text="selectedUnitName" :class="form.unit_id ? 'text-gray-900' : 'text-gray-400'"></span>
                    <svg class="w-5 h-5 text-gray-400 transition-transform"
                        :class="unitDropdownOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="unitDropdownOpen" x-transition.origin-top.duration-200ms
                    class="absolute z-[9999] w-full mt-1 bg-white border rounded-lg shadow-xl max-h-60 overflow-visible"
                    style="display: none;">
                    <div class="p-2 border-b bg-gray-50">
                        <div class="relative">
                            <svg class="w-4 h-4 absolute left-3 top-3 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35m1.85-5.65a7.5 7.5 0 11-15 0a7.5 7.5 0 0115 0z" />
                            </svg>
                            <input type="text" x-model="unitSearch" placeholder="Cari unit..." autofocus
                                class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:outline-none">
                        </div>
                    </div>
                    <div class="overflow-y-auto max-h-40">
                        <template x-for="unit in filteredUnits" :key="unit.id">
                            <button type="button"
                                @click="form.unit_id = unit.id; unitDropdownOpen = false; unitSearch = ''"
                                class="w-full px-4 py-2.5 text-left hover:bg-indigo-50 transition-colors flex items-center justify-between"
                                :class="form.unit_id == unit.id ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700'">
                                <span x-text="unit.name" class="font-medium"></span>
                                <svg x-show="form.unit_id == unit.id" class="w-4 h-4 text-indigo-600"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </template>
                        <div x-show="filteredUnits.length === 0" class="px-4 py-3 text-gray-500 text-sm text-center">
                            Unit tidak ditemukan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="text" placeholder="Judul Ticket" class="w-full border rounded-lg px-4 py-2 mb-3"
            x-model="form.title">

        <textarea placeholder="Deskripsi" class="w-full border rounded-lg px-4 py-2 mb-3" x-model="form.description"></textarea>

        <div class="flex justify-end gap-2">
            <button @click="$dispatch('close-modal', 'create-ticket')"
                class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                Cancel
            </button>

            <button @click="$dispatch('ticket-create')"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Save
            </button>
        </div>
    </div>
</x-modal>

{{-- edit ticket --}}
<x-modal name="edit-ticket" maxWidth="md">
    <div x-data="{
        unitSearch: '',
        unitDropdownOpen: false,
        get filteredUnits() {
            const units = @js(\App\Models\Unit::all());
            if (!this.unitSearch) return units;
            return units.filter(u => u.name.toLowerCase().includes(this.unitSearch.toLowerCase()));
        },
        get selectedUnitName() {
            const unit = @js(\App\Models\Unit::all()).find(u => u.id == this.form.unit_id);
            return unit ? unit.name : 'Pilih Unit';
        },
        init() {
            this.form = window.editForm || { id: '', title: '', description: '', unit_id: '', status: '' }
            const self = this
            window.addEventListener('open-edit-modal', function() {
                self.form = window.editForm || { id: '', title: '', description: '', unit_id: '', status: '' }
            })
        }
    }" @click.outside="unitDropdownOpen = false" class="p-6">
        <h2 class="text-lg font-semibold mb-4">
            Edit Ticket
        </h2>

        <input type="hidden" x-model="form.id">

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
            <div class="relative">
                <button type="button" @click="unitDropdownOpen = !unitDropdownOpen"
                    class="w-full border rounded-lg px-4 py-2.5 text-left flex justify-between items-center bg-white hover:bg-gray-50 transition-colors">
                    <span x-text="selectedUnitName" :class="form.unit_id ? 'text-gray-900' : 'text-gray-400'"></span>
                    <svg class="w-5 h-5 text-gray-400 transition-transform"
                        :class="unitDropdownOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="unitDropdownOpen" x-transition.origin-top.duration-200ms
                    class="absolute z-[9999] w-full mt-1 bg-white border rounded-lg shadow-xl max-h-60 overflow-visible"
                    style="display: none;">
                    <div class="p-2 border-b bg-gray-50">
                        <div class="relative">
                            <svg class="w-4 h-4 absolute left-3 top-3 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35m1.85-5.65a7.5 7.5 0 11-15 0a7.5 7.5 0 0115 0z" />
                            </svg>
                            <input type="text" x-model="unitSearch" placeholder="Cari unit..." autofocus
                                class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:outline-none">
                        </div>
                    </div>
                    <div class="overflow-y-auto max-h-40">
                        <template x-for="unit in filteredUnits" :key="unit.id">
                            <button type="button"
                                @click="form.unit_id = unit.id; unitDropdownOpen = false; unitSearch = ''"
                                class="w-full px-4 py-2.5 text-left hover:bg-indigo-50 transition-colors flex items-center justify-between"
                                :class="form.unit_id == unit.id ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700'">
                                <span x-text="unit.name" class="font-medium"></span>
                                <svg x-show="form.unit_id == unit.id" class="w-4 h-4 text-indigo-600"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </template>
                        <div x-show="filteredUnits.length === 0" class="px-4 py-3 text-gray-500 text-sm text-center">
                            Unit tidak ditemukan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="text" placeholder="Judul Ticket" class="w-full border rounded-lg px-4 py-2 mb-3"
            x-model="form.title">

        <textarea placeholder="Deskripsi" class="w-full border rounded-lg px-4 py-2 mb-3" x-model="form.description"></textarea>

        <select class="w-full border rounded-lg px-4 py-2 mb-4" x-model="form.status">
            <option value="open">Open</option>
            <option value="in_progress">Progress</option>
            <option value="closed">Closed</option>
        </select>

        <div class="flex justify-end gap-2">
            <button @click="$dispatch('close-modal', 'edit-ticket')"
                class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                Cancel
            </button>

            <button @click="window.dispatchEvent(new CustomEvent('ticket-update'))"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Update
            </button>
        </div>
    </div>
</x-modal>

{{-- delete ticket confirmation --}}
<x-modal name="confirm-delete-ticket" maxWidth="sm">
    <div class="p-6">
        <h2 class="text-lg font-semibold mb-4">
            Konfirmasi Hapus Ticket
        </h2>

        <p class="text-gray-600 mb-6">
            Apakah kamu yakin ingin menghapus ticket ini?
        </p>

        <div class="flex justify-end gap-2">
            <button @click="$dispatch('close-modal', 'confirm-delete-ticket')"
                class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                Batal
            </button>

            <button @click="handleDeleteConfirm()"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Hapus
            </button>
        </div>
    </div>
    <script>
        function handleDeleteConfirm() {
            const id = window.deleteTicketId
            fetch(`/tickets/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(async res => {
                    if (res.redirected) {
                        window.dispatchEvent(new CustomEvent('toast', {
                            detail: 'Ticket berhasil dihapus!',
                            type: 'success'
                        }))
                        window.dispatchEvent(new CustomEvent('refresh-tickets'))
                        window.dispatchEvent(new CustomEvent('close-modal', {
                            detail: 'confirm-delete-ticket'
                        }))
                        return
                    }

                    const data = await res.json().catch(() => ({}))
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: data.message || 'Ticket berhasil dihapus!',
                        type: 'success'
                    }))
                    window.dispatchEvent(new CustomEvent('refresh-tickets'))
                    window.dispatchEvent(new CustomEvent('close-modal', {
                        detail: 'confirm-delete-ticket'
                    }))
                })
                .catch(() => {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: 'Gagal menghapus ticket',
                        type: 'error'
                    }))
                })
        }
    </script>
</x-modal>
