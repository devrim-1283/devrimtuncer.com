<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Portfolio;
use App\Models\SitemapCache;
use Illuminate\Support\Facades\Cache;

class SitemapService
{
    public function generate(): string
    {
        // Check cache first
        $cache = SitemapCache::first();
        if ($cache && $cache->last_updated->gt(now()->subHours(24))) {
            return $cache->sitemap_content;
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        $baseUrl = config('app.url');

        // Homepage
        $xml .= $this->url($baseUrl, now(), '1.0', 'daily');
        $xml .= $this->url($baseUrl . '/tr', now(), '1.0', 'daily');
        $xml .= $this->url($baseUrl . '/en', now(), '1.0', 'daily');

        // Blog posts
        $blogs = Blog::where('is_active', true)
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->get();

        foreach ($blogs as $blog) {
            $xml .= $this->url(
                $baseUrl . '/tr/blog/' . $blog->id . '/' . $blog->slug,
                $blog->updated_at,
                '0.8',
                'weekly'
            );
            $xml .= $this->url(
                $baseUrl . '/en/blog/' . $blog->id . '/' . $blog->slug,
                $blog->updated_at,
                '0.8',
                'weekly'
            );
        }

        // Portfolios
        $portfolios = Portfolio::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($portfolios as $portfolio) {
            $xml .= $this->url(
                $baseUrl . '/tr/portfolio/' . $portfolio->id . '/' . $portfolio->slug,
                $portfolio->updated_at,
                '0.8',
                'monthly'
            );
            $xml .= $this->url(
                $baseUrl . '/en/portfolio/' . $portfolio->id . '/' . $portfolio->slug,
                $portfolio->updated_at,
                '0.8',
                'monthly'
            );
        }

        // Static pages
        $pages = ['about', 'portfolio', 'tools', 'blog'];
        foreach ($pages as $page) {
            $xml .= $this->url($baseUrl . '/tr/' . $page, now(), '0.7', 'monthly');
            $xml .= $this->url($baseUrl . '/en/' . $page, now(), '0.7', 'monthly');
        }

        $xml .= '</urlset>';

        // Cache the sitemap
        SitemapCache::updateOrCreate(
            ['id' => 1],
            [
                'sitemap_content' => $xml,
                'last_updated' => now(),
            ]
        );

        return $xml;
    }

    protected function url(string $loc, $lastmod, string $priority, string $changefreq): string
    {
        $lastmod = is_string($lastmod) ? $lastmod : $lastmod->format('Y-m-d');
        return "  <url>\n" .
               "    <loc>{$loc}</loc>\n" .
               "    <lastmod>{$lastmod}</lastmod>\n" .
               "    <priority>{$priority}</priority>\n" .
               "    <changefreq>{$changefreq}</changefreq>\n" .
               "  </url>\n";
    }
}

