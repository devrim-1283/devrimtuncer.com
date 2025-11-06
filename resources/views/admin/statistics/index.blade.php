@extends('layouts.admin')

@section('page-title', 'Statistics')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent mb-2">Statistics</h1>
    <p class="text-gray-600">View detailed analytics and visitor statistics</p>
</div>

<!-- Date Range Filter -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <form method="GET" action="{{ route('admin.statistics.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-calendar-alt mr-2 text-blue-600"></i>
                Start Date
            </label>
            <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-calendar-check mr-2 text-blue-600"></i>
                End Date
            </label>
            <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 font-semibold">
                <i class="fas fa-filter mr-2"></i>
                Filter
            </button>
        </div>
        <div class="flex items-end">
            <a href="{{ route('admin.statistics.index') }}" class="w-full px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-300 text-center font-semibold">
                <i class="fas fa-redo mr-2"></i>
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-3xl"></i>
            </div>
            <div class="text-right">
                <p class="text-white text-opacity-80 text-sm font-medium">Unique Visitors</p>
                <p class="text-4xl font-bold mt-1">{{ number_format($stats['unique_visitors']) }}</p>
            </div>
        </div>
        <div class="flex items-center text-white text-opacity-80 text-sm">
            <i class="fas fa-chart-line mr-2"></i>
            <span>Total unique IP addresses</span>
        </div>
    </div>

    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                <i class="fas fa-eye text-3xl"></i>
            </div>
            <div class="text-right">
                <p class="text-white text-opacity-80 text-sm font-medium">Total Page Views</p>
                <p class="text-4xl font-bold mt-1">{{ number_format($stats['total_views']) }}</p>
            </div>
        </div>
        <div class="flex items-center text-white text-opacity-80 text-sm">
            <i class="fas fa-chart-bar mr-2"></i>
            <span>Total page views in period</span>
        </div>
    </div>
</div>

<!-- Top Pages -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
        <h3 class="text-xl font-bold text-white flex items-center">
            <i class="fas fa-list-ol mr-3"></i>
            Top Pages
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        <i class="fas fa-link mr-2 text-blue-600"></i>
                        Page Path
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        <i class="fas fa-eye mr-2 text-blue-600"></i>
                        Views
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        <i class="fas fa-chart-bar mr-2 text-blue-600"></i>
                        Percentage
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @php
                    $totalViews = $stats['top_pages']->sum('views');
                @endphp
                @forelse($stats['top_pages'] as $index => $page)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-sm mr-3">
                                {{ $index + 1 }}
                            </span>
                            <span class="text-sm font-medium text-gray-900">{{ $page->page_path }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-semibold text-gray-900">{{ number_format($page->views) }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full" style="width: {{ $totalViews > 0 ? ($page->views / $totalViews * 100) : 0 }}%"></div>
                            </div>
                            <span class="text-sm font-semibold text-gray-600">{{ $totalViews > 0 ? number_format(($page->views / $totalViews * 100), 1) : 0 }}%</span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center">
                        <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500 font-medium">No data available for the selected period.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Views by Date Chart -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="bg-gradient-to-r from-teal-600 to-cyan-600 px-6 py-4">
        <h3 class="text-xl font-bold text-white flex items-center">
            <i class="fas fa-chart-area mr-3"></i>
            Views by Date
        </h3>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <i class="fas fa-calendar mr-2 text-blue-600"></i>
                            Date
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <i class="fas fa-eye mr-2 text-blue-600"></i>
                            Views
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <i class="fas fa-users mr-2 text-blue-600"></i>
                            Unique Visitors
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <i class="fas fa-chart-line mr-2 text-blue-600"></i>
                            Trend
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $previousViews = null;
                    @endphp
                    @forelse($stats['views_by_date'] as $view)
                    @php
                        $trend = null;
                        if ($previousViews !== null) {
                            if ($view->views > $previousViews) {
                                $trend = 'up';
                            } elseif ($view->views < $previousViews) {
                                $trend = 'down';
                            } else {
                                $trend = 'same';
                            }
                        }
                        $previousViews = $view->views;
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($view->date)->format('M d, Y') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-semibold text-gray-900">{{ number_format($view->views) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-semibold text-gray-900">{{ number_format($view->unique_visitors) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($trend === 'up')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                <i class="fas fa-arrow-up mr-1"></i>
                                Up
                            </span>
                            @elseif($trend === 'down')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                <i class="fas fa-arrow-down mr-1"></i>
                                Down
                            </span>
                            @elseif($trend === 'same')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                <i class="fas fa-minus mr-1"></i>
                                Same
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                <i class="fas fa-chart-line mr-1"></i>
                                Start
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500 font-medium">No data available for the selected period.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
