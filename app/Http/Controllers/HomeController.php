<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Blog;
use App\Models\Portfolio;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->limit(10)
            ->get();

        $latestBlogs = Blog::where('is_active', true)
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        $featuredPortfolios = Portfolio::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->limit(6)
            ->get();

        return view('frontend.home', compact('slides', 'latestBlogs', 'featuredPortfolios'));
    }
}
