<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company',
        'type',
        'description_tr',
        'description_en',
        'service_type',
        'image',
        'link',
        'slug',
        'is_active',
        'sort_order',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function tools()
    {
        return $this->belongsToMany(PortfolioTool::class, 'portfolio_tool_pivot');
    }

    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"description_{$locale}"} ?? $this->description_en;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
