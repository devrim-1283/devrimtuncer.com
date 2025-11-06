@extends('layouts.admin')

@section('page-title', 'Edit Gallery Item')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Edit Gallery Item</h1>

    <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
            <input type="text" name="name" value="{{ old('name', $gallery->name) }}" required class="w-full px-4 py-2 border rounded-lg">
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Tag</label>
            <input type="text" name="tag" value="{{ old('tag', $gallery->tag) }}" placeholder="e.g., Nature, Portrait, Event" class="w-full px-4 py-2 border rounded-lg">
            @error('tag')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
            @if($gallery->image)
            <img src="{{ storage_asset($gallery->image) }}" alt="{{ $gallery->name }}" class="w-32 h-32 object-cover rounded mb-2">
            @endif
            <label class="block text-sm font-medium text-gray-700 mb-2 mt-4">Upload New Image</label>
            <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
            <p class="text-sm text-gray-500 mt-1">Max size: 5MB. Supported formats: JPG, PNG, GIF, WebP</p>
            @error('image')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg">{{ old('description', $gallery->description) }}</textarea>
            @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $gallery->is_active) ? 'checked' : '' }} class="rounded">
                <span class="ml-2 text-sm text-gray-700">Active</span>
            </label>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $gallery->sort_order) }}" class="w-full px-4 py-2 border rounded-lg">
            @error('sort_order')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.galleries.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection

