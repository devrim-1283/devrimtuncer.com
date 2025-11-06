<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Panel') - Devrim Tuncer</title>
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white">
            <div class="p-4">
                <h1 class="text-xl font-bold">Admin Panel</h1>
            </div>
            <nav class="mt-8">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('admin.blogs.index') }}" class="block px-4 py-2 hover:bg-gray-700">Blogs</a>
                <a href="{{ route('admin.portfolios.index') }}" class="block px-4 py-2 hover:bg-gray-700">Portfolios</a>
                <a href="{{ route('admin.slides.index') }}" class="block px-4 py-2 hover:bg-gray-700">Slides</a>
                <a href="{{ route('admin.galleries.index') }}" class="block px-4 py-2 hover:bg-gray-700">Gallery</a>
                <a href="{{ route('admin.messages.index') }}" class="block px-4 py-2 hover:bg-gray-700">Messages</a>
                <a href="{{ route('admin.statistics.index') }}" class="block px-4 py-2 hover:bg-gray-700">Statistics</a>
                <a href="{{ route('admin.settings.index') }}" class="block px-4 py-2 hover:bg-gray-700">Settings</a>
                <a href="{{ route('admin.audit-logs.index') }}" class="block px-4 py-2 hover:bg-gray-700">Audit Logs</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <header class="bg-white shadow-sm">
                <div class="px-6 py-4 flex justify-between items-center">
                    <h2 class="text-2xl font-semibold">@yield('page-title', 'Dashboard')</h2>
                    <div class="flex items-center space-x-4">
                        <span>{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>

