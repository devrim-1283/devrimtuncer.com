<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Support\Str;
use App\Services\MarkdownService;
use App\Traits\LogsActivity;

class BlogController extends Controller
{
    use LogsActivity;

    protected $markdownService;

    public function __construct(MarkdownService $markdownService)
    {
        $this->markdownService = $markdownService;
    }

    public function index()
    {
        $blogs = Blog::with('category', 'tags')
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = BlogCategory::where('is_active', true)->orderBy('sort_order')->get();
        $tags = BlogTag::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.blogs.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_tr' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'excerpt_tr' => 'nullable|string',
            'excerpt_en' => 'nullable|string',
            'content_tr' => 'required|string',
            'content_en' => 'required|string',
            'category_id' => 'nullable|exists:blog_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,id',
            'featured_image' => 'nullable|image|max:5120',
            'meta_title_tr' => 'nullable|string|max:255',
            'meta_title_en' => 'nullable|string|max:255',
            'meta_description_tr' => 'nullable|string',
            'meta_description_en' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer',
            'published_at' => 'nullable|date',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title_en']);
        }

        // Calculate reading time (average 200 words per minute)
        $wordCount = str_word_count(strip_tags($validated['content_en']));
        $validated['reading_time'] = max(1, ceil($wordCount / 200));

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = 'blog_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/uploads/blogs', $filename);
            $validated['featured_image'] = 'uploads/blogs/' . $filename;
        }

        $blog = Blog::create($validated);

        // Attach tags
        if ($request->has('tags')) {
            $blog->tags()->sync($request->tags);
        }

        // Log activity
        $this->logActivity('create', $blog, "Created blog: {$blog->title_en}");

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully');
    }

    public function show($id)
    {
        $blog = Blog::with('category', 'tags')->findOrFail($id);
        return view('admin.blogs.show', compact('blog'));
    }

    public function edit($id)
    {
        $blog = Blog::with('tags')->findOrFail($id);
        $categories = BlogCategory::where('is_active', true)->orderBy('sort_order')->get();
        $tags = BlogTag::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.blogs.edit', compact('blog', 'categories', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $oldValues = $blog->toArray();

        $validated = $request->validate([
            'title_tr' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug,' . $id,
            'excerpt_tr' => 'nullable|string',
            'excerpt_en' => 'nullable|string',
            'content_tr' => 'required|string',
            'content_en' => 'required|string',
            'category_id' => 'nullable|exists:blog_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,id',
            'featured_image' => 'nullable|image|max:5120',
            'meta_title_tr' => 'nullable|string|max:255',
            'meta_title_en' => 'nullable|string|max:255',
            'meta_description_tr' => 'nullable|string',
            'meta_description_en' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer',
            'published_at' => 'nullable|date',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title_en']);
        }

        // Calculate reading time
        $wordCount = str_word_count(strip_tags($validated['content_en']));
        $validated['reading_time'] = max(1, ceil($wordCount / 200));

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($blog->featured_image) {
                \Storage::disk('public')->delete($blog->featured_image);
            }

            $image = $request->file('featured_image');
            $filename = 'blog_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/uploads/blogs', $filename);
            $validated['featured_image'] = 'uploads/blogs/' . $filename;
        }

        $blog->update($validated);

        // Sync tags
        if ($request->has('tags')) {
            $blog->tags()->sync($request->tags);
        } else {
            $blog->tags()->detach();
        }

        // Log activity
        $this->logActivity('update', $blog, "Updated blog: {$blog->title_en}", $oldValues, $blog->fresh()->toArray());

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $title = $blog->title_en;

        // Delete featured image
        if ($blog->featured_image) {
            \Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        // Log activity
        $this->logActivity('delete', null, "Deleted blog: {$title}");

        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully');
    }
}
