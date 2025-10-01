<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use App\Services\CmsFormBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CmsController extends Controller
{
    public function index(Request $request)
    {
        $query = CmsPage::query();

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by template
        if ($request->filled('template') && $request->template !== 'all') {
            $query->where('template', $request->template);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $pages = $query->latest()->paginate(12);

        // Available templates
        $templates = CmsPage::getAvailableTemplates();

        // Statistics
        $stats = [
            'total_pages' => CmsPage::count(),
            'active_pages' => CmsPage::where('status', 'active')->count(),
            'inactive_pages' => CmsPage::where('status', 'inactive')->count(),
        ];

        return view('admin.cms.index', compact('pages', 'templates', 'stats'));
    }

    public function create()
    {
        $templates = CmsPage::getAvailableTemplates();
        return view('admin.cms.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'template' => 'required|string|max:50',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only([
            'title', 'template', 'meta_title',
            'meta_description', 'meta_keywords', 'status'
        ]);

        $data['slug'] = Str::slug($request->title);

        // Handle template data
        $template = $data['template'];

        if ($template === 'default') {
            // Default template uses content field
            $request->validate(['content' => 'required|string']);
            $data['content'] = $request->content;
            $data['template_data'] = null;
        } else {
            // Structured templates
            $data['content'] = ''; // Not used for structured templates

            switch ($template) {
                case 'faq':
                    $faqData = [];
                    $faqIndex = 0;
                    while ($request->has("faq.{$faqIndex}.question")) {
                        $faqData[] = [
                            'question' => $request->input("faq.{$faqIndex}.question"),
                            'answer' => $request->input("faq.{$faqIndex}.answer")
                        ];
                        $faqIndex++;
                    }

                    if (empty($faqData)) {
                        return back()->withErrors(['faq' => 'Minimal satu FAQ harus ditambahkan'])->withInput();
                    }

                    $data['template_data'] = ['faqs' => $faqData];
                    break;

                case 'contact':
                    $contactData = [
                        'hero_title' => $request->input('contact.hero_title'),
                        'hero_description' => $request->input('contact.hero_description'),
                        'phone' => $request->input('contact.phone'),
                        'email' => $request->input('contact.email'),
                        'address' => $request->input('contact.address')
                    ];
                    $data['template_data'] = $contactData;
                    break;

                case 'about':
                    $aboutData = [
                        'hero_title' => $request->input('about.hero_title'),
                        'hero_description' => $request->input('about.hero_description'),
                        'company_story' => $request->input('about.company_story')
                    ];
                    $data['template_data'] = $aboutData;
                    break;

                case 'terms':
                    $termsSections = [];
                    $sectionIndex = 0;
                    while ($request->has("terms.sections.{$sectionIndex}.title")) {
                        $termsSections[] = [
                            'title' => $request->input("terms.sections.{$sectionIndex}.title"),
                            'content' => $request->input("terms.sections.{$sectionIndex}.content")
                        ];
                        $sectionIndex++;
                    }

                    $termsData = [
                        'last_updated' => $request->input('terms.last_updated'),
                        'introduction' => $request->input('terms.introduction'),
                        'sections' => $termsSections
                    ];
                    $data['template_data'] = $termsData;
                    break;

                case 'privacy':
                    $privacySections = [];
                    $sectionIndex = 0;
                    while ($request->has("privacy.sections.{$sectionIndex}.title")) {
                        $privacySections[] = [
                            'title' => $request->input("privacy.sections.{$sectionIndex}.title"),
                            'content' => $request->input("privacy.sections.{$sectionIndex}.content")
                        ];
                        $sectionIndex++;
                    }

                    $privacyData = [
                        'effective_date' => $request->input('privacy.effective_date'),
                        'introduction' => $request->input('privacy.introduction'),
                        'sections' => $privacySections
                    ];
                    $data['template_data'] = $privacyData;
                    break;
            }
        }

        CmsPage::create($data);

        return redirect()->route('admin.cms.show', CmsPage::latest()->first())
            ->with('success', 'Halaman CMS berhasil dibuat');
    }

    public function show(CmsPage $page)
    {
        return view('admin.cms.show', compact('page'));
    }

    public function edit(CmsPage $page)
    {
        $templates = CmsPage::getAvailableTemplates();
        return view('admin.cms.edit', compact('page', 'templates'));
    }

    public function update(Request $request, CmsPage $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'template' => 'required|string|max:50',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only([
            'title', 'template', 'meta_title',
            'meta_description', 'meta_keywords', 'status'
        ]);

        // Update slug only if title changed
        if ($request->title !== $page->title) {
            $data['slug'] = Str::slug($request->title);
        }

        // Handle template data
        $template = $data['template'];

        if ($template === 'default') {
            // Default template uses content field
            $request->validate(['content' => 'required|string']);
            $data['content'] = $request->content;
            $data['template_data'] = null;
        } else {
            // Structured templates
            $data['content'] = ''; // Not used for structured templates

            switch ($template) {
                case 'faq':
                    $faqData = [];
                    $faqIndex = 0;
                    while ($request->has("faq.{$faqIndex}.question")) {
                        $faqData[] = [
                            'question' => $request->input("faq.{$faqIndex}.question"),
                            'answer' => $request->input("faq.{$faqIndex}.answer")
                        ];
                        $faqIndex++;
                    }

                    if (empty($faqData)) {
                        return back()->withErrors(['faq' => 'Minimal satu FAQ harus ditambahkan'])->withInput();
                    }

                    $data['template_data'] = ['faqs' => $faqData];
                    break;

                case 'contact':
                    $contactData = [
                        'hero_title' => $request->input('contact.hero_title'),
                        'hero_description' => $request->input('contact.hero_description'),
                        'phone' => $request->input('contact.phone'),
                        'email' => $request->input('contact.email'),
                        'address' => $request->input('contact.address')
                    ];
                    $data['template_data'] = $contactData;
                    break;

                case 'about':
                    $aboutData = [
                        'hero_title' => $request->input('about.hero_title'),
                        'hero_description' => $request->input('about.hero_description'),
                        'company_story' => $request->input('about.company_story')
                    ];
                    $data['template_data'] = $aboutData;
                    break;

                case 'terms':
                    $termsSections = [];
                    $sectionIndex = 0;
                    while ($request->has("terms.sections.{$sectionIndex}.title")) {
                        $termsSections[] = [
                            'title' => $request->input("terms.sections.{$sectionIndex}.title"),
                            'content' => $request->input("terms.sections.{$sectionIndex}.content")
                        ];
                        $sectionIndex++;
                    }

                    $termsData = [
                        'last_updated' => $request->input('terms.last_updated'),
                        'introduction' => $request->input('terms.introduction'),
                        'sections' => $termsSections
                    ];
                    $data['template_data'] = $termsData;
                    break;

                case 'privacy':
                    $privacySections = [];
                    $sectionIndex = 0;
                    while ($request->has("privacy.sections.{$sectionIndex}.title")) {
                        $privacySections[] = [
                            'title' => $request->input("privacy.sections.{$sectionIndex}.title"),
                            'content' => $request->input("privacy.sections.{$sectionIndex}.content")
                        ];
                        $sectionIndex++;
                    }

                    $privacyData = [
                        'effective_date' => $request->input('privacy.effective_date'),
                        'introduction' => $request->input('privacy.introduction'),
                        'sections' => $privacySections
                    ];
                    $data['template_data'] = $privacyData;
                    break;
            }
        }

        $page->update($data);

        return redirect()->route('admin.cms.show', $page)
            ->with('success', 'Halaman CMS berhasil diperbarui');
    }

    public function destroy(CmsPage $page)
    {
        $page->delete();

        return redirect()->route('admin.cms.index')
            ->with('success', 'Halaman CMS berhasil dihapus');
    }

    public function toggleStatus(CmsPage $page)
    {
        $page->update([
            'status' => $page->status === 'active' ? 'inactive' : 'active'
        ]);

        $message = $page->status === 'active' ? 'Halaman berhasil diaktifkan' : 'Halaman berhasil dinonaktifkan';

        return redirect()->back()->with('success', $message);
    }

    public function getTemplateFields($template)
    {
        $formBuilder = new CmsFormBuilder();
        $templateConfig = config("cms_templates.templates.{$template}");

        if (!$templateConfig || !isset($templateConfig['schema'])) {
            return response()->json(['error' => 'Template not found'], 404);
        }

        $html = $formBuilder->renderFields($templateConfig['schema']);

        return response()->json(['html' => $html]);
    }
}
