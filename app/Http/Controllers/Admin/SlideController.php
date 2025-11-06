<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;
use App\Traits\LogsActivity;

class SlideController extends Controller
{
    use LogsActivity;
    public function index()
    {
        $slides = Slide::orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.slides.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_tr' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'text_tr' => 'nullable|string',
            'text_en' => 'nullable|string',
            'image_desktop' => 'required|image|max:5120',
            'image_mobile' => 'required|image|max:5120',
            'link' => 'nullable|url',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Handle image uploads
        if ($request->hasFile('image_desktop')) {
            $image = $request->file('image_desktop');
            $filename = 'slide_desktop_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/uploads/slides', $filename);
            $validated['image_desktop'] = 'uploads/slides/' . $filename;
        }

        if ($request->hasFile('image_mobile')) {
            $image = $request->file('image_mobile');
            $filename = 'slide_mobile_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/uploads/slides', $filename);
            $validated['image_mobile'] = 'uploads/slides/' . $filename;
        }

        $slide = Slide::create($validated);

        // Log activity
        $this->logActivity('create', $slide, "Created slide: {$slide->title_en ?? 'Slide #' . $slide->id}");

        return redirect()->route('admin.slides.index')->with('success', 'Slide created successfully');
    }

    public function show($id)
    {
        $slide = Slide::findOrFail($id);
        return view('admin.slides.show', compact('slide'));
    }

    public function edit($id)
    {
        $slide = Slide::findOrFail($id);
        return view('admin.slides.edit', compact('slide'));
    }

    public function update(Request $request, $id)
    {
        $slide = Slide::findOrFail($id);
        $oldValues = $slide->toArray();

        $validated = $request->validate([
            'title_tr' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'text_tr' => 'nullable|string',
            'text_en' => 'nullable|string',
            'image_desktop' => 'nullable|image|max:5120',
            'image_mobile' => 'nullable|image|max:5120',
            'link' => 'nullable|url',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Handle image uploads
        if ($request->hasFile('image_desktop')) {
            // Delete old image
            if ($slide->image_desktop) {
                \Storage::disk('public')->delete($slide->image_desktop);
            }

            $image = $request->file('image_desktop');
            $filename = 'slide_desktop_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/uploads/slides', $filename);
            $validated['image_desktop'] = 'uploads/slides/' . $filename;
        }

        if ($request->hasFile('image_mobile')) {
            // Delete old image
            if ($slide->image_mobile) {
                \Storage::disk('public')->delete($slide->image_mobile);
            }

            $image = $request->file('image_mobile');
            $filename = 'slide_mobile_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/uploads/slides', $filename);
            $validated['image_mobile'] = 'uploads/slides/' . $filename;
        }

        $slide->update($validated);

        // Log activity
        $this->logActivity('update', $slide, "Updated slide: {$slide->title_en ?? 'Slide #' . $slide->id}", $oldValues, $slide->fresh()->toArray());

        return redirect()->route('admin.slides.index')->with('success', 'Slide updated successfully');
    }

    public function destroy($id)
    {
        $slide = Slide::findOrFail($id);
        $title = $slide->title_en ?? 'Slide #' . $slide->id;

        // Delete images
        if ($slide->image_desktop) {
            \Storage::disk('public')->delete($slide->image_desktop);
        }
        if ($slide->image_mobile) {
            \Storage::disk('public')->delete($slide->image_mobile);
        }

        $slide->delete();

        // Log activity
        $this->logActivity('delete', null, "Deleted slide: {$title}");

        return redirect()->route('admin.slides.index')->with('success', 'Slide deleted successfully');
    }
}
