<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsActivity;

class SettingsController extends Controller
{
    use LogsActivity;
    public function index()
    {
        $settings = [
            'instagram_url' => Setting::get('instagram_url'),
            'twitter_url' => Setting::get('twitter_url'),
            'r10_url' => Setting::get('r10_url'),
            'fiverr_url' => Setting::get('fiverr_url'),
            'linkedin_url' => Setting::get('linkedin_url'),
            'phone' => Setting::get('phone'),
            'whatsapp' => Setting::get('whatsapp'),
            'email' => Setting::get('email'),
            'cv_file' => Setting::get('cv_file'),
            'location_address' => Setting::get('location_address'),
            'location_map_url' => Setting::get('location_map_url'),
            'vision_tr' => Setting::get('vision_tr'),
            'vision_en' => Setting::get('vision_en'),
            'mission_tr' => Setting::get('mission_tr'),
            'mission_en' => Setting::get('mission_en'),
            'why_me_tr' => Setting::get('why_me_tr'),
            'why_me_en' => Setting::get('why_me_en'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'instagram_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'r10_url' => 'nullable|url',
            'fiverr_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'cv_file' => 'nullable|file|mimes:pdf|max:10240',
            'location_address' => 'nullable|string|max:500',
            'location_map_url' => 'nullable|string|max:2000',
            'vision_tr' => 'nullable|string',
            'vision_en' => 'nullable|string',
            'mission_tr' => 'nullable|string',
            'mission_en' => 'nullable|string',
            'why_me_tr' => 'nullable|string',
            'why_me_en' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            if ($key === 'cv_file' && $request->hasFile('cv_file')) {
                $file = $request->file('cv_file');
                $filename = 'cv_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/cv', $filename);
                Setting::set('cv_file', 'cv/' . $filename, 'file');
            } elseif ($key !== 'cv_file') {
                Setting::set($key, $value);
            }
        }

        // Log activity
        $this->logActivity('update', null, 'Settings updated');

        return back()->with('success', 'Settings updated successfully');
    }
}
