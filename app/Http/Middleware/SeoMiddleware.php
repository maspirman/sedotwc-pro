<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\SeoSetting;

class SeoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only apply to HTML responses
        if ($response->headers->get('Content-Type') &&
            !str_contains($response->headers->get('Content-Type'), 'text/html')) {
            return $response;
        }

        // Get content
        $content = $response->getContent();

        // Apply SEO optimizations
        $content = $this->applySeoSettings($request, $content);
        $content = $this->optimizePageSpeed($content);
        $content = $this->minifyHtml($content);

        $response->setContent($content);

        return $response;
    }

    /**
     * Apply SEO settings based on current route
     */
    private function applySeoSettings(Request $request, string $content): string
    {
        $currentRoute = Route::current();
        if (!$currentRoute) {
            return $content;
        }

        $seoSetting = $this->getSeoSettingForRoute($currentRoute, $request);

        if (!$seoSetting) {
            return $content;
        }

        // Replace meta tags
        $content = $this->replaceMetaTags($content, $seoSetting);

        // Add schema.org JSON-LD if present
        if ($seoSetting->schema_ld) {
            $content = $this->addSchemaLd($content, $seoSetting->schema_ld);
        }

        return $content;
    }

    /**
     * Get SEO setting for current route
     */
    private function getSeoSettingForRoute($route, Request $request): ?SeoSetting
    {
        $routeName = $route->getName();

        // Map route names to page types
        $routeMappings = [
            'home' => ['page_type' => 'home', 'page_id' => null],
            'services.index' => ['page_type' => 'home', 'page_id' => null], // Services listing
            'services.show' => ['page_type' => 'services', 'page_id' => $request->route('service')?->id],
            'blog.index' => ['page_type' => 'home', 'page_id' => null], // Blog listing
            'blog.show' => ['page_type' => 'blogs', 'page_id' => $request->route('blog')?->id],
            'page.show' => ['page_type' => 'cms_pages', 'page_id' => $request->route('page')?->id],
        ];

        if (isset($routeMappings[$routeName])) {
            $mapping = $routeMappings[$routeName];
            return SeoSetting::where('page_type', $mapping['page_type'])
                           ->where('page_id', $mapping['page_id'])
                           ->first();
        }

        return null;
    }

    /**
     * Replace meta tags in HTML content
     */
    private function replaceMetaTags(string $content, SeoSetting $seoSetting): string
    {
        // Meta title
        if ($seoSetting->meta_title) {
            $content = preg_replace(
                '/<title[^>]*>.*?<\/title>/is',
                '<title>' . htmlspecialchars($seoSetting->meta_title) . '</title>',
                $content
            );
        }

        // Meta description
        if ($seoSetting->meta_description) {
            if (preg_match('/<meta[^>]*name=["\']description["\'][^>]*>/i', $content)) {
                $content = preg_replace(
                    '/<meta[^>]*name=["\']description["\'][^>]*content=["\'][^"\']*["\'][^>]*>/i',
                    '<meta name="description" content="' . htmlspecialchars($seoSetting->meta_description) . '">',
                    $content
                );
            } else {
                // Add meta description if not exists
                $content = preg_replace(
                    '/(<title[^>]*>.*?<\/title>)/i',
                    '$1' . PHP_EOL . '    <meta name="description" content="' . htmlspecialchars($seoSetting->meta_description) . '">',
                    $content
                );
            }
        }

        // Meta keywords
        if ($seoSetting->meta_keywords) {
            if (preg_match('/<meta[^>]*name=["\']keywords["\'][^>]*>/i', $content)) {
                $content = preg_replace(
                    '/<meta[^>]*name=["\']keywords["\'][^>]*content=["\'][^"\']*["\'][^>]*>/i',
                    '<meta name="keywords" content="' . htmlspecialchars($seoSetting->meta_keywords) . '">',
                    $content
                );
            } else {
                $content = preg_replace(
                    '/(<meta[^>]*name=["\']description["\'][^>]*>)/i',
                    '$1' . PHP_EOL . '    <meta name="keywords" content="' . htmlspecialchars($seoSetting->meta_keywords) . '">',
                    $content
                );
            }
        }

        // Open Graph tags
        $ogTags = '';
        if ($seoSetting->og_title) {
            $ogTags .= '<meta property="og:title" content="' . htmlspecialchars($seoSetting->og_title) . '">' . PHP_EOL . '    ';
        }
        if ($seoSetting->og_description) {
            $ogTags .= '<meta property="og:description" content="' . htmlspecialchars($seoSetting->og_description) . '">' . PHP_EOL . '    ';
        }
        if ($seoSetting->og_image) {
            $ogTags .= '<meta property="og:image" content="' . htmlspecialchars($seoSetting->og_image) . '">' . PHP_EOL . '    ';
        }

        if ($ogTags) {
            // Replace existing OG tags or add new ones
            if (preg_match('/<meta[^>]*property=["\']og:title["\'][^>]*>/i', $content)) {
                // Replace existing OG tags block
                $content = preg_replace(
                    '/(\s*<meta[^>]*property=["\']og:[^"\']*["\'][^>]*>\s*)+/s',
                    PHP_EOL . '    ' . trim($ogTags),
                    $content
                );
            } else {
                // Add OG tags after existing meta tags
                $content = preg_replace(
                    '/(<meta[^>]*name=["\']description["\'][^>]*>)/i',
                    '$1' . PHP_EOL . '    ' . trim($ogTags),
                    $content
                );
            }
        }

        // Twitter Cards
        $twitterTags = '';
        if ($seoSetting->twitter_title) {
            $twitterTags .= '<meta name="twitter:title" content="' . htmlspecialchars($seoSetting->twitter_title) . '">' . PHP_EOL . '    ';
        }
        if ($seoSetting->twitter_description) {
            $twitterTags .= '<meta name="twitter:description" content="' . htmlspecialchars($seoSetting->twitter_description) . '">' . PHP_EOL . '    ';
        }
        if ($seoSetting->twitter_image) {
            $twitterTags .= '<meta name="twitter:image" content="' . htmlspecialchars($seoSetting->twitter_image) . '">' . PHP_EOL . '    ';
        }

        if ($twitterTags) {
            if (preg_match('/<meta[^>]*name=["\']twitter:title["\'][^>]*>/i', $content)) {
                $content = preg_replace(
                    '/(\s*<meta[^>]*name=["\']twitter:[^"\']*["\'][^>]*>\s*)+/s',
                    PHP_EOL . '    ' . trim($twitterTags),
                    $content
                );
            } else {
                $content = preg_replace(
                    '/(<meta[^>]*name=["\']description["\'][^>]*>)/i',
                    '$1' . PHP_EOL . '    ' . trim($twitterTags),
                    $content
                );
            }
        }

        // Robots directives
        $robotsContent = [];
        if ($seoSetting->noindex) {
            $robotsContent[] = 'noindex';
        }
        if ($seoSetting->nofollow) {
            $robotsContent[] = 'nofollow';
        }

        if (!empty($robotsContent)) {
            $robotsTag = '<meta name="robots" content="' . implode(', ', $robotsContent) . '">';
            if (preg_match('/<meta[^>]*name=["\']robots["\'][^>]*>/i', $content)) {
                $content = preg_replace(
                    '/<meta[^>]*name=["\']robots["\'][^>]*content=["\'][^"\']*["\'][^>]*>/i',
                    $robotsTag,
                    $content
                );
            } else {
                $content = preg_replace(
                    '/(<meta[^>]*name=["\']description["\'][^>]*>)/i',
                    '$1' . PHP_EOL . '    ' . $robotsTag,
                    $content
                );
            }
        }

        return $content;
    }

    /**
     * Add Schema.org JSON-LD structured data
     */
    private function addSchemaLd(string $content, array $schemaData): string
    {
        $jsonLd = json_encode($schemaData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $scriptTag = '<script type="application/ld+json">' . $jsonLd . '</script>';

        // Add before closing </head> tag
        if (preg_match('/<\/head>/i', $content)) {
            $content = preg_replace(
                '/<\/head>/i',
                '    ' . $scriptTag . PHP_EOL . '</head>',
                $content
            );
        }

        return $content;
    }

    /**
     * Apply page speed optimizations
     */
    private function optimizePageSpeed(string $content): string
    {
        // DISABLED: Defer non-critical CSS (causes malformed preload links)
        // $content = $this->deferCss($content);

        // Defer non-critical JavaScript
        $content = $this->deferJavaScript($content);

        // DISABLED: Add preload hints (causes malformed preload links)
        // $content = $this->addPreloadHints($content);

        return $content;
    }

    /**
     * Defer non-critical CSS
     */
    private function deferCss(string $content): string
    {
        // Convert non-critical CSS links to preload
        $content = preg_replace(
            '/<link[^>]*rel=["\']stylesheet["\'][^>]*(?!(>|.*?\smedia=["\'](?:print|screen|all)["\']))([^>]*>)/i',
            '<link rel="preload" href="' . preg_replace('/.*href=["\']([^"\']*)["\'].*/i', '$1', '$0') . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">$0<noscript>$0</noscript>',
            $content
        );

        return $content;
    }

    /**
     * Defer non-critical JavaScript
     */
    private function deferJavaScript(string $content): string
    {
        // Add defer to script tags that don't have async or defer
        $content = preg_replace(
            '/<script(?![^>]*\b(async|defer)\b)[^>]*src=["\'][^"\']*["\'][^>]*><\/script>/i',
            '$0', // Keep as is for now - defer might break some scripts
            $content
        );

        return $content;
    }

    /**
     * Add preload hints for critical resources
     */
    private function addPreloadHints(string $content): string
    {
        // Add preload for critical fonts
        $fontPreload = '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" as="style">';

        if (!preg_match('/fonts\.googleapis\.com\/css/', $content)) {
            $content = preg_replace(
                '/<head[^>]*>/i',
                '$0' . PHP_EOL . '    ' . $fontPreload,
                $content,
                1
            );
        }

        return $content;
    }

    /**
     * Minify HTML output
     */
    private function minifyHtml(string $content): string
    {
        // Remove comments (except IE conditional comments)
        $content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);

        // Remove whitespace between tags
        $content = preg_replace('/>\s+</', '><', $content);

        // Remove leading/trailing whitespace
        $content = trim($content);

        return $content;
    }
}
