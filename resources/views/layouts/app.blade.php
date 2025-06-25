<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Tailwind & JS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 min-h-screen">
    <div>
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-200 shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ url('/') }}" class="text-xl font-semibold text-gray-800">
                                {{ config('app.name', 'Laravel') }}
                            </a>
                        </div>

                        <!-- Desktop Nav -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            @auth
                                @if (Auth::user()->role == 'admin')
                                    <a href="{{ route('dashboard') }}"
                                        class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                                            {{ request()->routeIs('dashboard') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                                        Dashboard
                                    </a>
                                    <a href="{{ route('pemesanan.index') }}"
                                        class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                                            {{ request()->routeIs('pemesanan.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                                        Pemesanan
                                    </a>
                                    <a href="{{ route('kendaraan.index') }}"
                                        class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                                            {{ request()->routeIs('kendaraan.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                                        Kendaraan
                                    </a>
                                    <a href="{{ route('service.index') }}"
                                        class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                                            {{ request()->routeIs('service.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                                        Service
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}"
                                        class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                                            {{ request()->routeIs('dashboard') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                                        Dashboard
                                    </a>
                                    <a href="{{ route('approval.index') }}"
                                        class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                                            {{ request()->routeIs('approval.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                                        Approval
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Auth / Logout -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 focus:outline-none">
                                    Logout
                                </button>
                            </form>
                        @endauth
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none"
                            aria-expanded="false">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"
                                :class="{ 'hidden': open, 'inline-flex': !open }">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"
                                :class="{ 'hidden': !open, 'inline-flex': open }">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Nav -->
            <div class="sm:hidden" x-data="{ open: false }" x-show="open">
                <div class="pt-2 pb-3 space-y-1">
                    @auth
                        @if (Auth::user()->role == 'admin')
                            <a href="{{ route('dashboard') }}"
                                class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium
                                    {{ request()->routeIs('dashboard') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('pemesanan.index') }}"
                                class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium
                                    {{ request()->routeIs('pemesanan.*') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                                Pemesanan
                            </a>
                            <a href="{{ route('kendaraan.index') }}"
                                class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium
                                    {{ request()->routeIs('kendaraan.*') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                                Kendaraan
                            </a>
                            <a href="{{ route('service.index') }}"
                                class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium
                                    {{ request()->routeIs('service.*') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                                Service
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}"
                                class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium
                                    {{ request()->routeIs('dashboard') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('approval.index') }}"
                                class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium
                                    {{ request()->routeIs('approval.*') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                                Approval
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left pl-3 pr-4 py-2 border-l-4 text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Alpine.js for toggling hamburger menu -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>
