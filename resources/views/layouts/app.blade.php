<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(config('app.env') === 'production' || str_starts_with(config('app.url'), 'https://'))
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
    
    <title>@yield('title', 'Devrim Tuncer')</title>
    
    @yield('meta')
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .language-dropdown {
            animation: slideDown 0.3s ease-out;
        }
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link:hover::after {
            width: 80%;
        }
        .flag-icon {
            width: 24px;
            height: 18px;
            border-radius: 2px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
            transition: transform 0.2s ease;
        }
        .flag-icon:hover {
            transform: scale(1.1);
        }
        .mobile-menu-toggle {
            display: none;
        }
        .hamburger {
            width: 24px;
            height: 20px;
            position: relative;
            transform: rotate(0deg);
            transition: .5s ease-in-out;
            cursor: pointer;
        }
        .hamburger span {
            display: block;
            position: absolute;
            height: 3px;
            width: 100%;
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            border-radius: 3px;
            opacity: 1;
            left: 0;
            transform: rotate(0deg);
            transition: .25s ease-in-out;
        }
        .hamburger span:nth-child(1) {
            top: 0px;
        }
        .hamburger span:nth-child(2) {
            top: 8px;
        }
        .hamburger span:nth-child(3) {
            top: 16px;
        }
        .hamburger.active span:nth-child(1) {
            top: 8px;
            transform: rotate(135deg);
        }
        .hamburger.active span:nth-child(2) {
            opacity: 0;
            left: -60px;
        }
        .hamburger.active span:nth-child(3) {
            top: 8px;
            transform: rotate(-135deg);
        }
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 40;
            animation: fadeIn 0.3s ease-out;
        }
        .mobile-overlay.active {
            display: block;
        }
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }
            .nav-menu {
                display: none;
                position: fixed;
                top: 0;
                right: -100%;
                width: 80%;
                max-width: 320px;
                height: 100vh;
                background: white;
                box-shadow: -4px 0 20px rgba(0,0,0,0.1);
                padding: 2rem 0;
                z-index: 50;
                transition: right 0.3s ease-out;
                overflow-y: auto;
            }
            .nav-menu.active {
                display: flex;
                flex-direction: column;
                right: 0;
                animation: slideInRight 0.3s ease-out;
            }
            .nav-menu a {
                padding: 1rem 1.5rem;
                border-left: 4px solid transparent;
                transition: all 0.3s ease;
            }
            .nav-menu a:hover,
            .nav-menu a.active {
                border-left-color: #3b82f6;
                background: linear-gradient(to right, #eff6ff, transparent);
            }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-lg sticky top-0 z-50 backdrop-blur-sm bg-white/95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="flex items-center space-x-2 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <span class="text-white font-bold text-lg">DT</span>
                        </div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent group-hover:from-blue-600 group-hover:to-blue-700 transition-all duration-300">Devrim Tuncer</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="nav-link px-4 py-2 text-sm font-semibold text-gray-700 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition-all duration-300 {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50' : '' }}">
                        {{ __('messages.home') }}
                    </a>
                    <a href="{{ route('blog.index', ['locale' => app()->getLocale()]) }}" class="nav-link px-4 py-2 text-sm font-semibold text-gray-700 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition-all duration-300 {{ request()->routeIs('blog.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                        {{ __('messages.blog') }}
                    </a>
                    <a href="{{ route('portfolio.index', ['locale' => app()->getLocale()]) }}" class="nav-link px-4 py-2 text-sm font-semibold text-gray-700 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition-all duration-300 {{ request()->routeIs('portfolio.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                        {{ __('messages.portfolio') }}
                    </a>
                    <a href="{{ route('tools.index', ['locale' => app()->getLocale()]) }}" class="nav-link px-4 py-2 text-sm font-semibold text-gray-700 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition-all duration-300 {{ request()->routeIs('tools.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                        {{ __('messages.tools') }}
                    </a>
                    <a href="{{ route('about.index', ['locale' => app()->getLocale()]) }}" class="nav-link px-4 py-2 text-sm font-semibold text-gray-700 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition-all duration-300 {{ request()->routeIs('about.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                        {{ __('messages.about') }}
                    </a>
                </div>

                <!-- Language Switcher & Mobile Menu -->
                <div class="flex items-center space-x-3">
                    <!-- Language Dropdown -->
                    <div class="relative group">
                        <button id="languageToggle" class="flex items-center space-x-2 px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            @if(app()->getLocale() === 'tr')
                            <span class="flag-icon" style="background: linear-gradient(to bottom, #E30A17 0%, #E30A17 33%, #FFFFFF 33%, #FFFFFF 66%, #E30A17 66%); display: inline-block; width: 24px; height: 18px; border-radius: 2px; box-shadow: 0 1px 3px rgba(0,0,0,0.2);"></span>
                            @else
                            <span class="flag-icon" style="background: linear-gradient(to bottom, #012169 0%, #012169 40%, #FFFFFF 40%, #FFFFFF 60%, #C8102E 60%); display: inline-block; width: 24px; height: 18px; border-radius: 2px; box-shadow: 0 1px 3px rgba(0,0,0,0.2); position: relative;">
                                <span style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(45deg, transparent 48%, #FFFFFF 48%, #FFFFFF 52%, transparent 52%), linear-gradient(-45deg, transparent 48%, #FFFFFF 48%, #FFFFFF 52%, transparent 52%);"></span>
                            </span>
                            @endif
                            <span class="text-sm font-semibold text-gray-700 uppercase">{{ app()->getLocale() }}</span>
                            <svg class="w-4 h-4 text-gray-600 transform transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="languageDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden language-dropdown opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                            <a href="{{ str_replace('/' . app()->getLocale(), '/tr', request()->url()) }}" class="flex items-center space-x-3 px-4 py-3 hover:bg-blue-50 transition-colors duration-200 {{ app()->getLocale() === 'tr' ? 'bg-blue-50 border-l-4 border-blue-600' : '' }}">
                                <span class="flag-icon" style="background: linear-gradient(to bottom, #E30A17 0%, #E30A17 33%, #FFFFFF 33%, #FFFFFF 66%, #E30A17 66%); display: inline-block; width: 24px; height: 18px; border-radius: 2px; box-shadow: 0 1px 3px rgba(0,0,0,0.2);"></span>
                                <span class="text-sm font-semibold text-gray-700">Türkçe</span>
                                @if(app()->getLocale() === 'tr')
                                <svg class="w-5 h-5 text-blue-600 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                @endif
                            </a>
                            <a href="{{ str_replace('/' . app()->getLocale(), '/en', request()->url()) }}" class="flex items-center space-x-3 px-4 py-3 hover:bg-blue-50 transition-colors duration-200 {{ app()->getLocale() === 'en' ? 'bg-blue-50 border-l-4 border-blue-600' : '' }}">
                                <span class="flag-icon" style="background: linear-gradient(to bottom, #012169 0%, #012169 40%, #FFFFFF 40%, #FFFFFF 60%, #C8102E 60%); display: inline-block; width: 24px; height: 18px; border-radius: 2px; box-shadow: 0 1px 3px rgba(0,0,0,0.2); position: relative;">
                                    <span style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(45deg, transparent 48%, #FFFFFF 48%, #FFFFFF 52%, transparent 52%), linear-gradient(-45deg, transparent 48%, #FFFFFF 48%, #FFFFFF 52%, transparent 52%);"></span>
                                </span>
                                <span class="text-sm font-semibold text-gray-700">English</span>
                                @if(app()->getLocale() === 'en')
                                <svg class="w-5 h-5 text-blue-600 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                @endif
                            </a>
                        </div>
                    </div>

                    <!-- Mobile Menu Toggle -->
                    <button id="mobileMenuToggle" class="mobile-menu-toggle md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="hamburger">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Overlay -->
    <div id="mobileOverlay" class="mobile-overlay"></div>

    <!-- Mobile Navigation Menu -->
    <div id="mobileMenu" class="nav-menu md:hidden">
        <!-- Mobile Menu Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 mb-4">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center shadow-lg">
                    <span class="text-white font-bold text-sm">DT</span>
                </div>
                <span class="text-lg font-bold text-gray-900">Devrim Tuncer</span>
            </div>
            <button id="closeMobileMenu" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation Links -->
        <div class="flex-1">
            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="flex items-center space-x-3 px-6 py-4 text-gray-700 hover:text-blue-600 transition-all duration-300 {{ request()->routeIs('home') ? 'text-blue-600 bg-gradient-to-r from-blue-50 to-transparent border-l-4 border-blue-600' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="font-semibold">{{ __('messages.home') }}</span>
            </a>
            <a href="{{ route('blog.index', ['locale' => app()->getLocale()]) }}" class="flex items-center space-x-3 px-6 py-4 text-gray-700 hover:text-blue-600 transition-all duration-300 {{ request()->routeIs('blog.*') ? 'text-blue-600 bg-gradient-to-r from-blue-50 to-transparent border-l-4 border-blue-600' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <span class="font-semibold">{{ __('messages.blog') }}</span>
            </a>
            <a href="{{ route('portfolio.index', ['locale' => app()->getLocale()]) }}" class="flex items-center space-x-3 px-6 py-4 text-gray-700 hover:text-blue-600 transition-all duration-300 {{ request()->routeIs('portfolio.*') ? 'text-blue-600 bg-gradient-to-r from-blue-50 to-transparent border-l-4 border-blue-600' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <span class="font-semibold">{{ __('messages.portfolio') }}</span>
            </a>
            <a href="{{ route('tools.index', ['locale' => app()->getLocale()]) }}" class="flex items-center space-x-3 px-6 py-4 text-gray-700 hover:text-blue-600 transition-all duration-300 {{ request()->routeIs('tools.*') ? 'text-blue-600 bg-gradient-to-r from-blue-50 to-transparent border-l-4 border-blue-600' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="font-semibold">{{ __('messages.tools') }}</span>
            </a>
            <a href="{{ route('about.index', ['locale' => app()->getLocale()]) }}" class="flex items-center space-x-3 px-6 py-4 text-gray-700 hover:text-blue-600 transition-all duration-300 {{ request()->routeIs('about.*') ? 'text-blue-600 bg-gradient-to-r from-blue-50 to-transparent border-l-4 border-blue-600' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="font-semibold">{{ __('messages.about') }}</span>
            </a>
        </div>

        <!-- Mobile Language Switcher -->
        <div class="px-6 py-4 border-t border-gray-200 mt-4">
            <p class="text-xs font-semibold text-gray-500 uppercase mb-3">Language</p>
            <div class="space-y-2">
                <a href="{{ str_replace('/' . app()->getLocale(), '/tr', request()->url()) }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-300 {{ app()->getLocale() === 'tr' ? 'bg-blue-50 border-2 border-blue-600' : 'bg-gray-50 hover:bg-gray-100 border-2 border-transparent' }}">
                    <span class="flag-icon" style="background: linear-gradient(to bottom, #E30A17 0%, #E30A17 33%, #FFFFFF 33%, #FFFFFF 66%, #E30A17 66%); display: inline-block; width: 28px; height: 20px; border-radius: 3px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);"></span>
                    <span class="font-semibold text-gray-700 flex-1">Türkçe</span>
                    @if(app()->getLocale() === 'tr')
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    @endif
                </a>
                <a href="{{ str_replace('/' . app()->getLocale(), '/en', request()->url()) }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-300 {{ app()->getLocale() === 'en' ? 'bg-blue-50 border-2 border-blue-600' : 'bg-gray-50 hover:bg-gray-100 border-2 border-transparent' }}">
                    <span class="flag-icon" style="background: linear-gradient(to bottom, #012169 0%, #012169 40%, #FFFFFF 40%, #FFFFFF 60%, #C8102E 60%); display: inline-block; width: 28px; height: 20px; border-radius: 3px; box-shadow: 0 2px 4px rgba(0,0,0,0.2); position: relative;">
                        <span style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(45deg, transparent 48%, #FFFFFF 48%, #FFFFFF 52%, transparent 52%), linear-gradient(-45deg, transparent 48%, #FFFFFF 48%, #FFFFFF 52%, transparent 52%);"></span>
                    </span>
                    <span class="font-semibold text-gray-700 flex-1">English</span>
                    @if(app()->getLocale() === 'en')
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    @endif
                </a>
            </div>
        </div>
    </div>

    <main>
        @yield('content')
        
        @if(!request()->is('*/blog*'))
        <!-- Contact Form Section -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-8">{{ __('messages.contact_me') }}</h2>
                <form action="{{ route('contact.store', ['locale' => app()->getLocale()]) }}" method="POST" class="bg-white rounded-lg shadow-md p-8">
                    @csrf
                    
                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.first_name') }} *</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.last_name') }} *</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full px-4 py-2 border rounded-lg">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.phone') }}</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.email') }} *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border rounded-lg">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.subject') }} *</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required class="w-full px-4 py-2 border rounded-lg">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.message') }} *</label>
                        <textarea name="message" rows="6" required class="w-full px-4 py-2 border rounded-lg">{{ old('message') }}</textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            {{ __('messages.send_message') }}
                        </button>
                    </div>
                </form>
                
                @php
                    $location_map_url = \App\Models\Setting::get('location_map_url');
                    $location_address = \App\Models\Setting::get('location_address');
                @endphp
                @if($location_map_url)
                <div class="mt-8">
                    <h3 class="text-2xl font-bold text-center mb-4">{{ __('messages.location') }}</h3>
                    @if($location_address)
                    <p class="text-center text-gray-600 mb-4">{{ $location_address }}</p>
                    @endif
                    <div style="height: 400px; width: 100%; border-radius: 8px; overflow: hidden;">
                        <iframe src="{{ $location_map_url }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                @endif
            </div>
        </section>
        @endif
    </main>

    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">Devrim Tuncer</h3>
                    <p class="text-gray-400">{{ __('messages.freelancer_developer') }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">{{ __('messages.links') }}</h3>
                    <ul class="space-y-2">
                        @php
                            $instagram = \App\Models\Setting::get('instagram_url');
                            $twitter = \App\Models\Setting::get('twitter_url');
                            $r10 = \App\Models\Setting::get('r10_url');
                            $fiverr = \App\Models\Setting::get('fiverr_url');
                            $linkedin = \App\Models\Setting::get('linkedin_url');
                        @endphp
                        @if($instagram)
                        <li><a href="{{ $instagram }}" target="_blank" class="text-gray-400 hover:text-white">Instagram</a></li>
                        @endif
                        @if($linkedin)
                        <li><a href="{{ $linkedin }}" target="_blank" class="text-gray-400 hover:text-white">LinkedIn</a></li>
                        @endif
                        @if($twitter)
                        <li><a href="{{ $twitter }}" target="_blank" class="text-gray-400 hover:text-white">Twitter</a></li>
                        @endif
                        @if($r10)
                        <li><a href="{{ $r10 }}" target="_blank" class="text-gray-400 hover:text-white">R10</a></li>
                        @endif
                        @if($fiverr)
                        <li><a href="{{ $fiverr }}" target="_blank" class="text-gray-400 hover:text-white">Fiverr</a></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">{{ __('messages.contact') }}</h3>
                    @php
                        $email = \App\Models\Setting::get('email', 'info@devrimtuncer.com');
                        $phone = \App\Models\Setting::get('phone');
                        $whatsapp = \App\Models\Setting::get('whatsapp');
                        $location_address = \App\Models\Setting::get('location_address');
                    @endphp
                    @if($email)
                    <p class="text-gray-400 mb-2">Email: <a href="mailto:{{ $email }}" class="hover:text-white">{{ $email }}</a></p>
                    @endif
                    @if($phone)
                    <p class="text-gray-400 mb-2">Phone: <a href="tel:{{ $phone }}" class="hover:text-white">{{ $phone }}</a></p>
                    @endif
                    @if($whatsapp)
                    <p class="text-gray-400 mb-2">WhatsApp: <a href="https://wa.me/{{ $whatsapp }}" target="_blank" class="hover:text-white">{{ $whatsapp }}</a></p>
                    @endif
                    @if($location_address)
                    <p class="text-gray-400 mb-2">{{ $location_address }}</p>
                    @endif
                </div>
            </div>
            @php
                $location_map_url = \App\Models\Setting::get('location_map_url');
            @endphp
            @if($location_map_url)
            <div class="mt-8">
                <h3 class="text-lg font-bold mb-4 text-white">{{ __('messages.location') }}</h3>
                <div style="height: 250px; width: 100%; border-radius: 8px; overflow: hidden;">
                    <iframe src="{{ $location_map_url }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            @endif
            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Devrim Tuncer. {{ __('messages.all_rights_reserved') }}</p>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        // Mobile Menu Toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const closeMobileMenu = document.getElementById('closeMobileMenu');
        const hamburger = mobileMenuToggle?.querySelector('.hamburger');

        function openMobileMenu() {
            if (mobileMenu && mobileOverlay && hamburger) {
                mobileMenu.classList.add('active');
                mobileOverlay.classList.add('active');
                hamburger.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeMobileMenuFunc() {
            if (mobileMenu && mobileOverlay && hamburger) {
                mobileMenu.classList.remove('active');
                mobileOverlay.classList.remove('active');
                hamburger.classList.remove('active');
                document.body.style.overflow = '';
            }
        }

        mobileMenuToggle?.addEventListener('click', function(e) {
            e.stopPropagation();
            if (mobileMenu?.classList.contains('active')) {
                closeMobileMenuFunc();
            } else {
                openMobileMenu();
            }
        });

        closeMobileMenu?.addEventListener('click', closeMobileMenuFunc);

        mobileOverlay?.addEventListener('click', closeMobileMenuFunc);

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (mobileMenu && mobileMenu.classList.contains('active')) {
                if (!mobileMenu.contains(event.target) && !mobileMenuToggle?.contains(event.target)) {
                    closeMobileMenuFunc();
                }
            }
        });

        // Close mobile menu on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && mobileMenu?.classList.contains('active')) {
                closeMobileMenuFunc();
            }
        });

        // Language dropdown click handler for mobile
        document.getElementById('languageToggle')?.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = document.getElementById('languageDropdown');
            if (window.innerWidth <= 768) {
                dropdown.classList.toggle('opacity-0');
                dropdown.classList.toggle('invisible');
            }
        });

        // Close language dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const toggle = document.getElementById('languageToggle');
            const dropdown = document.getElementById('languageDropdown');
            if (dropdown && toggle && !dropdown.contains(event.target) && !toggle.contains(event.target)) {
                if (window.innerWidth <= 768) {
                    dropdown.classList.add('opacity-0');
                    dropdown.classList.add('invisible');
                }
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

