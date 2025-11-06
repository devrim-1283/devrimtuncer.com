@extends('layouts.app')

@section('title', 'Home - Devrim Tunçer')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section with Devrim's Photo -->
    <section class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-purple-50 overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left: Photo -->
                <div class="flex justify-center lg:justify-end order-2 lg:order-1">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-purple-600 rounded-3xl transform rotate-6 scale-105"></div>
                        <img src="{{ asset('devrim.jpg') }}" alt="Devrim Tunçer" class="relative rounded-3xl shadow-2xl w-full max-w-md lg:max-w-lg object-cover" style="height: 600px;">
                        <div class="absolute -bottom-6 -right-6 bg-white rounded-2xl shadow-xl p-4 transform rotate-3">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-sm font-semibold text-gray-700">Available for projects</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Content -->
                <div class="text-center lg:text-left order-1 lg:order-2">
                    <h1 class="text-5xl lg:text-6xl font-bold mb-6 bg-gradient-to-r from-gray-900 via-blue-800 to-purple-800 bg-clip-text text-transparent leading-tight">
                        Merhaba!<br>Ben Devrim Tunçer
                    </h1>
                    <p class="text-xl lg:text-2xl text-gray-700 mb-8 leading-relaxed">
                        Size nasıl yardımcı olabilirim?
                    </p>
                    <p class="text-lg text-gray-600 mb-12 leading-relaxed max-w-2xl">
                        Freelance Full-Stack Developer olarak web uygulamaları, mobil projeler ve dijital çözümler geliştiriyorum. Modern teknolojiler kullanarak hayalinizdeki projeyi gerçeğe dönüştürebilirim.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                        <a href="{{ route('portfolio.index', ['locale' => app()->getLocale()]) }}" class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-full overflow-hidden shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                            <span class="relative z-10 flex items-center">
                                <i class="fas fa-briefcase mr-2"></i>
                                Portfolyo
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                        </a>

                        <a href="{{ route('about.index', ['locale' => app()->getLocale()]) }}" class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-gray-800 bg-white rounded-full overflow-hidden shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 border-2 border-gray-200 hover:border-blue-600">
                            <span class="relative z-10 flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                Hakkımda
                            </span>
                        </a>

                        <a href="{{ route('contact.index', ['locale' => app()->getLocale()]) }}" class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-gray-800 bg-white rounded-full overflow-hidden shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 border-2 border-gray-200 hover:border-purple-600">
                            <span class="relative z-10 flex items-center">
                                <i class="fas fa-envelope mr-2"></i>
                                İletişime Geçin
                            </span>
                        </a>
                    </div>

                    <!-- Social Links -->
                    <div class="mt-12">
                        <p class="text-sm text-gray-500 mb-4">Sosyal Medya</p>
                        <div class="flex gap-4 justify-center lg:justify-start">
                            @php
                                $instagram = \App\Models\Setting::get('instagram_url');
                                $linkedin = \App\Models\Setting::get('linkedin_url');
                                $twitter = \App\Models\Setting::get('twitter_url');
                                $github = \App\Models\Setting::get('github_url');
                            @endphp
                            @if($linkedin)
                            <a href="{{ $linkedin }}" target="_blank" class="w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300 transform hover:scale-110">
                                <i class="fab fa-linkedin-in text-xl"></i>
                            </a>
                            @endif
                            @if($instagram)
                            <a href="{{ $instagram }}" target="_blank" class="w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-pink-600 hover:text-white transition-all duration-300 transform hover:scale-110">
                                <i class="fab fa-instagram text-xl"></i>
                            </a>
                            @endif
                            @if($twitter)
                            <a href="{{ $twitter }}" target="_blank" class="w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-sky-500 hover:text-white transition-all duration-300 transform hover:scale-110">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            @endif
                            @if($github)
                            <a href="{{ $github }}" target="_blank" class="w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-gray-800 hover:text-white transition-all duration-300 transform hover:scale-110">
                                <i class="fab fa-github text-xl"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <!-- Default Slide Section (if exists) -->
    @if($slides->count() > 0)
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                <img src="{{ storage_asset($slides->first()->image_desktop) }}" alt="{{ $slides->first()->title }}" class="hidden md:block w-full h-[500px] object-cover">
                <img src="{{ storage_asset($slides->first()->image_mobile) }}" alt="{{ $slides->first()->title }}" class="md:hidden w-full h-[400px] object-cover">
                @if($slides->first()->text)
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent flex items-end">
                    <div class="p-8 md:p-12 text-white">
                        <h2 class="text-3xl md:text-5xl font-bold mb-4">{{ $slides->first()->title }}</h2>
                        <p class="text-lg md:text-xl text-gray-200">{{ $slides->first()->text }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    <!-- Latest Blogs Section -->
    @if($latestBlogs->count() > 0)
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4 bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Son Blog Yazıları</h2>
                <p class="text-gray-600 text-lg">Teknoloji, yazılım ve kişisel deneyimlerim hakkında yazılar</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($latestBlogs as $blog)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    @if($blog->featured_image)
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ storage_asset($blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-300">
                    </div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-3 line-clamp-2 hover:text-blue-600 transition-colors">
                            <a href="{{ route('blog.show', ['locale' => app()->getLocale(), 'id' => $blog->id, 'slug' => $blog->slug]) }}">
                                {{ $blog->title }}
                            </a>
                        </h3>
                        <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit($blog->excerpt, 150) }}</p>
                        <a href="{{ route('blog.show', ['locale' => app()->getLocale(), 'id' => $blog->id, 'slug' => $blog->slug]) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
                            Devamını Oku
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('blog.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-full font-semibold shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                    Tüm Yazıları Gör
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Featured Portfolios Section -->
    @if($featuredPortfolios->count() > 0)
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4 bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Öne Çıkan Projeler</h2>
                <p class="text-gray-600 text-lg">Geliştirdiğim bazı projeler ve çalışmalar</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($featuredPortfolios as $portfolio)
                <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    @if($portfolio->image)
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ storage_asset($portfolio->image) }}" alt="{{ $portfolio->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full shadow-lg {{ $portfolio->type === 'real' ? 'bg-green-500 text-white' : 'bg-blue-500 text-white' }}">
                                {{ $portfolio->type === 'real' ? 'Gerçek Proje' : 'Demo' }}
                            </span>
                        </div>
                    </div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $portfolio->name }}</h3>
                        <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit($portfolio->description, 150) }}</p>
                        <a href="{{ route('portfolio.show', ['locale' => app()->getLocale(), 'id' => $portfolio->id, 'slug' => $portfolio->slug]) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
                            Detayları Gör
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('portfolio.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-full font-semibold shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                    Tüm Projeleri Gör
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>
    @endif
</div>

@push('styles')
<style>
    @keyframes blob {
        0%, 100% {
            transform: translate(0px, 0px) scale(1);
        }
        33% {
            transform: translate(30px, -50px) scale(1.1);
        }
        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection
