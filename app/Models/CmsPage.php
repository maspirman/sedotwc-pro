<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CmsPage extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
        'template',
        'template_data',
    ];

    protected $casts = [
        'template_data' => 'array',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });

        static::updating(function ($page) {
            if ($page->isDirty('title') && empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get active pages
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get inactive pages
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Get template configuration
     */
    public function getTemplateConfig()
    {
        $templates = config('cms_templates.templates', []);
        return $templates[$this->template] ?? null;
    }

    /**
     * Get template data value with default
     */
    public function getTemplateData($key, $default = null)
    {
        return data_get($this->template_data, $key, $default);
    }

    /**
     * Set template data value
     */
    public function setTemplateData($key, $value)
    {
        $data = $this->template_data ?? [];
        data_set($data, $key, $value);
        $this->template_data = $data;
    }

    /**
     * Check if page uses structured template data
     */
    public function usesStructuredData()
    {
        $config = $this->getTemplateConfig();
        return $config && isset($config['schema']);
    }

    /**
     * Get available templates
     */
    public static function getAvailableTemplates()
    {
        $templates = config('cms_templates.templates', []);
        return collect($templates)->map(function ($template, $key) {
            return [
                'key' => $key,
                'name' => $template['name'],
                'description' => $template['description'] ?? '',
            ];
        })->toArray();
    }

    /**
     * Get template name by key
     */
    public static function getTemplateName($key)
    {
        $templates = self::getAvailableTemplates();
        $template = collect($templates)->firstWhere('key', $key);
        return $template ? $template['name'] : 'Default';
    }

    /**
     * Get preview text for admin index
     */
    public function getPreviewText()
    {
        switch ($this->template) {
            case 'default':
                if ($this->content) {
                    $text = strip_tags($this->content);
                    return strlen($text) > 80 ? substr($text, 0, 80) . '...' : $text;
                }
                return 'Tidak ada konten';

            case 'faq':
                $faqs = $this->getTemplateData('faqs', []);
                $count = count($faqs);
                return $count > 0 ? "{$count} pertanyaan FAQ" : 'Belum ada FAQ';

            case 'contact':
                $phone = $this->getTemplateData('phone');
                $email = $this->getTemplateData('email');
                $address = $this->getTemplateData('address');

                $preview = [];
                if ($phone) $preview[] = "📞 {$phone}";
                if ($email) $preview[] = "✉️ {$email}";
                if ($address) {
                    $addr = strlen($address) > 30 ? substr($address, 0, 30) . '...' : $address;
                    $preview[] = "📍 " . $addr;
                }

                return !empty($preview) ? implode(' • ', $preview) : 'Informasi kontak belum lengkap';

            case 'about':
                $heroDesc = $this->getTemplateData('hero_description');
                $story = $this->getTemplateData('company_story');

                if ($heroDesc) {
                    $text = strip_tags($heroDesc);
                    return strlen($text) > 80 ? substr($text, 0, 80) . '...' : $text;
                } elseif ($story) {
                    $text = strip_tags($story);
                    return strlen($text) > 80 ? substr($text, 0, 80) . '...' : $text;
                }
                return 'Deskripsi perusahaan belum diisi';

            case 'terms':
                $sections = $this->getTemplateData('sections', []);
                $count = count($sections);
                $lastUpdated = $this->getTemplateData('last_updated');
                $preview = $count > 0 ? "{$count} bagian syarat" : 'Belum ada bagian';

                if ($lastUpdated) {
                    $preview .= " • Update: " . date('d/m/Y', strtotime($lastUpdated));
                }

                return $preview;

            case 'privacy':
                $sections = $this->getTemplateData('sections', []);
                $count = count($sections);
                $effectiveDate = $this->getTemplateData('effective_date');
                $preview = $count > 0 ? "{$count} bagian kebijakan" : 'Belum ada bagian';

                if ($effectiveDate) {
                    $preview .= " • Berlaku: " . date('d/m/Y', strtotime($effectiveDate));
                }

                return $preview;

            default:
                return 'Template tidak dikenal';
        }
    }
}
