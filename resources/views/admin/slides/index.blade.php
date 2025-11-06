@extends('layouts.admin')

@section('page-title', 'Slides')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold">Slides</h1>
    <a href="{{ route('admin.slides.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Create New Slide
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Desktop Image</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mobile Image</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sort Order</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($slides as $slide)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ $slide->title ?? 'No Title' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($slide->image_desktop)
                    <img src="{{ storage_asset($slide->image_desktop) }}" alt="Desktop" class="w-20 h-12 object-cover rounded">
                    @else
                    <span class="text-gray-400">No image</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($slide->image_mobile)
                    <img src="{{ storage_asset($slide->image_mobile) }}" alt="Mobile" class="w-20 h-12 object-cover rounded">
                    @else
                    <span class="text-gray-400">No image</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 py-1 text-xs rounded {{ $slide->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $slide->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $slide->sort_order }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="{{ route('admin.slides.edit', $slide->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                    <form action="{{ route('admin.slides.destroy', $slide->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No slides found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $slides->links() }}
</div>
@endsection

