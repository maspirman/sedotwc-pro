<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $fillable = [
        'section',
        'key',
        'value',
        'type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get setting value by section and key
     */
    public static function getValue(string $section, string $key, $default = null)
    {
        $setting = static::where('section', $section)
                        ->where('key', $key)
                        ->where('is_active', true)
                        ->first();

        return $setting ? $setting->value : $default;
    }

    /**
     * Set setting value
     */
    public static function setValue(string $section, string $key, $value, string $type = 'text')
    {
        return static::updateOrCreate(
            ['section' => $section, 'key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'is_active' => true,
            ]
        );
    }

    /**
     * Get all settings for a section
     */
    public static function getSection(string $section)
    {
        return static::where('section', $section)
                    ->where('is_active', true)
                    ->get()
                    ->pluck('value', 'key')
                    ->toArray();
    }
}
