<?php

if (!function_exists('asset_with_version')) {
    /**
     * Generate asset URL with version for cache busting
     */
    function asset_with_version($path)
    {
        $filePath = public_path($path);
        
        if (file_exists($filePath)) {
            $timestamp = filemtime($filePath);
            return asset($path) . '?v=' . $timestamp;
        }
        
        return asset($path);
    }
}

if (!function_exists('storage_asset')) {
    /**
     * Generate storage asset URL with version for cache busting
     */
    function storage_asset($path)
    {
        $filePath = storage_path('app/public/' . $path);
        
        if (file_exists($filePath)) {
            $timestamp = filemtime($filePath);
            return asset('storage/' . $path) . '?v=' . $timestamp;
        }
        
        return asset('storage/' . $path);
    }
}

