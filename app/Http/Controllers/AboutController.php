<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Setting;

class AboutController extends Controller
{
    public function index()
    {
        $experiences = Experience::where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->get();

        $education = Education::where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->get();

        // Get settings
        $settings = [
            'linkedin_url' => Setting::get('linkedin_url'),
            'cv_file' => Setting::get('cv_file'),
            'vision_tr' => Setting::get('vision_tr'),
            'vision_en' => Setting::get('vision_en'),
            'mission_tr' => Setting::get('mission_tr'),
            'mission_en' => Setting::get('mission_en'),
            'why_me_tr' => Setting::get('why_me_tr'),
            'why_me_en' => Setting::get('why_me_en'),
        ];

        return view('frontend.about.index', compact('experiences', 'education', 'settings'));
    }
}
