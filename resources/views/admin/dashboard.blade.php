@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm font-medium mb-2">Total Blogs</h3>
        <p class="text-3xl font-bold">{{ $stats['total_blogs'] }}</p>
        <p class="text-sm text-green-600 mt-2">{{ $stats['active_blogs'] }} active</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm font-medium mb-2">Total Portfolios</h3>
        <p class="text-3xl font-bold">{{ $stats['total_portfolios'] }}</p>
        <p class="text-sm text-green-600 mt-2">{{ $stats['active_portfolios'] }} active</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm font-medium mb-2">Messages</h3>
        <p class="text-3xl font-bold">{{ $stats['total_messages'] }}</p>
        <p class="text-sm text-red-600 mt-2">{{ $stats['unread_messages'] }} unread</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm font-medium mb-2">Today's Visitors</h3>
        <p class="text-3xl font-bold">{{ $stats['unique_visitors_today'] }}</p>
        <p class="text-sm text-gray-600 mt-2">{{ $stats['page_views_today'] }} page views</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-xl font-semibold mb-4">Recent Messages</h3>
        <div class="space-y-4">
            @forelse($recentMessages as $message)
            <div class="border-b pb-4 last:border-0">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="font-semibold">{{ $message->full_name }}</h4>
                    <span class="text-sm text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-gray-600 text-sm">{{ $message->subject }}</p>
                <a href="{{ route('admin.messages.show', $message->id) }}" class="text-blue-600 hover:underline text-sm">View →</a>
            </div>
            @empty
            <p class="text-gray-500">No messages yet.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-xl font-semibold mb-4">Recent Blogs</h3>
        <div class="space-y-4">
            @forelse($recentBlogs as $blog)
            <div class="border-b pb-4 last:border-0">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="font-semibold">{{ $blog->title }}</h4>
                    <span class="text-sm text-gray-500">{{ $blog->created_at->diffForHumans() }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="px-2 py-1 text-xs rounded {{ $blog->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $blog->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="text-blue-600 hover:underline text-sm">Edit →</a>
                </div>
            </div>
            @empty
            <p class="text-gray-500">No blogs yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

