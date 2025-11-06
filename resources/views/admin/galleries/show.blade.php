@extends('layouts.admin')

@section('page-title', 'Gallery Item Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Gallery Item Details</h1>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold mb-4">{{ $gallery->name }}</h2>
            @if($gallery->image)
            <img src="{{ storage_asset($gallery->image) }}" alt="{{ $gallery->name }}" class="w-full max-w-md rounded-lg mb-4">
            @endif
        </div>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tag</label>
                <p class="text-gray-900">{{ $gallery->tag ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <p class="text-gray-900">{{ $gallery->description ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <span class="px-2 py-1 text-xs rounded {{ $gallery->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $gallery->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                <p class="text-gray-900">{{ $gallery->sort_order }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Created At</label>
                <p class="text-gray-900">{{ $gallery->created_at->format('M d, Y H:i') }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Updated At</label>
                <p class="text-gray-900">{{ $gallery->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>

        <div class="mt-6 flex space-x-4">
            <a href="{{ route('admin.galleries.edit', $gallery->id) }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Edit</a>
            <a href="{{ route('admin.galleries.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Back to List</a>
        </div>
    </div>
</div>
@endsection

