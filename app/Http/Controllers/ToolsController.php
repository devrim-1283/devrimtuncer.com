<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;

class ToolsController extends Controller
{
    public function index()
    {
        $tools = Tool::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('frontend.tools.index', compact('tools'));
    }
}
