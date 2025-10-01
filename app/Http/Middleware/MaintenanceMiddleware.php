<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\GeneralSetting;

class MaintenanceMiddleware
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
        // Skip maintenance check for admin routes
        if ($request->is('admin/*') || $request->is('api/*')) {
            return $next($request);
        }

        // Check if maintenance mode is enabled
        $isMaintenance = GeneralSetting::getValue('maintenance_mode', 'false') === 'true';

        if ($isMaintenance) {
            // Allow access for authenticated admin users
            if (auth()->check() && auth()->user()->role === 'admin') {
                return $next($request);
            }

            // Prepare maintenance data
            $maintenanceData = $this->getMaintenanceData();

            // Return maintenance page
            return response()->view('maintenance', [
                'maintenanceData' => $maintenanceData
            ], 503); // Service Unavailable status
        }

        return $next($request);
    }

    /**
     * Get maintenance page data
     */
    private function getMaintenanceData()
    {
        // Get maintenance settings from database
        $maintenanceSettings = [
            'site_name' => GeneralSetting::getValue('site_name', 'SedotWC'),
            'title' => GeneralSetting::getValue('maintenance_title', 'Website Sedang Dalam Perbaikan'),
            'message' => GeneralSetting::getValue('maintenance_message', 'Kami sedang melakukan perbaikan untuk memberikan pengalaman yang lebih baik. Website akan segera kembali normal.'),
            'estimated_time' => GeneralSetting::getValue('maintenance_estimated_time', '1-2 jam lagi'),
            'progress' => GeneralSetting::getValue('maintenance_progress', '75'),
            'retry' => (int) GeneralSetting::getValue('maintenance_retry', '60'),
            'background_color' => GeneralSetting::getValue('maintenance_background_color', '#667eea'),
            'whatsapp' => GeneralSetting::getValue('whatsapp', '6281234567890'),
            'phone' => GeneralSetting::getValue('contact_phone', '+622112345678'),
        ];

        // Add social media links if enabled
        $showSocialLinks = GeneralSetting::getValue('maintenance_show_social_links', 'true') === 'true';
        $maintenanceData = [
            'social_links' => []
        ];

        if ($showSocialLinks) {
            $socialPlatforms = ['facebook', 'instagram', 'twitter', 'whatsapp'];
            $socialIcons = [
                'facebook' => 'facebook',
                'instagram' => 'instagram',
                'twitter' => 'twitter',
                'whatsapp' => 'whatsapp'
            ];

            foreach ($socialPlatforms as $platform) {
                $url = GeneralSetting::getValue($platform);
                if ($url && $url !== '') {
                    $maintenanceData['social_links'][] = [
                        'platform' => $platform,
                        'url' => $url,
                        'icon' => $socialIcons[$platform] ?? 'link'
                    ];
                }
            }
        }

        return array_merge($maintenanceSettings, $maintenanceData);
    }
}
