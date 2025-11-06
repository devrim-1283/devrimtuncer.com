@extends('layouts.admin')

@section('page-title', 'Messages')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold">Messages</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($messages as $message)
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">{{ $message->full_name }}</h3>
            @if(!$message->is_read)
            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800">Unread</span>
            @endif
        </div>
        <p class="text-gray-600 mb-2"><strong>Subject:</strong> {{ $message->subject }}</p>
        <p class="text-gray-600 mb-2"><strong>Email:</strong> {{ $message->email }}</p>
        @if($message->phone)
        <p class="text-gray-600 mb-2"><strong>Phone:</strong> {{ $message->phone }}</p>
        @endif
        <p class="text-gray-500 text-sm mb-4">{{ Str::limit($message->message, 100) }}</p>
        <div class="flex items-center justify-between">
            <span class="text-xs text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
            <a href="{{ route('admin.messages.show', $message->id) }}" class="text-blue-600 hover:underline text-sm">View Details →</a>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12">
        <p class="text-gray-500 text-lg">No messages found.</p>
    </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $messages->links() }}
</div>
@endsection

