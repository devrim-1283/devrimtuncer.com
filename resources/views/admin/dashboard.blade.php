@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card blue rounded-xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-blog text-2xl"></i>
            </div>
            <span class="text-white text-opacity-70 text-sm font-medium">Blogs</span>
        </div>
        <h3 class="text-4xl font-bold mb-2">{{ $stats['total_blogs'] }}</h3>
        <p class="text-white text-opacity-80 text-sm">
            <i class="fas fa-check-circle mr-1"></i>
            {{ $stats['active_blogs'] }} active
        </p>
    </div>

    <div class="stat-card green rounded-xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-briefcase text-2xl"></i>
            </div>
            <span class="text-white text-opacity-70 text-sm font-medium">Portfolios</span>
        </div>
        <h3 class="text-4xl font-bold mb-2">{{ $stats['total_portfolios'] }}</h3>
        <p class="text-white text-opacity-80 text-sm">
            <i class="fas fa-check-circle mr-1"></i>
            {{ $stats['active_portfolios'] }} active
        </p>
    </div>

    <div class="stat-card purple rounded-xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-envelope text-2xl"></i>
            </div>
            <span class="text-white text-opacity-70 text-sm font-medium">Messages</span>
        </div>
        <h3 class="text-4xl font-bold mb-2">{{ $stats['total_messages'] }}</h3>
        <p class="text-white text-opacity-80 text-sm">
            <i class="fas fa-exclamation-circle mr-1"></i>
            {{ $stats['unread_messages'] }} unread
        </p>
    </div>

    <div class="stat-card orange rounded-xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <span class="text-white text-opacity-70 text-sm font-medium">Today's Visitors</span>
        </div>
        <h3 class="text-4xl font-bold mb-2">{{ $stats['unique_visitors_today'] }}</h3>
        <p class="text-white text-opacity-80 text-sm">
            <i class="fas fa-eye mr-1"></i>
            {{ $stats['page_views_today'] }} page views
        </p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Messages -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-envelope mr-3"></i>
                    Recent Messages
                </h3>
                <a href="{{ route('admin.messages.index') }}" class="text-white text-sm hover:underline">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($recentMessages as $message)
                <div class="border-l-4 border-blue-500 pl-4 py-3 hover:bg-gray-50 rounded-r-lg transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-semibold text-gray-900">{{ $message->full_name }}</h4>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                            <i class="far fa-clock mr-1"></i>
                            {{ $message->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <p class="text-gray-600 text-sm mb-2">{{ $message->subject }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">
                            <i class="fas fa-envelope mr-1"></i>
                            {{ $message->email }}
                        </span>
                        <a href="{{ route('admin.messages.show', $message->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                            View <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    @if(!$message->is_read)
                    <span class="inline-block mt-2 bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded-full">
                        <i class="fas fa-circle mr-1 text-xs"></i>
                        Unread
                    </span>
                    @endif
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500">No messages yet.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Blogs -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-blog mr-3"></i>
                    Recent Blogs
                </h3>
                <a href="{{ route('admin.blogs.index') }}" class="text-white text-sm hover:underline">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($recentBlogs as $blog)
                <div class="border-l-4 border-green-500 pl-4 py-3 hover:bg-gray-50 rounded-r-lg transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-semibold text-gray-900">{{ $blog->title }}</h4>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                            <i class="far fa-clock mr-1"></i>
                            {{ $blog->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $blog->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            <i class="fas fa-circle mr-1 text-xs"></i>
                            {{ $blog->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        @if($blog->published_at)
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            <i class="far fa-calendar-check mr-1"></i>
                            Published
                        </span>
                        @endif
                    </div>
                    <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="text-green-600 hover:text-green-800 text-sm font-medium flex items-center">
                        Edit <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-blog text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500">No blogs yet.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
