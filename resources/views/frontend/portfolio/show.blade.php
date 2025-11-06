@extends('layouts.app')

@section('title', $portfolio->name . ' - Devrim Tuncer')

@section('content')
<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($portfolio->image)
    <img src="{{ storage_asset($portfolio->image) }}" alt="{{ $portfolio->name }}" class="w-full h-96 object-cover rounded-lg mb-8">
    @endif

    <header class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-4xl font-bold">{{ $portfolio->name }}</h1>
            <span class="px-3 py-1 rounded {{ $portfolio->type === 'real' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                {{ $portfolio->type === 'real' ? 'Real Project' : 'Demo' }}
            </span>
        </div>
        @if($portfolio->company)
        <p class="text-xl text-gray-600 mb-4">{{ $portfolio->company }}</p>
        @endif
        @if($portfolio->completed_at)
        <p class="text-gray-500">Completed: {{ $portfolio->completed_at->format('M Y') }}</p>
        @endif
    </header>

    <div class="prose max-w-none mb-8">
        <p>{{ $portfolio->description }}</p>
    </div>

    @if($portfolio->tools->count() > 0)
    <div class="mb-8">
        <h3 class="text-xl font-semibold mb-4">Technologies Used</h3>
        <div class="flex flex-wrap gap-2">
            @foreach($portfolio->tools as $tool)
            <span class="px-3 py-1 bg-gray-100 rounded-full">{{ $tool->name }}</span>
            @endforeach
        </div>
    </div>
    @endif

    @if($portfolio->link)
    <div class="mb-8">
        <a href="{{ $portfolio->link }}" target="_blank" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            View Project →
        </a>
    </div>
    @endif
</article>
@endsection

