@extends('layouts.app')

@section('title', 'Portfolio - Devrim Tuncer')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-4xl font-bold mb-8">{{ __('messages.portfolio') }}</h1>

    <!-- Filters -->
    <div class="mb-8 flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <input type="text" id="searchInput" placeholder="{{ __('messages.search') }}..." class="w-full px-4 py-2 border rounded-lg">
        </div>
        <select id="typeFilter" class="px-4 py-2 border rounded-lg">
            <option value="">{{ __('messages.all_types') }}</option>
            <option value="real">{{ __('messages.real_projects') }}</option>
            <option value="demo">{{ __('messages.demos') }}</option>
        </select>
        @if($tools->count() > 0)
        <select id="toolFilter" class="px-4 py-2 border rounded-lg">
            <option value="">{{ __('messages.all_tools') }}</option>
            @foreach($tools as $tool)
            <option value="{{ $tool->slug }}">{{ $tool->name }}</option>
            @endforeach
        </select>
        @endif
        <select id="sortFilter" class="px-4 py-2 border rounded-lg">
            <option value="date">{{ __('messages.sort_by_date') }}</option>
            <option value="alphabetical">{{ __('messages.sort_by_name') }}</option>
            <option value="type">{{ __('messages.sort_by_type') }}</option>
        </select>
    </div>

    <!-- Portfolio Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($portfolios as $portfolio)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
            @if($portfolio->image)
            <img src="{{ storage_asset($portfolio->image) }}" alt="{{ $portfolio->name }}" class="w-full h-48 object-cover">
            @endif
            <div class="p-6">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-2xl font-semibold">{{ $portfolio->name }}</h2>
                    <span class="px-2 py-1 text-xs rounded {{ $portfolio->type === 'real' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ $portfolio->type === 'real' ? __('messages.real') : __('messages.demo') }}
                    </span>
                </div>
                @if($portfolio->company)
                <p class="text-gray-600 mb-2">{{ $portfolio->company }}</p>
                @endif
                <p class="text-gray-600 mb-4">{{ Str::limit($portfolio->description, 150) }}</p>
                @if($portfolio->tools->count() > 0)
                <div class="mb-4 flex flex-wrap gap-2">
                    @foreach($portfolio->tools->take(3) as $tool)
                    <span class="px-2 py-1 bg-gray-100 rounded text-xs">{{ $tool->name }}</span>
                    @endforeach
                </div>
                @endif
                <a href="{{ route('portfolio.show', ['locale' => app()->getLocale(), 'id' => $portfolio->id, 'slug' => $portfolio->slug]) }}" class="text-blue-600 hover:underline">{{ __('messages.view_details') }} →</a>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500 text-lg">{{ __('messages.no_portfolios') }}</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $portfolios->links() }}
    </div>
</div>
@endsection

