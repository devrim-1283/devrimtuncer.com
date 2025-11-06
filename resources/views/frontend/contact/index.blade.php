@extends('layouts.app')

@section('title', __('messages.contact') . ' - Devrim Tunçer')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold mb-4 bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">{{ __('messages.contact_me') }}</h1>
            <p class="text-xl text-gray-600">Projeleriniz için benimle iletişime geçin</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Information -->
            <div>
                <div class="bg-white rounded-3xl shadow-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-gray-900">İletişim Bilgileri</h2>
                    
                    @php
                        $email = \App\Models\Setting::get('email', 'info@devrimtuncer.com');
                        $phone = \App\Models\Setting::get('phone');
                        $whatsapp = \App\Models\Setting::get('whatsapp');
                        $location_address = \App\Models\Setting::get('location_address');
                    @endphp

                    <div class="space-y-6">
                        @if($email)
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <i class="fas fa-envelope text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Email</p>
                                <a href="mailto:{{ $email }}" class="text-lg font-semibold text-gray-900 hover:text-blue-600 transition-colors">{{ $email }}</a>
                            </div>
                        </div>
                        @endif

                        @if($phone)
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <i class="fas fa-phone text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Telefon</p>
                                <a href="tel:{{ $phone }}" class="text-lg font-semibold text-gray-900 hover:text-green-600 transition-colors">{{ $phone }}</a>
                            </div>
                        </div>
                        @endif

                        @if($whatsapp)
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <i class="fab fa-whatsapp text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">WhatsApp</p>
                                <a href="https://wa.me/{{ $whatsapp }}" target="_blank" class="text-lg font-semibold text-gray-900 hover:text-green-600 transition-colors">{{ $whatsapp }}</a>
                            </div>
                        </div>
                        @endif

                        @if($location_address)
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <i class="fas fa-map-marker-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Konum</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $location_address }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Social Media Links -->
                <div class="bg-white rounded-3xl shadow-2xl p-8">
                    <h2 class="text-2xl font-bold mb-6 text-gray-900">Sosyal Medya</h2>
                    <div class="flex gap-4">
                        @php
                            $instagram = \App\Models\Setting::get('instagram_url');
                            $linkedin = \App\Models\Setting::get('linkedin_url');
                            $twitter = \App\Models\Setting::get('twitter_url');
                            $fiverr = \App\Models\Setting::get('fiverr_url');
                            $r10 = \App\Models\Setting::get('r10_url');
                        @endphp
                        @if($linkedin)
                        <a href="{{ $linkedin }}" target="_blank" class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center hover:bg-blue-700 transition-all duration-300 transform hover:scale-110 shadow-lg">
                            <i class="fab fa-linkedin-in text-white text-2xl"></i>
                        </a>
                        @endif
                        @if($instagram)
                        <a href="{{ $instagram }}" target="_blank" class="w-14 h-14 bg-gradient-to-br from-purple-600 to-pink-600 rounded-2xl flex items-center justify-center hover:from-purple-700 hover:to-pink-700 transition-all duration-300 transform hover:scale-110 shadow-lg">
                            <i class="fab fa-instagram text-white text-2xl"></i>
                        </a>
                        @endif
                        @if($twitter)
                        <a href="{{ $twitter }}" target="_blank" class="w-14 h-14 bg-sky-500 rounded-2xl flex items-center justify-center hover:bg-sky-600 transition-all duration-300 transform hover:scale-110 shadow-lg">
                            <i class="fab fa-twitter text-white text-2xl"></i>
                        </a>
                        @endif
                        @if($fiverr)
                        <a href="{{ $fiverr }}" target="_blank" class="w-14 h-14 bg-green-600 rounded-2xl flex items-center justify-center hover:bg-green-700 transition-all duration-300 transform hover:scale-110 shadow-lg">
                            <i class="fas fa-f text-white text-2xl font-bold"></i>
                        </a>
                        @endif
                        @if($r10)
                        <a href="{{ $r10 }}" target="_blank" class="w-14 h-14 bg-gray-800 rounded-2xl flex items-center justify-center hover:bg-gray-900 transition-all duration-300 transform hover:scale-110 shadow-lg">
                            <i class="fas fa-code text-white text-2xl"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div>
                <div class="bg-white rounded-3xl shadow-2xl p-8">
                    <h2 class="text-3xl font-bold mb-6 text-gray-900">Mesaj Gönderin</h2>
                    
                    <form action="{{ route('contact.store', ['locale' => app()->getLocale()]) }}" method="POST" class="space-y-6">
                        @csrf
                        
                        @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
                                <p class="text-green-700 font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-circle text-red-500 mr-3 text-xl mt-1"></i>
                                <ul class="text-red-700">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('messages.first_name') }} *</label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('messages.last_name') }} *</label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('messages.phone') }}</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('messages.email') }} *</label>
                                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('messages.subject') }} *</label>
                            <input type="text" name="subject" value="{{ old('subject') }}" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('messages.message') }} *</label>
                            <textarea name="message" rows="6" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none">{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="w-full px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-lg font-semibold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:scale-105 flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            {{ __('messages.send_message') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        @php
            $location_map_url = \App\Models\Setting::get('location_map_url');
        @endphp
        @if($location_map_url)
        <div class="mt-16">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="p-6 bg-gradient-to-r from-blue-600 to-purple-600">
                    <h3 class="text-2xl font-bold text-white">{{ __('messages.location') }}</h3>
                </div>
                <div style="height: 450px; width: 100%;">
                    <iframe src="{{ $location_map_url }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

