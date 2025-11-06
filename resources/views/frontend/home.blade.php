@extends('layouts.app')

@section('title', 'Home - Devrim Tuncer')

@section('content')
<div class="min-h-screen">
    <!-- Slides Section -->
    @if($slides->count() > 0)
    <div class="relative h-screen overflow-hidden">
        @if($slides->count() === 1)
            <div class="absolute inset-0">
                <img src="{{ storage_asset($slides->first()->image_desktop) }}" alt="{{ $slides->first()->title }}" class="hidden md:block w-full h-full object-cover">
                <img src="{{ storage_asset($slides->first()->image_mobile) }}" alt="{{ $slides->first()->title }}" class="md:hidden w-full h-full object-cover">
                @if($slides->first()->text)
                <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="text-center text-white px-4">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $slides->first()->title }}</h1>
                        <p class="text-xl md:text-2xl">{{ $slides->first()->text }}</p>
                    </div>
                </div>
                @endif
            </div>
        @else
            <div id="slideCarousel" class="relative h-full">
                @foreach($slides as $index => $slide)
                <div class="slide-item absolute inset-0 {{ $index === 0 ? 'active' : '' }}" style="transition: opacity 0.5s;">
                    <img src="{{ storage_asset($slide->image_desktop) }}" alt="{{ $slide->title }}" class="hidden md:block w-full h-full object-cover">
                    <img src="{{ storage_asset($slide->image_mobile) }}" alt="{{ $slide->title }}" class="md:hidden w-full h-full object-cover">
                    @if($slide->text)
                    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="text-center text-white px-4">
                            <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $slide->title }}</h1>
                            <p class="text-xl md:text-2xl">{{ $slide->text }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        @endif
    </div>
    @endif

    <!-- Latest Blogs Section -->
    @if($latestBlogs->count() > 0)
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-8">Latest Blog Posts</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($latestBlogs as $blog)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if($blog->featured_image)
                    <img src="{{ storage_asset($blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">
                            <a href="{{ route('blog.show', ['locale' => app()->getLocale(), 'id' => $blog->id, 'slug' => $blog->slug]) }}" class="hover:text-blue-600">
                                {{ $blog->title }}
                            </a>
                        </h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($blog->excerpt, 150) }}</p>
                        <a href="{{ route('blog.show', ['locale' => app()->getLocale(), 'id' => $blog->id, 'slug' => $blog->slug]) }}" class="text-blue-600 hover:underline">Read More →</a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('blog.index', ['locale' => app()->getLocale()]) }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    View All Blogs
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Featured Portfolios Section -->
    @if($featuredPortfolios->count() > 0)
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-8">Featured Portfolios</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($featuredPortfolios as $portfolio)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if($portfolio->image)
                    <img src="{{ storage_asset($portfolio->image) }}" alt="{{ $portfolio->name }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xl font-semibold">{{ $portfolio->name }}</h3>
                            <span class="px-2 py-1 text-xs rounded {{ $portfolio->type === 'real' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $portfolio->type === 'real' ? 'Real Project' : 'Demo' }}
                            </span>
                        </div>
                        <p class="text-gray-600 mb-4">{{ Str::limit($portfolio->description, 150) }}</p>
                        <a href="{{ route('portfolio.show', ['locale' => app()->getLocale(), 'id' => $portfolio->id, 'slug' => $portfolio->slug]) }}" class="text-blue-600 hover:underline">View Details →</a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('portfolio.index', ['locale' => app()->getLocale()]) }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    View All Portfolios
                </a>
            </div>
        </div>
    </section>
    @endif
</div>

@push('scripts')
@if($slides->count() > 1)
<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide-item');
    const totalSlides = slides.length;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.remove('active');
            slide.style.opacity = '0';
        });
        
        slides[index].classList.add('active');
        slides[index].style.opacity = '1';
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }

    // Auto-advance slides every 3 seconds
    setInterval(nextSlide, 3000);

    // Initialize first slide
    showSlide(0);
</script>
@endif
@endpush
@endsection

