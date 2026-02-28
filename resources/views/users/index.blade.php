<x-app-layout>
    <div x-data="userManager" x-init="init()" class="max-w-7xl mx-auto p-6">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Users</h1>

            <button @click="openCreateModal()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl shadow transition-colors duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah User
            </button>
        </div>

        <!-- CARD -->
        <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">

            <!-- TOOLBAR: Search & Filter -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <!-- SEARCH -->
                    <div class="relative w-full md:w-72">
                        <input type="text" x-model="search" @input="searchData()" placeholder="Cari user..."
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all">
                        <svg class="w-5 h-5 absolute right-3 top-3 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m1.85-5.65a7.5 7.5 0 11-15 0a7.5 7.5 0 0115 0z" />
                        </svg>
                    </div>

                    <!-- REFRESH BUTTON -->
                    <button @click="refreshTable()"
                        class="px-4 py-2 border border-gray-200 rounded-xl hover:bg-gray-50 text-gray-600 text-sm flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Refresh
                    </button>
                </div>
            </div>

            <!-- TABLE -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4 text-left">#</th>
                            <th class="px-6 py-4 text-left">Nama</th>
                            <th class="px-6 py-4 text-left">Email</th>
                            <th class="px-6 py-4 text-left">Role</th>
                            <th class="px-6 py-4 text-left">Dibuat</th>
                            <th class="px-6 py-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-if="loading">
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex justify-center items-center gap-2 text-gray-500">
                                        <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <span>Loading...</span>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template x-if="!loading && users.length === 0">
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p>Belum ada data user</p>
                                </td>
                            </tr>
                        </template>
                        <template x-for="(user, index) in users" :key="user.id">
                            <tr class="hover:bg-indigo-50/50 transition-colors duration-150">
                                <td class="px-6 py-4 text-gray-500" x-text="pagination.from + index"></td>
                                <td class="px-6 py-4">
                                    <span class="font-medium text-gray-800" x-text="user.name"></span>
                                </td>
                                <td class="px-6 py-4 text-gray-600" x-text="user.email"></td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full"
                                        :class="user.role === 'admin' ?
                                            'bg-purple-100 text-purple-700' :
                                            'bg-blue-100 text-blue-700'"
                                        x-text="user.role === 'admin' ? 'Admin' : 'User'"></span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-xs" x-text="formatDate(user.created_at)"></td>
                                <td class="px-6 py-4 text-left">
                                    <div class="flex gap-2">
                                        <button @click="editUser(user)"
                                            class="px-3 py-1.5 text-xs bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-lg transition-colors duration-150 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </button>

                                        <button @click="deleteUser(user.id)"
                                            class="px-3 py-1.5 text-xs bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors duration-150 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- FOOTER: Pagination -->
            <div
                class="px-6 py-4 border-t border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="text-sm text-gray-500">
                    Menampilkan <span x-text="pagination.from || 0"></span> - <span
                        x-text="pagination.to || 0"></span> dari <span x-text="pagination.total || 0"></span> data
                </div>
                <div class="flex items-center gap-1" x-html="paginationLinks"></div>
            </div>
        </div>

        <!-- MODAL CREATE -->
        <x-modal name="create-user" maxWidth="md">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-800">Tambah User Baru</h2>
                    <button x-on:click="$dispatch('close-modal','create-user')"
                        class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="storeUser()">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input type="text" x-model="form.name"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all"
                            required>
                        <p x-show="errors.name" class="text-red-500 text-xs mt-1" x-text="errors.name"></p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" x-model="form.email"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all"
                            required>
                        <p x-show="errors.email" class="text-red-500 text-xs mt-1" x-text="errors.email"></p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <div class="flex gap-2">
                            <button type="button" @click="form.role = 'user'"
                                :class="form.role === 'user' ?
                                    'bg-indigo-600 text-white border-indigo-600' :
                                    'bg-white text-gray-600 border-gray-200 hover:border-indigo-300'"
                                class="flex-1 py-2.5 px-4 border rounded-xl text-sm font-medium transition-all">
                                User
                            </button>
                            <button type="button" @click="form.role = 'admin'"
                                :class="form.role === 'admin' ?
                                    'bg-indigo-600 text-white border-indigo-600' :
                                    'bg-white text-gray-600 border-gray-200 hover:border-indigo-300'"
                                class="flex-1 py-2.5 px-4 border rounded-xl text-sm font-medium transition-all">
                                Admin
                            </button>
                        </div>
                        <p x-show="errors.role" class="text-red-500 text-xs mt-1" x-text="errors.role"></p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" x-model="form.password"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all"
                            required placeholder="Min. 8 karakter">
                        <p x-show="errors.password" class="text-red-500 text-xs mt-1" x-text="errors.password"></p>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" x-on:click="$dispatch('close-modal','create-user')"
                            class="px-4 py-2 border border-gray-200 rounded-xl hover:bg-gray-50 text-gray-700 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-colors disabled:opacity-50"
                            :disabled="saving">
                            <span x-show="!saving">Simpan</span>
                            <span x-show="saving" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </x-modal>

        <!-- MODAL EDIT -->
        <x-modal name="edit-user" maxWidth="md">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-800">Edit User</h2>
                    <button x-on:click="$dispatch('close-modal','edit-user')"
                        class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="updateUser()">
                    <input type="hidden" x-model="form.id">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input type="text" x-model="form.name"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all"
                            required>
                        <p x-show="errors.name" class="text-red-500 text-xs mt-1" x-text="errors.name"></p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" x-model="form.email"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all"
                            required>
                        <p x-show="errors.email" class="text-red-500 text-xs mt-1" x-text="errors.email"></p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <div class="flex gap-2">
                            <button type="button" @click="form.role = 'user'"
                                :class="form.role === 'user' ?
                                    'bg-indigo-600 text-white border-indigo-600' :
                                    'bg-white text-gray-600 border-gray-200 hover:border-indigo-300'"
                                class="flex-1 py-2.5 px-4 border rounded-xl text-sm font-medium transition-all">
                                User
                            </button>
                            <button type="button" @click="form.role = 'admin'"
                                :class="form.role === 'admin' ?
                                    'bg-indigo-600 text-white border-indigo-600' :
                                    'bg-white text-gray-600 border-gray-200 hover:border-indigo-300'"
                                class="flex-1 py-2.5 px-4 border rounded-xl text-sm font-medium transition-all">
                                Admin
                            </button>
                        </div>
                        <p x-show="errors.role" class="text-red-500 text-xs mt-1" x-text="errors.role"></p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Password <span class="text-gray-400 font-normal">(Kosongkan jika tidak diubah)</span>
                        </label>
                        <input type="password" x-model="form.password"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all"
                            placeholder="Min. 8 karakter">
                        <p x-show="errors.password" class="text-red-500 text-xs mt-1" x-text="errors.password"></p>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" x-on:click="$dispatch('close-modal','edit-user')"
                            class="px-4 py-2 border border-gray-200 rounded-xl hover:bg-gray-50 text-gray-700 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-colors disabled:opacity-50"
                            :disabled="saving">
                            <span x-show="!saving">Update</span>
                            <span x-show="saving" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Mengupdate...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </x-modal>

        <!-- MODAL DELETE CONFIRMATION -->
        <x-modal name="confirm-delete-user" maxWidth="sm">
            <div class="p-6 text-center">
                <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-red-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Hapus User?</h2>
                <p class="text-sm text-gray-500 mb-6">
                    Data yang dihapus tidak bisa dikembalikan. Yakin ingin menghapus <strong
                        x-text="deleteName"></strong>?
                </p>
                <div class="flex justify-center gap-3">
                    <button @click="$dispatch('close-modal','confirm-delete-user')"
                        class="px-4 py-2 border border-gray-200 rounded-xl hover:bg-gray-50 text-gray-700 transition-colors">
                        Batal
                    </button>
                    <button @click="confirmDelete()"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-colors disabled:opacity-50"
                        :disabled="deleting">
                        <span x-show="!deleting">Hapus</span>
                        <span x-show="deleting" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Menghapus...
                        </span>
                    </button>
                </div>
            </div>
        </x-modal>

    </div>

    <script>
        function userManager() {
            return {
                users: [],
                loading: false,
                saving: false,
                deleting: false,
                search: '',
                deleteId: null,
                deleteName: '',
                pagination: {
                    from: 0,
                    to: 0,
                    total: 0,
                    current_page: 1,
                    last_page: 1
                },
                paginationLinks: '',
                form: {
                    id: null,
                    name: '',
                    email: '',
                    role: 'user',
                    password: ''
                },
                errors: {},

                init() {
                    this.fetchData()
                },

                fetchData(url = '/users-data') {
                    this.loading = true
                    this.errors = {}

                    let fullUrl = url.includes('?') ?
                        url + '&search=' + this.search :
                        url + '?search=' + this.search

                    fetch(fullUrl, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.users = data.data || data
                            this.loading = false

                            // Handle pagination info
                            if (data.meta) {
                                this.pagination = {
                                    from: data.meta.from,
                                    to: data.meta.to,
                                    total: data.meta.total,
                                    current_page: data.meta.current_page,
                                    last_page: data.meta.last_page
                                }
                                this.paginationLinks = this.generatePaginationLinks(data.meta)
                            }
                        })
                        .catch(err => {
                            console.error('Error fetching data:', err)
                            this.loading = false
                        })
                },

                generatePaginationLinks(meta) {
                    let links = ''

                    // Previous
                    if (meta.current_page > 1) {
                        links +=
                            `<button @click="fetchData('${meta.path}?page=${meta.current_page - 1}')"
                            class="px-3 py-1.5 text-sm border rounded-lg hover:bg-gray-100 transition-colors">Prev</button>`
                    }

                    // Page numbers
                    for (let i = 1; i <= meta.last_page; i++) {
                        let active = i === meta.current_page ?
                            'bg-indigo-600 text-white border-indigo-600' :
                            'hover:bg-gray-100'
                        links += `<button @click="fetchData('${meta.path}?page=${i}')"
                            class="px-3 py-1.5 text-sm border rounded-lg ${active} transition-colors">${i}</button>`
                    }

                    // Next
                    if (meta.current_page < meta.last_page) {
                        links +=
                            `<button @click="fetchData('${meta.path}?page=${meta.current_page + 1}')"
                            class="px-3 py-1.5 text-sm border rounded-lg hover:bg-gray-100 transition-colors">Next</button>`
                    }

                    return links
                },

                searchData() {
                    this.fetchData()
                },

                refreshTable() {
                    this.fetchData()
                },

                formatDate(dateString) {
                    if (!dateString) return '-'
                    const date = new Date(dateString)
                    return date.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    })
                },

                openCreateModal() {
                    this.form = {
                        id: null,
                        name: '',
                        email: '',
                        role: 'user',
                        password: ''
                    }
                    this.errors = {}
                    window.dispatchEvent(new CustomEvent('open-modal', {
                        detail: 'create-user'
                    }))
                },

                editUser(user) {
                    this.form = {
                        id: user.id,
                        name: user.name,
                        email: user.email,
                        role: user.role,
                        password: ''
                    }
                    this.errors = {}
                    window.dispatchEvent(new CustomEvent('open-modal', {
                        detail: 'edit-user'
                    }))
                },

                storeUser() {
                    this.saving = true
                    this.errors = {}

                    fetch('/users', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                name: this.form.name,
                                email: this.form.email,
                                role: this.form.role,
                                password: this.form.password
                            })
                        })
                        .then(res => {
                            if (!res.ok) {
                                return res.json().then(err => Promise.reject(err));
                            }
                            return res.json();
                        })
                        .then(data => {
                            this.saving = false
                            window.dispatchEvent(new CustomEvent('close-modal', {
                                detail: 'create-user'
                            }))
                            this.fetchData()
                            this.showToast('success', 'User berhasil ditambahkan!')
                            this.form = {
                                id: null,
                                name: '',
                                email: '',
                                role: 'user',
                                password: ''
                            }
                        })
                        .catch(err => {
                            this.saving = false
                            if (err.errors) {
                                this.errors = err.errors
                            } else {
                                console.error('Error:', err)
                                this.showToast('error', 'Terjadi kesalahan!')
                            }
                        })
                },

                updateUser() {
                    this.saving = true
                    this.errors = {}

                    const data = {
                        name: this.form.name,
                        email: this.form.email,
                        role: this.form.role,
                    }

                    // Include password only if provided
                    if (this.form.password) {
                        data.password = this.form.password
                    }

                    fetch(`/users/${this.form.id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(data)
                        })
                        .then(res => {
                            if (!res.ok) {
                                return res.json().then(err => Promise.reject(err));
                            }
                            return res.json();
                        })
                        .then(data => {
                            this.saving = false
                            window.dispatchEvent(new CustomEvent('close-modal', {
                                detail: 'edit-user'
                            }))
                            this.fetchData()
                            this.showToast('success', 'User berhasil diupdate!')
                        })
                        .catch(err => {
                            this.saving = false
                            if (err.errors) {
                                this.errors = err.errors
                            } else {
                                console.error('Error:', err)
                                this.showToast('error', 'Terjadi kesalahan!')
                            }
                        })
                },

                deleteUser(id) {
                    const user = this.users.find(u => u.id === id)
                    this.deleteId = id
                    this.deleteName = user ? user.name : ''
                    window.dispatchEvent(new CustomEvent('open-modal', {
                        detail: 'confirm-delete-user'
                    }))
                },

                confirmDelete() {
                    this.deleting = true

                    fetch(`/users/${this.deleteId}`, {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(res => {
                            if (!res.ok) {
                                return res.json().then(err => Promise.reject(err));
                            }
                            return res.json();
                        })
                        .then(data => {
                            this.deleting = false
                            window.dispatchEvent(new CustomEvent('close-modal', {
                                detail: 'confirm-delete-user'
                            }))
                            this.fetchData()
                            this.showToast('success', 'User berhasil dihapus!')
                            this.deleteId = null
                            this.deleteName = ''
                        })
                        .catch(err => {
                            this.deleting = false
                            console.error('Error:', err)
                            this.showToast('error', err.message || 'Terjadi kesalahan!')
                        })
                },

                showToast(type, message) {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            message: message,
                            type: type
                        }
                    }))
                }
            }
        }
    </script>
</x-app-layout>
