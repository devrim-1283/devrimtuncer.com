@extends('layouts.app')

@section('title', 'Tools - Devrim Tuncer')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-4xl font-bold mb-8">{{ __('messages.tools') }}</h1>

    @if($tools->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($tools as $tool)
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <h3 class="text-xl font-semibold mb-2">{{ $tool->name }}</h3>
            @if($tool->description)
            <p class="text-gray-600 mb-4">{{ $tool->description }}</p>
            @endif
            @if($tool->url)
            <a href="{{ $tool->url }}" target="_blank" class="text-blue-600 hover:underline">{{ __('messages.visit_tool') }} →</a>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-12">
        <p class="text-gray-500 text-lg">{{ __('messages.no_tools_yet') }}</p>
    </div>
    @endif
</div>
@endsection

