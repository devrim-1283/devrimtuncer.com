@extends('layouts.app')

@section('title', $blog->title . ' - Devrim Tuncer')

@section('meta')
<meta name="description" content="{{ $blog->meta_description ?? Str::limit($blog->excerpt, 160) }}">
<meta property="og:title" content="{{ $blog->title }}">
<meta property="og:description" content="{{ $blog->meta_description ?? Str::limit($blog->excerpt, 160) }}">
@if($blog->featured_image)
<meta property="og:image" content="{{ storage_asset($blog->featured_image) }}">
@endif
@endsection

@section('content')
<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($blog->featured_image)
    <img src="{{ storage_asset($blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-96 object-cover rounded-lg mb-8">
    @endif

    <header class="mb-8">
        @if($blog->category)
        <span class="text-blue-600">{{ $blog->category->name }}</span>
        @endif
        <h1 class="text-4xl font-bold mt-2 mb-4">{{ $blog->title }}</h1>
        <div class="flex items-center space-x-4 text-gray-500">
            <span>{{ $blog->reading_time }} min read</span>
            <span>•</span>
            <span>{{ $blog->published_at->format('M d, Y') }}</span>
            <span>•</span>
            <span>{{ $blog->view_count }} views</span>
        </div>
        @if($blog->tags->count() > 0)
        <div class="mt-4 flex flex-wrap gap-2">
            @foreach($blog->tags as $tag)
            <span class="px-3 py-1 bg-gray-100 rounded-full text-sm">{{ $tag->name }}</span>
            @endforeach
        </div>
        @endif
    </header>

    <div class="prose max-w-none mb-8">
        {!! $blog->parsed_content !!}
    </div>

    <!-- Social Share -->
    <div class="border-t pt-8 mb-8">
        <h3 class="text-lg font-semibold mb-4">Share this post</h3>
        <div class="flex space-x-4">
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($blog->title) }}" target="_blank" class="px-4 py-2 bg-blue-400 text-white rounded hover:bg-blue-500">Twitter</a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Facebook</a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" class="px-4 py-2 bg-blue-800 text-white rounded hover:bg-blue-900">LinkedIn</a>
        </div>
    </div>

    <!-- Related Posts -->
    @if($relatedBlogs->count() > 0)
    <div class="border-t pt-8">
        <h3 class="text-2xl font-bold mb-6">Related Posts</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($relatedBlogs as $related)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($related->featured_image)
                <img src="{{ storage_asset($related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-32 object-cover">
                @endif
                <div class="p-4">
                    <h4 class="font-semibold mb-2">
                        <a href="{{ route('blog.show', ['locale' => app()->getLocale(), 'id' => $related->id, 'slug' => $related->slug]) }}" class="hover:text-blue-600">
                            {{ $related->title }}
                        </a>
                    </h4>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</article>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css">
<style>
.prose pre {
    background: #1e1e1e;
    color: #d4d4d4;
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
}
.prose code {
    background: #f3f4f6;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-size: 0.9em;
}
.prose pre code {
    background: transparent;
    padding: 0;
}
</style>
@endpush
@endsection

