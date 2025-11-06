@extends('layouts.admin')

@section('page-title', 'Message Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.messages.index') }}" class="text-blue-600 hover:underline">← Back to Messages</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="border-b pb-4 mb-4">
            <h1 class="text-2xl font-bold mb-2">{{ $message->full_name }}</h1>
            <div class="flex items-center space-x-4 text-sm text-gray-500">
                <span>{{ $message->email }}</span>
                @if($message->phone)
                <span>•</span>
                <span>{{ $message->phone }}</span>
                @endif
                <span>•</span>
                <span>{{ $message->created_at->format('M d, Y H:i') }}</span>
            </div>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold mb-2">Subject</h2>
            <p class="text-gray-700">{{ $message->subject }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold mb-2">Message</h2>
            <p class="text-gray-700 whitespace-pre-wrap">{{ $message->message }}</p>
        </div>

        @if($message->ip_address)
        <div class="mt-4 pt-4 border-t">
            <p class="text-sm text-gray-500">IP Address: {{ $message->ip_address }}</p>
        </div>
        @endif
    </div>
</div>
@endsection

