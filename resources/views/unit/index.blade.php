<x-app-layout>
    <div class="max-w-5xl mx-auto py-6">
        <div class="flex justify-between mb-4">
            <h2 class="text-lg font-semibold">Unit</h2>
            <button x-data x-on:click="$dispatch('open-modal', 'create-unit')"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
                + Tambah Unit
            </button>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm">
            <x-table>
                <x-slot name="head">
                    <tr>
                        <th class="p-3 text-left">Nama Unit</th>
                        <th class="text-center">Deskripsi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </x-slot>
                <x-slot name="body">
                    @foreach ($units as $unit)
                        <tr class="border-t">
                            <td class="p-3">{{ $unit->name }}</td>
                            <td class="text-center">{{ $unit->description ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('units.show', $unit) }}" class="text-indigo-600 hover:underline">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>
        </div>
    </div>
</x-app-layout>

<!-- Modal -->
<x-modal name="create-unit">
    <div class="p-6">
        <div class="flex justify-between items-center ">
            <h2 class="text-lg font-semibold mb-2">Tambah Unit</h2>
            <button type="button" x-on:click="$dispatch('close-modal', 'create-unit')" class="px-4 py-2 text-gray-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('units.store') }}">
            @csrf

            <div class="mb-1">
                <label class="text-sm text-gray-600">Nama Unit</label>
                <input type="text" name="name" class="w-full mt-1 border rounded-lg p-2" required>
            </div>
            <div class="mb-1">
                <label class="text-sm  text-gray-600 mt-4">Deskripsi</label>
                <textarea name="description" class="w-full mt-1 border rounded-lg p-2" rows="4"></textarea>
            </div>

            <div class="mt-6 flex justify-end gap-2">
                <button type="button" x-on:click="$dispatch('close-modal', 'create-unit')"
                    class="px-4 py-2 text-gray-600 rounded-lg border">
                    Batal
                </button>

                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-modal>
