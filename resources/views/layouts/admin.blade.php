<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Panel') - Devrim Tuncer</title>
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <style>
        @keyframes slideIn {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        .sidebar {
            animation: slideIn 0.3s ease-out;
        }
        .nav-item {
            position: relative;
            transition: all 0.3s ease;
        }
        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            transition: width 0.3s ease;
        }
        .nav-item:hover::before,
        .nav-item.active::before {
            width: 4px;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .stat-card.blue {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .stat-card.green {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .stat-card.purple {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .stat-card.orange {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        .mobile-menu-toggle {
            display: none;
        }
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }
            .sidebar {
                position: fixed;
                left: -100%;
                transition: left 0.3s ease;
                z-index: 50;
            }
            .sidebar.active {
                left: 0;
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 40;
            }
            .sidebar-overlay.active {
                display: block;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebarOverlay" class="sidebar-overlay"></div>

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white shadow-2xl">
            <div class="p-6 border-b border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                        <i class="fas fa-shield-alt text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">Admin Panel</h1>
                        <p class="text-xs text-gray-400">Devrim Tuncer</p>
                    </div>
                </div>
            </div>
            
            <nav class="mt-6 px-3">
                <a href="{{ route('admin.dashboard') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 active' : '' }}">
                    <i class="fas fa-home w-5 text-center"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('admin.blogs.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 hover:bg-gray-700 {{ request()->routeIs('admin.blogs.*') ? 'bg-gray-700 active' : '' }}">
                    <i class="fas fa-blog w-5 text-center"></i>
                    <span class="font-medium">Blogs</span>
                </a>
                <a href="{{ route('admin.portfolios.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 hover:bg-gray-700 {{ request()->routeIs('admin.portfolios.*') ? 'bg-gray-700 active' : '' }}">
                    <i class="fas fa-briefcase w-5 text-center"></i>
                    <span class="font-medium">Portfolios</span>
                </a>
                <a href="{{ route('admin.slides.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 hover:bg-gray-700 {{ request()->routeIs('admin.slides.*') ? 'bg-gray-700 active' : '' }}">
                    <i class="fas fa-images w-5 text-center"></i>
                    <span class="font-medium">Slides</span>
                </a>
                <a href="{{ route('admin.galleries.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 hover:bg-gray-700 {{ request()->routeIs('admin.galleries.*') ? 'bg-gray-700 active' : '' }}">
                    <i class="fas fa-photo-video w-5 text-center"></i>
                    <span class="font-medium">Gallery</span>
                </a>
                <a href="{{ route('admin.messages.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 hover:bg-gray-700 {{ request()->routeIs('admin.messages.*') ? 'bg-gray-700 active' : '' }}">
                    <i class="fas fa-envelope w-5 text-center"></i>
                    <span class="font-medium">Messages</span>
                    @php
                        $unreadCount = \App\Models\Message::where('is_read', false)->count();
                    @endphp
                    @if($unreadCount > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $unreadCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.statistics.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 hover:bg-gray-700 {{ request()->routeIs('admin.statistics.*') ? 'bg-gray-700 active' : '' }}">
                    <i class="fas fa-chart-line w-5 text-center"></i>
                    <span class="font-medium">Statistics</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 hover:bg-gray-700 {{ request()->routeIs('admin.settings.*') ? 'bg-gray-700 active' : '' }}">
                    <i class="fas fa-cog w-5 text-center"></i>
                    <span class="font-medium">Settings</span>
                </a>
                <a href="{{ route('admin.audit-logs.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 hover:bg-gray-700 {{ request()->routeIs('admin.audit-logs.*') ? 'bg-gray-700 active' : '' }}">
                    <i class="fas fa-history w-5 text-center"></i>
                    <span class="font-medium">Audit Logs</span>
                </a>
            </nav>

            <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-gray-700">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4 flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <button id="mobileMenuToggle" class="mobile-menu-toggle p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-bars text-gray-600"></i>
                        </button>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">@yield('page-title', 'Dashboard')</h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ now()->format('l, F j, Y') }}</p>
                        </div>
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <p class="text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            <p class="text-red-700 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Mobile Menu Toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        mobileMenuToggle?.addEventListener('click', function() {
            sidebar?.classList.toggle('active');
            sidebarOverlay?.classList.toggle('active');
        });

        sidebarOverlay?.addEventListener('click', function() {
            sidebar?.classList.remove('active');
            sidebarOverlay?.classList.remove('active');
        });

        // Close sidebar on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar?.classList.remove('active');
                sidebarOverlay?.classList.remove('active');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
