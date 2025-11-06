<?php

namespace App\Services;

use App\Models\PageView;
use Illuminate\Support\Facades\DB;

class StatisticsService
{
    public function getUniqueVisitorsCount($startDate = null, $endDate = null)
    {
        $query = PageView::select('ip_address')
            ->distinct();

        if ($startDate) {
            $query->whereDate('viewed_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('viewed_at', '<=', $endDate);
        }

        return $query->count();
    }

    public function getPageViewsCount($startDate = null, $endDate = null)
    {
        $query = PageView::query();

        if ($startDate) {
            $query->whereDate('viewed_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('viewed_at', '<=', $endDate);
        }

        return $query->count();
    }

    public function getPageViewsByPath($startDate = null, $endDate = null, $limit = 10)
    {
        $query = PageView::select('page_path', DB::raw('COUNT(*) as views'))
            ->groupBy('page_path')
            ->orderBy('views', 'desc')
            ->limit($limit);

        if ($startDate) {
            $query->whereDate('viewed_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('viewed_at', '<=', $endDate);
        }

        return $query->get();
    }

    public function getViewsByDate($startDate = null, $endDate = null)
    {
        $query = PageView::select(
            DB::raw("DATE(viewed_at) as date"),
            DB::raw('COUNT(*) as views'),
            DB::raw('COUNT(DISTINCT ip_address) as unique_visitors')
        )
            ->groupBy(DB::raw("DATE(viewed_at)"))
            ->orderBy('date', 'asc');

        if ($startDate) {
            $query->whereDate('viewed_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('viewed_at', '<=', $endDate);
        }

        return $query->get();
    }
}

