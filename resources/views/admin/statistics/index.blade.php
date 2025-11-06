@extends('layouts.admin')

@section('page-title', 'Statistics')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold">Statistics</h1>
</div>

<!-- Date Range Filter -->
<form method="GET" action="{{ route('admin.statistics.index') }}" class="mb-6 bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
            <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-4 py-2 border rounded-lg">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
            <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-4 py-2 border rounded-lg">
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Filter</button>
        </div>
    </div>
</form>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm font-medium mb-2">Unique Visitors</h3>
        <p class="text-3xl font-bold">{{ $stats['unique_visitors'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm font-medium mb-2">Total Page Views</h3>
        <p class="text-3xl font-bold">{{ $stats['total_views'] }}</p>
    </div>
</div>

<!-- Top Pages -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h3 class="text-xl font-semibold mb-4">Top Pages</h3>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Page Path</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Views</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($stats['top_pages'] as $page)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $page->page_path }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $page->views }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="px-6 py-4 text-center text-gray-500">No data available.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Views by Date Chart -->
<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-xl font-semibold mb-4">Views by Date</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Views</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unique Visitors</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($stats['views_by_date'] as $view)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $view->date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $view->views }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $view->unique_visitors }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">No data available.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

