<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Devrim Tuncer')</title>
    
    @yield('meta')
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="flex items-center">
                        <span class="text-xl font-bold">Devrim Tuncer</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="px-3 py-2 rounded-md text-sm font-medium">{{ __('messages.home') }}</a>
                    <a href="{{ route('blog.index', ['locale' => app()->getLocale()]) }}" class="px-3 py-2 rounded-md text-sm font-medium">{{ __('messages.blog') }}</a>
                    <a href="{{ route('portfolio.index', ['locale' => app()->getLocale()]) }}" class="px-3 py-2 rounded-md text-sm font-medium">{{ __('messages.portfolio') }}</a>
                    <a href="{{ route('tools.index', ['locale' => app()->getLocale()]) }}" class="px-3 py-2 rounded-md text-sm font-medium">{{ __('messages.tools') }}</a>
                    <a href="{{ route('about.index', ['locale' => app()->getLocale()]) }}" class="px-3 py-2 rounded-md text-sm font-medium">{{ __('messages.about') }}</a>
                    <div class="flex items-center space-x-2">
                        <a href="{{ str_replace('/' . app()->getLocale(), '/tr', request()->url()) }}" class="px-2 py-1 rounded text-sm {{ app()->getLocale() === 'tr' ? 'bg-blue-500 text-white' : 'text-gray-600' }}">TR</a>
                        <a href="{{ str_replace('/' . app()->getLocale(), '/en', request()->url()) }}" class="px-2 py-1 rounded text-sm {{ app()->getLocale() === 'en' ? 'bg-blue-500 text-white' : 'text-gray-600' }}">EN</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

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
    @stack('scripts')
</body>
</html>

