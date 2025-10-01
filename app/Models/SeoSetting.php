<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    protected $fillable = [
        'page_type',
        'page_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'schema_ld',
        'og_title',
        'og_description',
        'og_image',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'noindex',
        'nofollow',
    ];

    protected $casts = [
        'schema_ld' => 'array',
        'noindex' => 'boolean',
        'nofollow' => 'boolean',
    ];

    /**
     * Get the owning page.
     */
    public function page()
    {
        return $this->morphTo();
    }

    /**
     * Get SEO settings by page type and ID
     */
    public function scopeForPage($query, $pageType, $pageId = null)
    {
        return $query->where('page_type', $pageType)
                    ->when($pageId, fn($q) => $q->where('page_id', $pageId));
    }
}
