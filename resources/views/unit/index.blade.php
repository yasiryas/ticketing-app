<x-app-layout>
    <div class="max-w-5xl mx-auto py-6">
        <div class="flex justify-between mb-4">
            <h2 class="text-lg font-semibold">Unit</h2>
            <a href="{{ route('units.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm">
                + Tambah Unit
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left">Nama Unit</th>
                        <th class="p-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($units as $unit)
                        <tr class="border-t">
                            <td class="p-3">{{ $unit->name }}</td>
                            <td class="p-3 text-right space-x-2">
                                <a href="{{ route('units.edit', $unit) }}" class="text-indigo-600 text-sm">
                                    Edit
                                </a>
                                <form action="{{ route('units.destroy', $unit) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 text-sm" onclick="return confirm('Hapus unit ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if ($units->isEmpty())
                        <tr>
                            <td colspan="2" class="p-4 text-center text-gray-400">
                                Belum ada unit
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
