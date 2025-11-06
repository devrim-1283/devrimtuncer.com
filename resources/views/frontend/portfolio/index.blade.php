@extends('layouts.app')

@section('title', __('messages.portfolio') . ' - Devrim Tunçer')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-pink-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header with Animation -->
        <div class="text-center mb-16 fade-in">
            <h1 class="text-5xl font-bold mb-6 bg-gradient-to-r from-gray-900 via-purple-800 to-pink-800 bg-clip-text text-transparent">
                {{ __('messages.portfolio') }}
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ app()->getLocale() === 'tr' ? 'Geliştirdiğim projeler ve çalışmalar' : 'Projects and works I have developed' }}
            </p>
        </div>

        <!-- Filters -->
        <div class="mb-12 flex flex-wrap gap-4 justify-center fade-in" style="animation-delay: 0.2s;">
            <select id="typeFilter" class="px-6 py-3 border-2 border-gray-200 rounded-full bg-white shadow-md hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="">{{ __('messages.all_types') }}</option>
                <option value="real">{{ __('messages.real_projects') }}</option>
                <option value="demo">{{ __('messages.demos') }}</option>
            </select>
            @if($tools->count() > 0)
            <select id="toolFilter" class="px-6 py-3 border-2 border-gray-200 rounded-full bg-white shadow-md hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="">{{ __('messages.all_tools') }}</option>
                @foreach($tools as $tool)
                <option value="{{ $tool->slug }}">{{ $tool->name }}</option>
                @endforeach
            </select>
            @endif
            <select id="sortFilter" class="px-6 py-3 border-2 border-gray-200 rounded-full bg-white shadow-md hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="date">{{ __('messages.sort_by_date') }}</option>
                <option value="alphabetical">{{ __('messages.sort_by_name') }}</option>
                <option value="type">{{ __('messages.sort_by_type') }}</option>
            </select>
        </div>

        <!-- Portfolio Grid with Stagger Animation -->
        @if($portfolios->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($portfolios as $index => $portfolio)
            <div class="portfolio-card group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3" style="animation-delay: {{ $index * 0.1 }}s;">
                @if($portfolio->image)
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ storage_asset($portfolio->image) }}" alt="{{ $portfolio->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute top-4 right-4">
                        <span class="px-4 py-2 text-sm font-bold rounded-full shadow-lg backdrop-blur-sm {{ $portfolio->type === 'real' ? 'bg-green-500/90 text-white' : 'bg-blue-500/90 text-white' }}">
                            {{ $portfolio->type === 'real' ? __('messages.real') : __('messages.demo') }}
                        </span>
                    </div>
                </div>
                @endif
                <div class="p-6">
                    <div class="mb-4">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors">
                            <a href="{{ route('portfolio.show', ['locale' => app()->getLocale(), 'id' => $portfolio->id, 'slug' => $portfolio->slug]) }}">
                                {{ $portfolio->name }}
                            </a>
                        </h2>
                        @if($portfolio->company)
                        <p class="text-sm text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            {{ $portfolio->company }}
                        </p>
                        @endif
                    </div>
                    <p class="text-gray-600 mb-6 line-clamp-3 leading-relaxed">
                        {{ Str::limit($portfolio->description, 150) }}
                    </p>
                    @if($portfolio->tools->count() > 0)
                    <div class="mb-6 flex flex-wrap gap-2">
                        @foreach($portfolio->tools->take(4) as $tool)
                        <span class="px-3 py-1 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 rounded-full text-xs font-semibold">
                            {{ $tool->name }}
                        </span>
                        @endforeach
                        @if($portfolio->tools->count() > 4)
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-semibold">
                            +{{ $portfolio->tools->count() - 4 }}
                        </span>
                        @endif
                    </div>
                    @endif
                    <a href="{{ route('portfolio.show', ['locale' => app()->getLocale(), 'id' => $portfolio->id, 'slug' => $portfolio->slug]) }}" class="inline-flex items-center space-x-2 text-purple-600 hover:text-purple-800 font-semibold group/link">
                        <span>{{ __('messages.view_details') }}</span>
                        <svg class="w-5 h-5 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $portfolios->links() }}
        </div>
        @else
        <div class="text-center py-20">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">{{ __('messages.no_portfolios') }}</h3>
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

    .portfolio-card {
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

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection
