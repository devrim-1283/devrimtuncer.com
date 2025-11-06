@extends('layouts.app')

@section('title', 'About - Devrim Tuncer')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-4xl font-bold mb-8">About Me</h1>

    <!-- Personal Info -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h2 class="text-2xl font-semibold mb-4">Devrim Tuncer</h2>
        <div class="space-y-2 text-gray-700">
            <p><strong>Born:</strong> 2004</p>
            <p><strong>Education:</strong> High School Valedictorian</p>
            <p><strong>Current Study:</strong> Alanya Alaaddin Keykubat University</p>
            <p><strong>Project:</strong> Alanya Tekmer project approved on 01.11.2025</p>
            <p><strong>Office:</strong> Alanya Teknoloji Geliştirme Arge Anonim Şirketi</p>
        </div>
        
        @if(isset($settings['linkedin_url']) && $settings['linkedin_url'])
        <div class="mt-4">
            <a href="{{ $settings['linkedin_url'] }}" target="_blank" class="text-blue-600 hover:underline">LinkedIn Profile →</a>
        </div>
        @endif

        @if(isset($settings['cv_file']) && $settings['cv_file'])
        <div class="mt-4">
            <a href="{{ asset('storage/' . $settings['cv_file']) }}" download class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Download CV
            </a>
        </div>
        @endif
    </div>

    <!-- Education Timeline -->
    @if($education->count() > 0)
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h2 class="text-2xl font-semibold mb-6">Education</h2>
        <div class="space-y-6">
            @foreach($education as $edu)
            <div class="border-l-4 border-blue-500 pl-4">
                <h3 class="text-xl font-semibold">{{ $edu->institution }}</h3>
                <p class="text-gray-600">{{ $edu->degree }}</p>
                @if($edu->field_of_study)
                <p class="text-gray-500">{{ $edu->field_of_study }}</p>
                @endif
                <p class="text-sm text-gray-500 mt-2">
                    {{ $edu->start_date->format('Y') }} - {{ $edu->end_date ? $edu->end_date->format('Y') : 'Present' }}
                </p>
                @if($edu->achievement)
                <p class="text-green-600 font-semibold mt-2">{{ $edu->achievement }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Experience Timeline -->
    @if($experiences->count() > 0)
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h2 class="text-2xl font-semibold mb-6">Experience</h2>
        <div class="space-y-6">
            @foreach($experiences as $exp)
            <div class="border-l-4 border-green-500 pl-4">
                <h3 class="text-xl font-semibold">{{ $exp->job_title }}</h3>
                @if($exp->company)
                <p class="text-gray-600">{{ $exp->company }}</p>
                @endif
                <p class="text-sm text-gray-500 mt-2">
                    {{ $exp->start_date->format('M Y') }} - {{ $exp->end_date ? $exp->end_date->format('M Y') : 'Present' }}
                    @if(!$exp->is_active && $exp->end_date)
                    <span class="text-red-600">(Ended)</span>
                    @endif
                </p>
                @if($exp->description)
                <p class="text-gray-700 mt-2">{{ $exp->description }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Vision & Mission -->
    @if(isset($settings['vision_' . app()->getLocale()]) || isset($settings['mission_' . app()->getLocale()]))
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        @if(isset($settings['vision_' . app()->getLocale()]))
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-semibold mb-4">Vision</h2>
            <p class="text-gray-700">{{ $settings['vision_' . app()->getLocale()] }}</p>
        </div>
        @endif

        @if(isset($settings['mission_' . app()->getLocale()]))
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-semibold mb-4">Mission</h2>
            <p class="text-gray-700">{{ $settings['mission_' . app()->getLocale()] }}</p>
        </div>
        @endif
    </div>
    @endif

    <!-- Why Me -->
    @if(isset($settings['why_me_' . app()->getLocale()]))
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-semibold mb-4">Why Me?</h2>
        <div class="prose max-w-none">
            {!! nl2br(e($settings['why_me_' . app()->getLocale()])) !!}
        </div>
    </div>
    @endif

    <!-- Tax Certificate -->
    <div class="mt-8 text-center">
        <img src="{{ asset('vergi.png') }}" alt="Vergi Levhası" class="mx-auto max-w-md">
    </div>
</div>
@endsection

