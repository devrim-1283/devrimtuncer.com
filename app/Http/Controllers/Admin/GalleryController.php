<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Traits\LogsActivity;

class GalleryController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $galleries = Gallery::orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tag' => 'nullable|string|max:255',
            'image' => 'required|image|max:5120',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Handle image upload - uploads klasörüne kaydet
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'gallery_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/uploads/galleries', $filename);
            $validated['image'] = 'uploads/galleries/' . $filename;
        }

        $gallery = Gallery::create($validated);

        // Log activity
        $this->logActivity('create', $gallery, "Created gallery item: {$gallery->name}");

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery item created successfully');
    }

    public function show($id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('admin.galleries.show', compact('gallery'));
    }

    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);
        $oldValues = $gallery->toArray();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tag' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($gallery->image) {
                \Storage::disk('public')->delete($gallery->image);
            }

            $image = $request->file('image');
            $filename = 'gallery_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/uploads/galleries', $filename);
            $validated['image'] = 'uploads/galleries/' . $filename;
        }

        $gallery->update($validated);

        // Log activity
        $this->logActivity('update', $gallery, "Updated gallery item: {$gallery->name}", $oldValues, $gallery->fresh()->toArray());

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery item updated successfully');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $name = $gallery->name;

        // Delete image
        if ($gallery->image) {
            \Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        // Log activity
        $this->logActivity('delete', null, "Deleted gallery item: {$name}");

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery item deleted successfully');
    }
}

