<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r hidden md:flex flex-col">
            <div class="px-6 py-5 border-b">
                <h1 class="text-xl font-bold text-indigo-600">🎫 Ticketing</h1>
                <p class="text-xs text-gray-500">Support System</p>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 text-sm">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg
               {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    📊 Dashboard
                </a>

                <a href="{{ route('tickets.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg
               {{ request()->routeIs('tickets.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    🎫 Tickets
                </a>
            </nav>

            <!-- User -->
            <div class="px-6 py-4 border-t">
                <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>

                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button class="text-red-500 text-sm hover:underline">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

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

</body>

</html>
