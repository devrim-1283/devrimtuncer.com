<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Models\PortfolioTool;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $query = Portfolio::where('is_active', true)
            ->with('tools');

        // Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description_tr', 'like', '%' . $request->search . '%')
                ->orWhere('description_en', 'like', '%' . $request->search . '%');
        }

        // Type filter (real/demo)
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Tool filter
        if ($request->has('tool')) {
            $query->whereHas('tools', function ($q) use ($request) {
                $q->where('portfolio_tools.slug', $request->tool);
            });
        }

        // Sort
        $sort = $request->get('sort', 'date');
        switch ($sort) {
            case 'alphabetical':
                $query->orderBy('name', 'asc');
                break;
            case 'type':
                $query->orderBy('type', 'asc')->orderBy('name', 'asc');
                break;
            case 'date':
            default:
                $query->orderBy('completed_at', 'desc');
                break;
        }

        $perPage = config('app.portfolios_per_page', 12);
        $portfolios = $query->paginate($perPage);

        $tools = PortfolioTool::where('is_active', true)->orderBy('sort_order')->get();

        return view('frontend.portfolio.index', compact('portfolios', 'tools'));
    }

    public function show($id, $slug)
    {
        $portfolio = Portfolio::where('id', $id)
            ->where('slug', $slug)
            ->where('is_active', true)
            ->with('tools')
            ->firstOrFail();

        return view('frontend.portfolio.show', compact('portfolio'));
    }
}
