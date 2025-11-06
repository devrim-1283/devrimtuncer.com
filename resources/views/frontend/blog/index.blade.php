@extends('layouts.app')

@section('title', __('messages.blog') . ' - Devrim Tunçer')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-blue-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header with Animation -->
        <div class="text-center mb-16 fade-in">
            <h1 class="text-5xl font-bold mb-6 bg-gradient-to-r from-gray-900 via-blue-800 to-purple-800 bg-clip-text text-transparent">
                {{ __('messages.blog') }}
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ app()->getLocale() === 'tr' ? 'Teknoloji, yazılım ve kişisel deneyimlerim hakkında yazılar' : 'Articles about technology, software and my personal experiences' }}
            </p>
        </div>

        <!-- Blog Grid with Stagger Animation -->
        @if($blogs->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($blogs as $index => $blog)
            <article class="blog-card bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2" style="animation-delay: {{ $index * 0.1 }}s;">
                @if($blog->featured_image)
                <div class="relative h-56 overflow-hidden group">
                    <img src="{{ storage_asset($blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    @if($blog->reading_time)
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-gray-700 flex items-center space-x-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $blog->reading_time }} {{ __('messages.min_read') }}</span>
                    </div>
                    @endif
                </div>
                @endif
                <div class="p-6">
                    <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $blog->published_at ? $blog->published_at->format('d M Y') : '' }}
                        </span>
                        @if($blog->views)
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            {{ $blog->views }}
                        </span>
                        @endif
                    </div>
                    <h2 class="text-2xl font-bold mb-3 text-gray-900 line-clamp-2 hover:text-blue-600 transition-colors">
                        <a href="{{ route('blog.show', ['locale' => app()->getLocale(), 'id' => $blog->id, 'slug' => $blog->slug]) }}">
                            {{ $blog->title }}
                        </a>
                    </h2>
                    <p class="text-gray-600 mb-6 line-clamp-3 leading-relaxed">
                        {{ $blog->excerpt ?? Str::limit(strip_tags($blog->content), 150) }}
                    </p>
                    <a href="{{ route('blog.show', ['locale' => app()->getLocale(), 'id' => $blog->id, 'slug' => $blog->slug]) }}" class="inline-flex items-center space-x-2 text-blue-600 hover:text-blue-800 font-semibold group">
                        <span>{{ __('messages.read_more') }}</span>
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $blogs->links() }}
        </div>
        @else
        <div class="text-center py-20">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">{{ __('messages.no_blogs_yet') }}</h3>
            <p class="text-gray-500">{{ __('messages.check_back_soon') }}</p>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .fade-in {
        animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .blog-card {
        opacity: 0;
        animation: slideUp 0.8s ease-out forwards;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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
