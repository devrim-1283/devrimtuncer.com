<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StatisticsService;

class StatisticsController extends Controller
{
    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    public function index(Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $stats = [
            'unique_visitors' => $this->statisticsService->getUniqueVisitorsCount($startDate, $endDate),
            'total_views' => $this->statisticsService->getPageViewsCount($startDate, $endDate),
            'top_pages' => $this->statisticsService->getPageViewsByPath($startDate, $endDate, 10),
            'views_by_date' => $this->statisticsService->getViewsByDate($startDate, $endDate),
        ];

        return view('admin.statistics.index', compact('stats', 'startDate', 'endDate'));
    }
}
