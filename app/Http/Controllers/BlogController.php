<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Services\MarkdownService;

class BlogController extends Controller
{
    protected $markdownService;

    public function __construct(MarkdownService $markdownService)
    {
        $this->markdownService = $markdownService;
    }

    public function index(Request $request)
    {
        $query = Blog::where('is_active', true)
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc');

        // Category filter
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Tag filter
        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        $perPage = config('app.blogs_per_page', 9);
        $blogs = $query->paginate($perPage);

        $categories = BlogCategory::where('is_active', true)->orderBy('sort_order')->get();

        return view('frontend.blog.index', compact('blogs', 'categories'));
    }

    public function show($id, $slug)
    {
        $blog = Blog::where('id', $id)
            ->where('slug', $slug)
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->firstOrFail();

        // Increment view count
        $blog->increment('view_count');

        // Parse markdown content
        $blog->parsed_content = $this->markdownService->parse($blog->content);

        // Get related blogs
        $relatedBlogs = Blog::where('is_active', true)
            ->where('id', '!=', $blog->id)
            ->whereNotNull('published_at')
            ->where(function ($query) use ($blog) {
                if ($blog->category_id) {
                    $query->where('category_id', $blog->category_id);
                }
                if ($blog->tags->count() > 0) {
                    $query->orWhereHas('tags', function ($q) use ($blog) {
                        $q->whereIn('blog_tags.id', $blog->tags->pluck('id'));
                    });
                }
            })
            ->limit(3)
            ->get();

        return view('frontend.blog.show', compact('blog', 'relatedBlogs'));
    }
}
