<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(CmsPage $page)
    {
        // Only show active pages
        if ($page->status !== 'active') {
            abort(404);
        }

        // Determine which view to use based on template
        $view = $this->getTemplateView($page->template);

        return view($view, compact('page'));
    }

    /**
     * Get the appropriate view for the template
     */
    private function getTemplateView(string $template): string
    {
        $templateViews = [
            'default' => 'frontend.page.show',
            'faq' => 'frontend.page.faq',
            'contact' => 'frontend.page.contact',
            'about' => 'frontend.page.about',
            'terms' => 'frontend.page.terms',
            'privacy' => 'frontend.page.privacy',
        ];

        return $templateViews[$template] ?? 'frontend.page.show';
    }
}
