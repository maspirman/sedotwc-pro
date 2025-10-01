<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        // Get current settings
        $heroSettings = HomeSetting::getSection('hero');
        $aboutSettings = HomeSetting::getSection('about');
        $statsSettings = HomeSetting::getSection('stats');
        $ctaSettings = HomeSetting::getSection('cta');

        return view('admin.home.index', compact(
            'heroSettings',
            'aboutSettings',
            'statsSettings',
            'ctaSettings'
        ));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            // Hero Section
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'nullable|string|max:500',
            'hero_description' => 'required|string',
            'hero_badge' => 'nullable|string|max:100',
            'hero_emergency_phone' => 'nullable|string|max:20',
            'hero_whatsapp' => 'nullable|string|max:20',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // About Section
            'about_title' => 'required|string|max:255',
            'about_description' => 'required|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Stats Section
            'stats_pelanggan_puas' => 'required|integer|min:0',
            'stats_layanan_24jam' => 'nullable|string|max:50',
            'stats_tahun_pengalaman' => 'required|integer|min:0',
            'stats_rating_google' => 'required|numeric|min:0|max:5',

            // CTA Section
            'cta_title' => 'required|string|max:255',
            'cta_description' => 'required|string',
            'cta_emergency_badge' => 'nullable|string|max:100',

            // Image deletion flags
            'delete_hero_image' => 'nullable|boolean',
            'delete_about_image' => 'nullable|boolean',
        ]);

        try {
            // Handle image deletions
            if ($request->boolean('delete_hero_image')) {
                $currentHeroImage = HomeSetting::getValue('hero', 'image');
                if ($currentHeroImage) {
                    Storage::disk('public')->delete($currentHeroImage);
                    HomeSetting::where('section', 'hero')->where('key', 'image')->delete();
                }
            }

            if ($request->boolean('delete_about_image')) {
                $currentAboutImage = HomeSetting::getValue('about', 'image');
                if ($currentAboutImage) {
                    Storage::disk('public')->delete($currentAboutImage);
                    HomeSetting::where('section', 'about')->where('key', 'image')->delete();
                }
            }

            // Handle file uploads
            if ($request->hasFile('hero_image')) {
                $heroImagePath = $request->file('hero_image')->store('hero', 'public');
                HomeSetting::setValue('hero', 'image', $heroImagePath, 'image');
            }

            if ($request->hasFile('about_image')) {
                $aboutImagePath = $request->file('about_image')->store('about', 'public');
                HomeSetting::setValue('about', 'image', $aboutImagePath, 'image');
            }

            // Save hero settings
            HomeSetting::setValue('hero', 'title', $request->hero_title);
            HomeSetting::setValue('hero', 'subtitle', $request->hero_subtitle);
            HomeSetting::setValue('hero', 'description', $request->hero_description);
            HomeSetting::setValue('hero', 'badge', $request->hero_badge);
            HomeSetting::setValue('hero', 'emergency_phone', $request->hero_emergency_phone);
            HomeSetting::setValue('hero', 'whatsapp', $request->hero_whatsapp);

            // Save about settings
            HomeSetting::setValue('about', 'title', $request->about_title);
            HomeSetting::setValue('about', 'description', $request->about_description);

            // Save stats settings
            HomeSetting::setValue('stats', 'pelanggan_puas', $request->stats_pelanggan_puas, 'number');
            HomeSetting::setValue('stats', 'layanan_24jam', $request->stats_layanan_24jam);
            HomeSetting::setValue('stats', 'tahun_pengalaman', $request->stats_tahun_pengalaman, 'number');
            HomeSetting::setValue('stats', 'rating_google', $request->stats_rating_google, 'number');

            // Save CTA settings
            HomeSetting::setValue('cta', 'title', $request->cta_title);
            HomeSetting::setValue('cta', 'description', $request->cta_description);
            HomeSetting::setValue('cta', 'emergency_badge', $request->cta_emergency_badge);

            return redirect()->back()->with('success', 'Konten home page berhasil diperbarui.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function preview()
    {
        // Get current settings for preview
        $settings = [
            'hero' => HomeSetting::getSection('hero'),
            'about' => HomeSetting::getSection('about'),
            'stats' => HomeSetting::getSection('stats'),
            'cta' => HomeSetting::getSection('cta'),
        ];

        return view('admin.home.preview', compact('settings'));
    }
}
