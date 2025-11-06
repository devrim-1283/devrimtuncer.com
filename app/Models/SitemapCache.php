<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitemapCache extends Model
{
    use HasFactory;

    protected $fillable = [
        'sitemap_content',
        'last_updated',
    ];

    protected $casts = [
        'last_updated' => 'datetime',
    ];
}
