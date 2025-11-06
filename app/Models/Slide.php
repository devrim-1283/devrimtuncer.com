<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_tr',
        'title_en',
        'text_tr',
        'text_en',
        'image_desktop',
        'image_mobile',
        'link',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"title_{$locale}"} ?? $this->title_en;
    }

    public function getTextAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"text_{$locale}"} ?? $this->text_en;
    }
}
