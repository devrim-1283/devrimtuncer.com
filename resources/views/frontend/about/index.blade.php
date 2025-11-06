@extends('layouts.app')

@section('title', 'About - Devrim Tuncer')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-4xl font-bold mb-8">{{ __('messages.about') }}</h1>

    <!-- Personal Info -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h2 class="text-2xl font-semibold mb-4">Devrim Tuncer</h2>
        <div class="space-y-2 text-gray-700">
            <p><strong>{{ __('messages.born') }}:</strong> 2004</p>
            <p><strong>{{ __('messages.education') }}:</strong> {{ __('messages.high_school_valedictorian') }}</p>
            <p><strong>{{ __('messages.current_study') }}:</strong> {{ __('messages.university') }}</p>
            <p><strong>{{ __('messages.project') }}:</strong> {{ __('messages.project_description') }}</p>
            <p><strong>{{ __('messages.office') }}:</strong> {{ __('messages.office_name') }}</p>
        </div>
        
        @if(isset($settings['linkedin_url']) && $settings['linkedin_url'])
        <div class="mt-4">
            <a href="{{ $settings['linkedin_url'] }}" target="_blank" class="text-blue-600 hover:underline">{{ __('messages.linkedin_profile') }} →</a>
        </div>
        @endif

        @if(isset($settings['cv_file']) && $settings['cv_file'])
        <div class="mt-4">
            <a href="{{ storage_asset($settings['cv_file']) }}" download class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                {{ __('messages.download_cv') }}
            </a>
        </div>
        @endif
    </div>

    <!-- Education Timeline -->
    @if($education->count() > 0)
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h2 class="text-2xl font-semibold mb-6">{{ __('messages.education') }}</h2>
        <div class="space-y-6">
            @foreach($education as $edu)
            <div class="border-l-4 border-blue-500 pl-4">
                <h3 class="text-xl font-semibold">{{ $edu->institution }}</h3>
                <p class="text-gray-600">{{ $edu->degree }}</p>
                @if($edu->field_of_study)
                <p class="text-gray-500">{{ $edu->field_of_study }}</p>
                @endif
                <p class="text-sm text-gray-500 mt-2">
                    {{ $edu->start_date->format('Y') }} - {{ $edu->end_date ? $edu->end_date->format('Y') : __('messages.present') }}
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
        <h2 class="text-2xl font-semibold mb-6">{{ __('messages.experience') }}</h2>
        <div class="space-y-6">
            @foreach($experiences as $exp)
            <div class="border-l-4 border-green-500 pl-4">
                <h3 class="text-xl font-semibold">{{ $exp->job_title }}</h3>
                @if($exp->company)
                <p class="text-gray-600">{{ $exp->company }}</p>
                @endif
                <p class="text-sm text-gray-500 mt-2">
                    {{ $exp->start_date->format('M Y') }} - {{ $exp->end_date ? $exp->end_date->format('M Y') : __('messages.present') }}
                    @if(!$exp->is_active && $exp->end_date)
                    <span class="text-red-600">({{ __('messages.ended') }})</span>
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
            <h2 class="text-2xl font-semibold mb-4">{{ __('messages.vision') }}</h2>
            <p class="text-gray-700">{{ $settings['vision_' . app()->getLocale()] }}</p>
        </div>
        @endif

        @if(isset($settings['mission_' . app()->getLocale()]))
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-semibold mb-4">{{ __('messages.mission') }}</h2>
            <p class="text-gray-700">{{ $settings['mission_' . app()->getLocale()] }}</p>
        </div>
        @endif
    </div>
    @endif

    <!-- Why Me -->
    @if(isset($settings['why_me_' . app()->getLocale()]))
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-semibold mb-4">{{ __('messages.why_me') }}</h2>
        <div class="prose max-w-none">
            {!! nl2br(e($settings['why_me_' . app()->getLocale()])) !!}
        </div>
    </div>
    @endif

    <!-- Tax Certificate -->
    <div class="mt-8 text-center">
        <img src="{{ asset('vergi.png') }}?v={{ time() }}" alt="{{ __('messages.tax_certificate') }}" class="mx-auto max-w-md rounded-xl shadow-lg">
    </div>

    <!-- Gallery Section with Masonry Layout -->
    @if($galleries->count() > 0)
    <div class="mt-20">
        <h2 class="text-3xl font-bold mb-8 text-center bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
            {{ app()->getLocale() === 'tr' ? 'Galeri' : 'Gallery' }}
        </h2>
        <div id="masonry-container" class="masonry-grid">
            @foreach($galleries as $index => $gallery)
            <div class="masonry-item" data-index="{{ $index }}" data-height="{{ rand(250, 600) }}">
                <div class="masonry-item-inner">
                    <img src="{{ storage_asset($gallery->image) }}" alt="{{ $gallery->name }}" class="masonry-image">
                    <div class="masonry-overlay">
                        <div class="masonry-content">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $gallery->name }}</h3>
                            @if($gallery->description)
                            <p class="text-sm text-gray-200">{{ $gallery->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    .masonry-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px 0;
    }

    @media (min-width: 400px) {
        .masonry-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 600px) {
        .masonry-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (min-width: 1000px) {
        .masonry-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (min-width: 1500px) {
        .masonry-grid {
            grid-template-columns: repeat(5, 1fr);
        }
    }

    .masonry-item {
        opacity: 0;
        transform: translateY(100px);
        filter: blur(10px);
        transition: opacity 0.8s ease, transform 0.8s ease, filter 0.8s ease;
        will-change: opacity, transform, filter;
    }

    .masonry-item.loaded {
        opacity: 1;
        transform: translateY(0);
        filter: blur(0);
    }

    .masonry-item-inner {
        position: relative;
        height: 100%;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .masonry-item-inner:hover {
        transform: scale(0.95);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .masonry-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .masonry-item-inner:hover .masonry-image {
        transform: scale(1.1);
    }

    .masonry-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: flex-end;
        padding: 20px;
    }

    .masonry-item-inner:hover .masonry-overlay {
        opacity: 1;
    }

    .masonry-content {
        transform: translateY(20px);
        transition: transform 0.3s ease;
    }

    .masonry-item-inner:hover .masonry-content {
        transform: translateY(0);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const masonryItems = document.querySelectorAll('.masonry-item');
    
    // Preload all images
    const imageUrls = Array.from(masonryItems).map(item => {
        const img = item.querySelector('.masonry-image');
        return img ? img.src : null;
    }).filter(Boolean);

    let imagesLoaded = 0;
    const totalImages = imageUrls.length;

    function checkAllImagesLoaded() {
        if (imagesLoaded === totalImages) {
            animateMasonryItems();
        }
    }

    imageUrls.forEach(url => {
        const img = new Image();
        img.onload = img.onerror = () => {
            imagesLoaded++;
            checkAllImagesLoaded();
        };
        img.src = url;
    });

    function animateMasonryItems() {
        masonryItems.forEach((item, index) => {
            const height = item.getAttribute('data-height');
            if (height) {
                item.style.height = height + 'px';
            }

            setTimeout(() => {
                item.classList.add('loaded');
            }, index * 50);
        });
    }

    // If no images, still animate
    if (totalImages === 0) {
        animateMasonryItems();
    }
});
</script>
@endpush
@endsection

