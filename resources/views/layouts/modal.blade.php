{{-- Modal Confirm Logout --}}
<x-modal name="confirm-logout">
    <div class="p-6">
        <div class="flex items-center gap-3 mb-4">

            <h2 class="text-lg font-semibold">
                Konfirmasi Logout
            </h2>
        </div>

        <p class="text-m text-gray-600 mb-6">
            Apakah kamu yakin ingin keluar dari aplikasi?
        </p>

        <div class="flex justify-end gap-2">
            <button type="button" x-on:click="$dispatch('close-modal', 'confirm-logout')"
                class="px-4 py-2 text-gray-600 rounded-lg border hover:bg-gray-100">
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


{{-- Modal detail unit --}}
<x-modal name="detail-unit" maxWidth="md">
    <div x-data="unitDetail()" x-on:open-detail.window="open($event.detail)" class="p-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Detail Unit</h2>
            <button @click="$dispatch('close-modal','detail-unit')" class="text-gray-500">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- FORM -->
        <div class="space-y-4">
            <div>
                <label class="text-sm text-gray-600">Nama</label>
                <input type="text" x-model="name" :disabled="!editMode" class="w-full border rounded-lg p-2 mt-1">
            </div>

            <div>
                <label class="text-sm text-gray-600">Deskripsi</label>
                <textarea x-model="description" :disabled="!editMode" class="w-full border rounded-lg p-2 mt-1"></textarea>
            </div>
        </div>

        <!-- ACTION -->
        <div class="flex justify-between mt-6">
            <button @click="confirmDelete()" class="text-red-600 text-sm">
                Delete
            </button>

            <div class="flex gap-2">
                <button x-show="!editMode" @click="editMode=true" class="px-4 py-2 border rounded-lg">
                    Edit
                </button>

                <button x-show="editMode" @click="save()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
                    Save
                </button>
            </div>
        </div>
    </div>
</x-modal>


{{-- modal confirm delete unit --}}
<x-modal name="confirm-delete" maxWidth="sm">
    <div class="p-6 text-center" x-data="deleteUnit()">
        <h2 class="text-lg font-semibold mb-3">Hapus Unit?</h2>
        <p class="text-sm text-gray-500 mb-6">
            Data yang dihapus tidak bisa dikembalikan.
        </p>

        <div class="flex justify-center gap-3">
            <button @click="$dispatch('close-modal','confirm-delete')" class="px-4 py-2 border rounded-lg">
                Batal
            </button>

            <button @click="remove()" class="bg-red-600 text-white px-4 py-2 rounded-lg">
                Delete
            </button>
        </div>
    </div>
</x-modal>

{{-- Modal Create Unit --}}
<x-modal name="create-unit" maxWidth="md">
    <div class="p-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Tambah Unit</h2>
            <button x-on:click="$dispatch('close-modal','create-unit')" class="text-gray-500">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('units.store') }}">
            @csrf

            <div class="mb-3">
                <label class="text-sm text-gray-600">Nama Unit</label>
                <input type="text" name="name" class="w-full mt-1 border rounded-lg p-2" required>
            </div>

            <div class="mb-3">
                <label class="text-sm text-gray-600">Deskripsi</label>
                <textarea name="description" class="w-full mt-1 border rounded-lg p-2"></textarea>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" x-on:click="$dispatch('close-modal','create-unit')"
                    class="px-4 py-2 border rounded-lg">
                    Batal
                </button>

                <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
                    Simpan
                </button>
            </div>
        </form>

    </div>
</x-modal>
