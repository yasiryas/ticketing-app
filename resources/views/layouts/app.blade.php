<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body x-data="{ sidebarOpen: true }" class="bg-gray-100">

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




</body>

</html>
