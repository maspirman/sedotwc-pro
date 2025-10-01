<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class GeneralSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'is_active',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get setting value by key
     */
    public static function getValue(string $key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->where('is_active', true)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set setting value
     */
    public static function setValue(string $key, $value, string $type = 'text', string $group = 'general')
    {
        // Clear cache for this key
        Cache::forget("setting_{$key}");

        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'is_active' => true,
            ]
        );
    }

    /**
     * Get all settings for a group
     */
    public static function getGroup(string $group)
    {
        return Cache::remember("settings_group_{$group}", 3600, function () use ($group) {
            return static::where('group', $group)
                        ->where('is_active', true)
                        ->get()
                        ->pluck('value', 'key')
                        ->toArray();
        });
    }

    /**
     * Get all settings
     */
    public static function getAll()
    {
        return Cache::remember('all_settings', 3600, function () {
            return static::where('is_active', true)
                        ->get()
                        ->groupBy('group')
                        ->map(function ($settings) {
                            return $settings->pluck('value', 'key')->toArray();
                        })
                        ->toArray();
        });
    }

    /**
     * Clear all cache
     */
    public static function clearCache()
    {
        Cache::flush();
    }

    /**
     * Get social media links
     */
    public static function getSocialMedia()
    {
        return Cache::remember('social_media', 3600, function () {
            return static::where('group', 'social_media')
                        ->where('is_active', true)
                        ->get()
                        ->map(function ($setting) {
                            return [
                                'platform' => $setting->key,
                                'url' => $setting->value,
                                'description' => $setting->description,
                            ];
                        })
                        ->toArray();
        });
    }
}
