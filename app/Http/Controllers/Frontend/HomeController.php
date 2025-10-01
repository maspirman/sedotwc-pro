<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Blog;
use App\Models\HomeSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Get active services for homepage
            $services = Service::where('status', 'active')
                              ->orderBy('created_at', 'desc')
                              ->take(4)
                              ->get();

            // Get active testimonials
            $testimonials = Testimonial::where('status', 'active')
                                      ->orderBy('created_at', 'desc')
                                      ->take(3)
                                      ->get();

            // Get latest blog posts (handle if no blogs exist yet)
            $latestBlogs = Blog::published()
                               ->with('category')
                               ->orderBy('published_at', 'desc')
                               ->take(3)
                               ->get();

            // Get home page settings from database
            $homeSettings = [
                'hero' => HomeSetting::getSection('hero'),
                'about' => HomeSetting::getSection('about'),
                'stats' => HomeSetting::getSection('stats'),
                'cta' => HomeSetting::getSection('cta'),
            ];

            return view('frontend.home', compact('services', 'testimonials', 'latestBlogs', 'homeSettings'));
        } catch (\Exception $e) {
            // Fallback with default settings if database issues
            $homeSettings = [
                'hero' => [
                    'title' => 'Jasa Sedot WC 24 Jam',
                    'subtitle' => 'Profesional & Modern',
                    'description' => 'Layanan darurat WC mampet tersedia 24 jam dengan tim ahli berpengalaman, peralatan canggih, dan harga terjangkau. Solusi cepat untuk masalah WC Anda!',
                    'badge' => 'TERPERCAYA SEJAK 2015',
                    'emergency_phone' => '(021) 1234-5678',
                    'whatsapp' => '0812-3456-7890',
                ],
                'about' => [
                    'title' => 'Mengapa Memilih SedotWC?',
                    'description' => 'Tim ahli dengan pengalaman 10+ tahun menggunakan peralatan modern untuk memberikan layanan terbaik.',
                ],
                'stats' => [
                    'pelanggan_puas' => '1000',
                    'layanan_24jam' => '24/7',
                    'tahun_pengalaman' => '10',
                    'rating_google' => '4.9',
                ],
                'cta' => [
                    'title' => 'Butuh Layanan Sedot WC?',
                    'description' => 'Jangan biarkan masalah WC mengganggu kenyamanan Anda. Tim profesional kami siap membantu kapan saja, di mana saja dengan response time 30 menit!',
                    'emergency_badge' => 'DARURAT WC 24 JAM',
                ],
            ];

            return view('frontend.home', [
                'services' => collect(),
                'testimonials' => collect(),
                'latestBlogs' => collect(),
                'homeSettings' => $homeSettings
            ]);
        }
    }
}
