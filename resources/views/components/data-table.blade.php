<div>
    @props(['id', 'ajax', 'columns' => []])

    <div class="bg-white rounded-2xl shadow border border-gray-100 p-6">

        <!-- TOP BAR -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

            <!-- SEARCH -->
            <div class="relative w-full md:w-72">
                <input type="text" id="{{ $id }}-search" placeholder="Cari data..."
                    class="w-full border rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-200">

                <svg class="w-4 h-4 absolute right-3 top-3 text-gray-400" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m1.85-5.65a7.5 7.5 0 11-15 0a7.5 7.5 0 0115 0z" />
                </svg>
            </div>

            <!-- LENGTH -->
            {{-- <div>
                <select id="{{ $id }}-length" class="border rounded-xl px-3 py-2 text-sm">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div> --}}

        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">
            <table id="{{ $id }}" class="min-w-full text-sm">
                <thead>
                    <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                        @foreach ($columns as $col)
                            <th class="px-6 py-4 text-left">
                                <div class="flex items-center gap-2">
                                    <span>{{ $col['label'] }}</span>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
            </table>
        </div>

        <!-- FOOTER -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mt-6 gap-4">

            <!-- INFO -->
            <div id="{{ $id }}-info" class="text-sm text-gray-500">
            </div>

            <!-- PAGINATION -->
            <div id="{{ $id }}-pagination" class="flex items-center gap-1">
            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let table = $('#{{ $id }}').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ $ajax }}",
                dom: 'rt', // remove default UI
                pageLength: 10,

                columns: @json($columns),

                drawCallback: function(settings) {

                    let info = table.page.info();

                    // INFO TEXT
                    document.getElementById('{{ $id }}-info').innerHTML =
                        `Menampilkan ${info.start + 1} - ${info.end} dari ${info.recordsTotal} data`;

                    // CUSTOM PAGINATION
                    let pagination = '';

                    if (info.pages > 1) {

                        if (info.page > 0) {
                            pagination += `<button onclick="table.prev()"
                        class="px-3 py-1 text-sm border rounded-lg hover:bg-gray-100">
                        Prev
                    </button>`;
                        }

                        for (let i = 0; i < info.pages; i++) {
                            pagination += `<button onclick="table.page(${i}).draw('page')"
                        class="px-3 py-1 text-sm border rounded-lg
                        ${i === info.page ? 'bg-indigo-600 text-white border-indigo-600' : 'hover:bg-gray-100'}">
                        ${i + 1}
                    </button>`;
                        }

                        if (info.page < info.pages - 1) {
                            pagination += `<button onclick="table.next()"
                        class="px-3 py-1 text-sm border rounded-lg hover:bg-gray-100">
                        Next
                    </button>`;
                        }
                    }

                    document.getElementById('{{ $id }}-pagination').innerHTML = pagination;
                }
            });

            // SEARCH
            $('#{{ $id }}-search').on('keyup', function() {
                table.search(this.value).draw();
            });

            // LENGTH
            $('#{{ $id }}-length').on('change', function() {
                table.page.len(this.value).draw();
            });

            window['{{ $id }}Reload'] = function() {
                table.ajax.reload(null, false);
            };
        });
    </script>
    <!-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger -->
</div>
