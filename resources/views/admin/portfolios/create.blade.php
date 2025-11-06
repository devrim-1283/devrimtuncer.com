@extends('layouts.admin')

@section('page-title', 'Create Portfolio')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Create New Portfolio</h1>

    <form action="{{ route('admin.portfolios.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border rounded-lg">
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Company</label>
            <input type="text" name="company" value="{{ old('company') }}" class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Type *</label>
            <select name="type" required class="w-full px-4 py-2 border rounded-lg">
                <option value="real" {{ old('type') === 'real' ? 'selected' : '' }}>Real Project</option>
                <option value="demo" {{ old('type') === 'demo' ? 'selected' : '' }}>Demo</option>
            </select>
            @error('type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description (TR)</label>
                <textarea name="description_tr" rows="5" class="w-full px-4 py-2 border rounded-lg">{{ old('description_tr') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description (EN)</label>
                <textarea name="description_en" rows="5" class="w-full px-4 py-2 border rounded-lg">{{ old('description_en') }}</textarea>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Service Type</label>
            <input type="text" name="service_type" value="{{ old('service_type') }}" class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Image</label>
            <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
            @error('image') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Link</label>
            <input type="url" name="link" value="{{ old('link') }}" class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
            <input type="text" name="slug" value="{{ old('slug') }}" class="w-full px-4 py-2 border rounded-lg">
            <p class="text-sm text-gray-500 mt-1">Leave empty to auto-generate from name</p>
            @error('slug') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Tools</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                @foreach($tools as $tool)
                <label class="flex items-center">
                    <input type="checkbox" name="tools[]" value="{{ $tool->id }}" class="mr-2">
                    <span>{{ $tool->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Completed At</label>
            <input type="date" name="completed_at" value="{{ old('completed_at') }}" class="w-full px-4 py-2 border rounded-lg">
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
            <a href="{{ route('admin.portfolios.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Portfolio</button>
        </div>
    </form>
</div>
@endsection

