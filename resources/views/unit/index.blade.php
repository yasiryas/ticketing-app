<x-app-layout>
    <div class="max-w-7xl mx-auto p-6" x-data="unitTable()" x-init="fetchData()">

        <!-- HEADER -->
        <div class="flex justify-between mb-6 items-center">
            <h1 class="text-2xl font-bold">Unit</h1>

            <div class="flex gap-3">
                <!-- SEARCH -->
                <input type="text" placeholder="Cari unit..."
                    class="border rounded-lg px-4 py-2 text-sm w-64 focus:ring-2 focus:ring-indigo-200"
                    x-model.debounce.400ms="search" @input="fetchData()">

                <button x-data x-on:click="$dispatch('open-modal', 'create-unit')"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow">
                    + Tambah Unit
                </button>
            </div>
        </div>

        <!-- TABLE -->
        <div class="bg-white shadow-sm rounded-xl overflow-hidden">

            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="p-4 text-left">Nama Unit</th>
                        <th class="p-4 text-left">Deskripsi</th>
                        <th class="p-4 text-left w-40">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <!-- LOADING -->
                    <template x-if="loading">
                        <tr>
                            <td colspan="3" class="p-6 text-center text-gray-400">
                                Loading...
                            </td>
                        </tr>
                    </template>

                    <!-- DATA -->
                    <template x-for="unit in units" :key="unit.id">
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="p-4 font-medium" x-text="unit.name"></td>
                            <td class="p-4 text-gray-600" x-text="unit.description ?? '-'"></td>
                            <td class="p-4">
                                <a :href="`/units/${unit.id}`"
                                    class="bg-gray-500 hover:bg-gray-600 text-white text-xs px-3 py-1.5 rounded-lg">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    </template>

                    <!-- EMPTY STATE -->
                    <template x-if="!loading && units.length === 0">
                        <tr>
                            <td colspan="3" class="p-10 text-center text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fa-solid fa-box-open text-3xl"></i>
                                    <span>Tidak ada unit ditemukan</span>
                                </div>
                            </td>
                        </tr>
                    </template>

                </tbody>
            </table>

            <!-- FOOTER -->
            <div class="flex justify-between items-center p-4 border-t text-sm bg-gray-50">

                <div class="text-gray-600">
                    Showing
                    <span class="font-semibold" x-text="from"></span>
                    -
                    <span class="font-semibold" x-text="to"></span>
                    of
                    <span class="font-semibold" x-text="total"></span>
                </div>

                <div class="flex gap-2">
                    <button class="px-3 py-1 border rounded-lg hover:bg-gray-100" :disabled="!prevPage"
                        @click="fetchData(prevPage)">
                        Prev
                    </button>

                    <button class="px-3 py-1 border rounded-lg hover:bg-gray-100" :disabled="!nextPage"
                        @click="fetchData(nextPage)">
                        Next
                    </button>
                </div>

            </div>
        </div>
    </div>
    <script>
        function unitTable() {
            return {
                search: '',
                units: [],
                loading: false,
                total: 0,
                from: 0,
                to: 0,
                nextPage: null,
                prevPage: null,

                fetchData(url = '{{ route('units.data') }}') {
                    this.loading = true;

                    let fullUrl = url.includes('?') ?
                        url + '&search=' + this.search :
                        url + '?search=' + this.search;

                    fetch(fullUrl)
                        .then(res => res.json())
                        .then(data => {
                            this.units = data.data;
                            this.total = data.total;
                            this.from = data.from ?? 0;
                            this.to = data.to ?? 0;
                            this.nextPage = data.next_page_url;
                            this.prevPage = data.prev_page_url;
                            this.loading = false;
                        });
                }
            }
        }
    </script>


</x-app-layout>
