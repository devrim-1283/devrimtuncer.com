@extends('layouts.admin')

@section('page-title', 'Create Slide')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Create New Slide</h1>

    <form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Title (TR)</label>
                <input type="text" name="title_tr" value="{{ old('title_tr') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Title (EN)</label>
                <input type="text" name="title_en" value="{{ old('title_en') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Text Overlay (TR)</label>
                <textarea name="text_tr" rows="3" class="w-full px-4 py-2 border rounded-lg">{{ old('text_tr') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Text Overlay (EN)</label>
                <textarea name="text_en" rows="3" class="w-full px-4 py-2 border rounded-lg">{{ old('text_en') }}</textarea>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Desktop Image *</label>
            <input type="file" name="image_desktop" accept="image/*" required class="w-full px-4 py-2 border rounded-lg">
            @error('image_desktop') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Mobile Image *</label>
            <input type="file" name="image_mobile" accept="image/*" required class="w-full px-4 py-2 border rounded-lg">
            @error('image_mobile') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Link</label>
            <input type="url" name="link" value="{{ old('link') }}" class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div class="mb-6 flex items-center">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="mr-2">
                <span>Active</span>
            </label>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.slides.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Slide</button>
        </div>
    </form>
</div>
@endsection

