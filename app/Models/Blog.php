<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title_tr',
        'title_en',
        'slug',
        'excerpt_tr',
        'excerpt_en',
        'content_tr',
        'content_en',
        'featured_image',
        'meta_title_tr',
        'meta_title_en',
        'meta_description_tr',
        'meta_description_en',
        'meta_keywords_tr',
        'meta_keywords_en',
        'reading_time',
        'view_count',
        'is_active',
        'is_featured',
        'sort_order',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_tag_pivot');
    }

    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"title_{$locale}"} ?? $this->title_en;
    }

    public function getExcerptAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"excerpt_{$locale}"} ?? $this->excerpt_en;
    }

    public function getContentAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"content_{$locale}"} ?? $this->content_en;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
