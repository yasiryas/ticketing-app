<!-- Sidebar -->
<aside :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="bg-white border-r hidden md:flex flex-col transition-all duration-300">

    <!-- Brand -->
    <div class="px-7 py-5 border-b flex item-left justify-between">
        <div x-show="sidebarOpen" class="flex items-center gap-2">
            <x-application-logo class="w-8 h-8 text-indigo-600" />
            <div class="flex flex-col">
                <h1 class="text-xl font-bold text-indigo-600">
                    Ticketing
                </h1>
                <p class="text-xs text-gray-500">System Support</p>
            </div>
        </div>

        <!-- Toggle -->
        <button @click="toggleSidebar" class="px-1 py-3 text-gray-600 hover:text-gray-500 hover:text-indigo-600">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <!-- Menu -->
    <nav class="flex-1 px-3 py-6 space-y-1 text-sm">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" title="Dashboard"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition
           {{ request()->routeIs('dashboard')
               ? 'bg-indigo-50 text-indigo-600 font-semibold'
               : 'text-gray-600 hover:bg-gray-100' }}">

            <i class="fa-solid fa-chart-line w-5 text-center"></i>
            <span x-show="sidebarOpen">Dashboard</span>
        </a>

        <!-- Tickets -->
        <a href="{{ route('tickets.index') }}" title="Tickets"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition
           {{ request()->routeIs('tickets.*')
               ? 'bg-indigo-50 text-indigo-600 font-semibold'
               : 'text-gray-600 hover:bg-gray-100' }}">

            <i class="fa-solid fa-ticket-simple w-5 text-center"></i>
            <span x-show="sidebarOpen">Tickets</span>
        </a>

        <!-- Units - Admin Only -->
        @if (auth()->user()->isAdmin())
            <a href="{{ route('units.index') }}" title="Units"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition
           {{ request()->routeIs('units.*')
               ? 'bg-indigo-50 text-indigo-600 font-semibold'
               : 'text-gray-600 hover:bg-gray-100' }}">

                <i class="fa-solid fa-building w-5 text-center"></i>
                <span x-show="sidebarOpen">Units</span>
            </a>

            <!-- Users - Admin Only -->
            <a href="{{ route('users.index') }}" title="Users"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition
           {{ request()->routeIs('users.*')
               ? 'bg-indigo-50 text-indigo-600 font-semibold'
               : 'text-gray-600 hover:bg-gray-100' }}">

                <i class="fa-solid fa-users w-5 text-center"></i>
                <span x-show="sidebarOpen">Users</span>
            </a>
        @endif

        <!-- Profile - All Users -->
        <a href="{{ route('profile.edit') }}" title="Profile"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition
           {{ request()->routeIs('profile.edit')
               ? 'bg-indigo-50 text-indigo-600 font-semibold'
               : 'text-gray-600 hover:bg-gray-100' }}">

            <i class="fa-solid fa-user w-5 text-center"></i>
            <span x-show="sidebarOpen">Profile</span>
        </a>
    </nav>

    <!-- User -->
    <div class="px-4 py-4 border-t text-sm">

        <div class="flex items-center gap-3 px-4 py-3 rounded-lg mb-3">
            <i class="fa-solid fa-user-circle text-xl text-gray-400"></i>
            <div x-show="sidebarOpen" class="flex-1 min-w-0">
                <p class="font-semibold truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">
                    {{ auth()->user()->isAdmin() ? 'Admin' : 'User' }}
                </p>
            </div>
        </div>

        <button x-data x-on:click="$dispatch('open-modal','confirm-logout')"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition bg-indigo-50  text-gray-600 hover:text-white hover:bg-indigo-600 w-full">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span x-show="sidebarOpen">Logout</span>
        </button>
    </div>
</aside>


@include('layouts.modal')
