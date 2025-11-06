@extends('layouts.admin')

@section('page-title', 'Settings')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Settings</h1>

    <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf

        <h2 class="text-2xl font-semibold mb-4">Social Media Links</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Instagram URL</label>
                <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Twitter URL</label>
                <input type="url" name="twitter_url" value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">R10 URL</label>
                <input type="url" name="r10_url" value="{{ old('r10_url', $settings['r10_url'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Fiverr URL</label>
                <input type="url" name="fiverr_url" value="{{ old('fiverr_url', $settings['fiverr_url'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">LinkedIn URL</label>
                <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
        </div>

        <h2 class="text-2xl font-semibold mb-4">Contact Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $settings['phone'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp</label>
                <input type="text" name="whatsapp" value="{{ old('whatsapp', $settings['whatsapp'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $settings['email'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
        </div>

        <h2 class="text-2xl font-semibold mb-4">Location</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                <input type="text" name="location_address" value="{{ old('location_address', $settings['location_address'] ?? '') }}" placeholder="Alanya, Antalya" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Map URL (Google Maps Embed URL)</label>
                <input type="text" name="location_map_url" value="{{ old('location_map_url', $settings['location_map_url'] ?? '') }}" placeholder="https://www.google.com/maps/embed?pb=..." class="w-full px-4 py-2 border rounded-lg">
                <p class="text-sm text-gray-500 mt-1">Google Maps'te konumunuzu açın, "Paylaş" > "Haritayı yerleştir" > "HTML'yi kopyala" ile iframe src URL'sini alın</p>
            </div>
        </div>
        <div class="mb-8">
            <p class="text-sm text-gray-600 mb-2">Preview Map:</p>
            @if(isset($settings['location_map_url']) && $settings['location_map_url'])
            <div style="height: 300px; width: 100%; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
                <iframe src="{{ $settings['location_map_url'] }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            @else
            <p class="text-sm text-gray-400">Enter map URL to see preview</p>
            @endif
        </div>

        <h2 class="text-2xl font-semibold mb-4">CV File</h2>
        <div class="mb-8">
            @if(isset($settings['cv_file']) && $settings['cv_file'])
            <div class="mb-2">
                <p class="text-sm text-gray-600">Current CV: <a href="{{ asset('storage/' . $settings['cv_file']) }}" target="_blank" class="text-blue-600 hover:underline">View</a></p>
            </div>
            @endif
            <label class="block text-sm font-medium text-gray-700 mb-2">Upload New CV (PDF)</label>
            <input type="file" name="cv_file" accept=".pdf" class="w-full px-4 py-2 border rounded-lg">
        </div>

        <h2 class="text-2xl font-semibold mb-4">Vision & Mission</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Vision (TR)</label>
                <textarea name="vision_tr" rows="5" class="w-full px-4 py-2 border rounded-lg">{{ old('vision_tr', $settings['vision_tr'] ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Vision (EN)</label>
                <textarea name="vision_en" rows="5" class="w-full px-4 py-2 border rounded-lg">{{ old('vision_en', $settings['vision_en'] ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Mission (TR)</label>
                <textarea name="mission_tr" rows="5" class="w-full px-4 py-2 border rounded-lg">{{ old('mission_tr', $settings['mission_tr'] ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Mission (EN)</label>
                <textarea name="mission_en" rows="5" class="w-full px-4 py-2 border rounded-lg">{{ old('mission_en', $settings['mission_en'] ?? '') }}</textarea>
            </div>
        </div>

        <h2 class="text-2xl font-semibold mb-4">Why Me?</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Why Me? (TR)</label>
                <textarea name="why_me_tr" rows="8" class="w-full px-4 py-2 border rounded-lg">{{ old('why_me_tr', $settings['why_me_tr'] ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Why Me? (EN)</label>
                <textarea name="why_me_en" rows="8" class="w-full px-4 py-2 border rounded-lg">{{ old('why_me_en', $settings['why_me_en'] ?? '') }}</textarea>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Settings</button>
        </div>
    </form>

    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold mb-4">Backups</h2>
        <div class="flex space-x-4">
            <form action="{{ route('admin.backup.database') }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Backup Database
                </button>
            </form>
            <form action="{{ route('admin.backup.assets') }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Backup Assets
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

