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
