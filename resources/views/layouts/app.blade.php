<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
</head>

<body x-data="{
    sidebarOpen: localStorage.getItem('sidebarOpen') === 'true' ? true : false,

    toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
        localStorage.setItem('sidebarOpen', this.sidebarOpen);
    }
}" class="bg-gray-100">


    <div class="flex min-h-screen">

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Content -->
        <main class="flex-1">
            <!-- Topbar (mobile) -->
            <div class="md:hidden bg-white p-4 shadow">
                <h1 class="font-bold text-indigo-600">🎫 Ticketing</h1>
            </div>

            <!-- Page Content -->
            <div class="p-6">
                {{ $slot }}
            </div>
        </main>

    </div>

    <!-- assets -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Toast Component -->
    <div x-data="toastComponent()" x-init="init()" x-show="show" x-transition x-cloak
        class="fixed top-6 left-1/2 -translate-x-1/2 z-[9999]">
        <div :class="typeClasses"
            class="px-6 py-3 rounded-xl shadow-xl backdrop-blur-lg border text-white font-medium min-w-[250px] text-center">
            <span x-text="message"></span>
        </div>
    </div>

    <script>
        function toastComponent() {
            return {
                show: false,
                message: '',
                type: 'success',

                get typeClasses() {
                    return {
                        'bg-green-500/70 border-green-300/40': this.type === 'success',
                        'bg-red-500/70 border-red-300/40': this.type === 'error',
                        'bg-yellow-500/70 border-yellow-300/40': this.type === 'warning',
                        'bg-indigo-500/70 border-indigo-300/40': this.type === 'info',
                    }
                },

                init() {
                    // FROM JS EVENT (fetch/AJAX)
                    window.addEventListener('toast', e => {
                        if (typeof e.detail === 'string') {
                            this.showToast(e.detail, 'success');
                        } else {
                            this.showToast(e.detail.message, e.detail.type ?? 'success');
                        }
                    });
                },

                showToast(msg, type = 'success') {
                    this.message = msg;
                    this.type = type;
                    this.show = true;

                    setTimeout(() => this.show = false, 3000);
                }
            }
        }
    </script>

    {{-- modals --}}

</body>

</html>
