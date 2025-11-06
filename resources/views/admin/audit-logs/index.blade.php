@extends('layouts.admin')

@section('page-title', 'Audit Logs')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold">Audit Logs</h1>
</div>

<!-- Filters -->
<form method="GET" action="{{ route('admin.audit-logs.index') }}" class="mb-6 bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Action</label>
            <select name="action" class="w-full px-4 py-2 border rounded-lg">
                <option value="">All Actions</option>
                <option value="create" {{ request('action') === 'create' ? 'selected' : '' }}>Create</option>
                <option value="update" {{ request('action') === 'update' ? 'selected' : '' }}>Update</option>
                <option value="delete" {{ request('action') === 'delete' ? 'selected' : '' }}>Delete</option>
                <option value="login" {{ request('action') === 'login' ? 'selected' : '' }}>Login</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Model Type</label>
            <select name="model_type" class="w-full px-4 py-2 border rounded-lg">
                <option value="">All Models</option>
                <option value="Blog" {{ request('model_type') === 'Blog' ? 'selected' : '' }}>Blog</option>
                <option value="Portfolio" {{ request('model_type') === 'Portfolio' ? 'selected' : '' }}>Portfolio</option>
                <option value="Slide" {{ request('model_type') === 'Slide' ? 'selected' : '' }}>Slide</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="w-full px-4 py-2 border rounded-lg">
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Filter</button>
        </div>
    </div>
</form>

<!-- Logs Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Model</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($logs as $log)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ $log->user->name ?? 'System' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">{{ $log->action }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $log->model_type ? $log->model_type . ' #' . $log->model_id : '-' }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ $log->description ?? '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $log->created_at->format('M d, Y H:i') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No logs found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $logs->links() }}
</div>
@endsection

