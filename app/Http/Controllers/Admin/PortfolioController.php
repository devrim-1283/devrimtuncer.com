<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Models\PortfolioTool;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;

class PortfolioController extends Controller
{
    use LogsActivity;
    public function index()
    {
        $portfolios = Portfolio::with('tools')
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        $tools = PortfolioTool::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.portfolios.create', compact('tools'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'type' => 'required|in:real,demo',
            'description_tr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'service_type' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
            'link' => 'nullable|url',
            'slug' => 'nullable|string|max:255|unique:portfolios,slug',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
            'completed_at' => 'nullable|date',
            'tools' => 'nullable|array',
            'tools.*' => 'exists:portfolio_tools,id',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'portfolio_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/uploads/portfolios', $filename);
            $validated['image'] = 'uploads/portfolios/' . $filename;
        }

        $portfolio = Portfolio::create($validated);

        // Attach tools
        if ($request->has('tools')) {
            $portfolio->tools()->sync($request->tools);
        }

        // Log activity
        $this->logActivity('create', $portfolio, "Created portfolio: {$portfolio->name}");

        return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio created successfully');
    }

    public function show($id)
    {
        $portfolio = Portfolio::with('tools')->findOrFail($id);
        return view('admin.portfolios.show', compact('portfolio'));
    }

    public function edit($id)
    {
        $portfolio = Portfolio::with('tools')->findOrFail($id);
        $tools = PortfolioTool::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.portfolios.edit', compact('portfolio', 'tools'));
    }

    public function update(Request $request, $id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $oldValues = $portfolio->toArray();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'type' => 'required|in:real,demo',
            'description_tr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'service_type' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
            'link' => 'nullable|url',
            'slug' => 'nullable|string|max:255|unique:portfolios,slug,' . $id,
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
            'completed_at' => 'nullable|date',
            'tools' => 'nullable|array',
            'tools.*' => 'exists:portfolio_tools,id',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($portfolio->image) {
                \Storage::disk('public')->delete($portfolio->image);
            }

            $image = $request->file('image');
            $filename = 'portfolio_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/uploads/portfolios', $filename);
            $validated['image'] = 'uploads/portfolios/' . $filename;
        }

        $portfolio->update($validated);

        // Sync tools
        if ($request->has('tools')) {
            $portfolio->tools()->sync($request->tools);
        } else {
            $portfolio->tools()->detach();
        }

        // Log activity
        $this->logActivity('update', $portfolio, "Updated portfolio: {$portfolio->name}", $oldValues, $portfolio->fresh()->toArray());

        return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio updated successfully');
    }

    public function destroy($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $name = $portfolio->name;

        // Delete image
        if ($portfolio->image) {
            \Storage::disk('public')->delete($portfolio->image);
        }

        $portfolio->delete();

        // Log activity
        $this->logActivity('delete', null, "Deleted portfolio: {$name}");

        return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio deleted successfully');
    }
}
