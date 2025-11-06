@extends('layouts.app')

@section('title', 'Blog - Devrim Tuncer')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-4xl font-bold mb-8">Blog</h1>

    <!-- Filters -->
    <div class="mb-8 flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <input type="text" id="searchInput" placeholder="Search..." class="w-full px-4 py-2 border rounded-lg">
        </div>
        @if($categories->count() > 0)
        <select id="categoryFilter" class="px-4 py-2 border rounded-lg">
            <option value="">All Categories</option>
            @foreach($categories as $category)
            <option value="{{ $category->slug }}">{{ $category->name }}</option>
            @endforeach
        </select>
        @endif
    </div>

    <!-- Blog Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($blogs as $blog)
        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
            @if($blog->featured_image)
                    <img src="{{ storage_asset($blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-48 object-cover">
            @endif
            <div class="p-6">
                @if($blog->category)
                <span class="text-sm text-blue-600">{{ $blog->category->name }}</span>
                @endif
                <h2 class="text-2xl font-semibold mt-2 mb-2">
                    <a href="{{ route('blog.show', ['locale' => app()->getLocale(), 'id' => $blog->id, 'slug' => $blog->slug]) }}" class="hover:text-blue-600">
                        {{ $blog->title }}
                    </a>
                </h2>
                <p class="text-gray-600 mb-4">{{ Str::limit($blog->excerpt, 150) }}</p>
                <div class="flex items-center justify-between text-sm text-gray-500">
                    <span>{{ $blog->reading_time }} min read</span>
                    <span>{{ $blog->published_at->format('M d, Y') }}</span>
                </div>
            </div>
        </article>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500 text-lg">No blog posts found.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $blogs->links() }}
    </div>
</div>
@endsection

