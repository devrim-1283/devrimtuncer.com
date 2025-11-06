@extends('layouts.admin')

@section('page-title', 'Create Blog')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Create New Blog</h1>

    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Title (TR)</label>
                <input type="text" name="title_tr" value="{{ old('title_tr') }}" required class="w-full px-4 py-2 border rounded-lg">
                @error('title_tr') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Title (EN)</label>
                <input type="text" name="title_en" value="{{ old('title_en') }}" required class="w-full px-4 py-2 border rounded-lg">
                @error('title_en') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
            <input type="text" name="slug" value="{{ old('slug') }}" class="w-full px-4 py-2 border rounded-lg">
            <p class="text-sm text-gray-500 mt-1">Leave empty to auto-generate from English title</p>
            @error('slug') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Excerpt (TR)</label>
                <textarea name="excerpt_tr" rows="3" class="w-full px-4 py-2 border rounded-lg">{{ old('excerpt_tr') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Excerpt (EN)</label>
                <textarea name="excerpt_en" rows="3" class="w-full px-4 py-2 border rounded-lg">{{ old('excerpt_en') }}</textarea>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Content (TR) - Markdown</label>
                <textarea name="content_tr" rows="15" required class="w-full px-4 py-2 border rounded-lg font-mono">{{ old('content_tr') }}</textarea>
                @error('content_tr') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Content (EN) - Markdown</label>
                <textarea name="content_en" rows="15" required class="w-full px-4 py-2 border rounded-lg font-mono">{{ old('content_en') }}</textarea>
                @error('content_en') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
            <select name="category_id" class="w-full px-4 py-2 border rounded-lg">
                <option value="">No Category</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                @foreach($tags as $tag)
                <label class="flex items-center">
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="mr-2">
                    <span>{{ $tag->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
            <input type="file" name="featured_image" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
            @error('featured_image') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title (TR)</label>
                <input type="text" name="meta_title_tr" value="{{ old('meta_title_tr') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title (EN)</label>
                <input type="text" name="meta_title_en" value="{{ old('meta_title_en') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description (TR)</label>
                <textarea name="meta_description_tr" rows="3" class="w-full px-4 py-2 border rounded-lg">{{ old('meta_description_tr') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description (EN)</label>
                <textarea name="meta_description_en" rows="3" class="w-full px-4 py-2 border rounded-lg">{{ old('meta_description_en') }}</textarea>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Published At</label>
            <input type="datetime-local" name="published_at" value="{{ old('published_at') }}" class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div class="mb-6 flex items-center space-x-4">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="mr-2">
                <span>Active</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="mr-2">
                <span>Featured</span>
            </label>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.blogs.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Blog</button>
        </div>
    </form>
</div>
@endsection

