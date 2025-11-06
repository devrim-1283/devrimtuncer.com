<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Portfolio;
use App\Models\Message;
use App\Services\StatisticsService;

class DashboardController extends Controller
{
    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    public function index()
    {
        $stats = [
            'total_blogs' => Blog::count(),
            'active_blogs' => Blog::where('is_active', true)->count(),
            'total_portfolios' => Portfolio::count(),
            'active_portfolios' => Portfolio::where('is_active', true)->count(),
            'unread_messages' => Message::where('is_read', false)->count(),
            'total_messages' => Message::count(),
            'unique_visitors_today' => $this->statisticsService->getUniqueVisitorsCount(now()->startOfDay(), now()->endOfDay()),
            'page_views_today' => $this->statisticsService->getPageViewsCount(now()->startOfDay(), now()->endOfDay()),
        ];

        $recentMessages = Message::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentBlogs = Blog::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentMessages', 'recentBlogs'));
    }
}
