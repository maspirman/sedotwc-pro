<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Prevent font optimization -->
    <meta name="google" content="notranslate">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <!-- Content Security Policy to prevent preload injection -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self' https: data:; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com; font-src 'self' data: https://fonts.gstatic.com; connect-src 'self' https:; img-src 'self' data: https: blob:; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; object-src 'none'; base-uri 'self'; form-action 'self';">

    <title>{{ \App\Models\GeneralSetting::getValue('site_name', config('app.name', 'SedotWC')) }} - @yield('title', \App\Models\GeneralSetting::getValue('site_title', 'Jasa Sedot WC Profesional'))</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta-description', \App\Models\GeneralSetting::getValue('site_description', 'Jasa sedot WC profesional dengan harga terjangkau. Layanan 24 jam untuk keadaan darurat. Bersih, cepat, dan terpercaya.'))">
    <meta name="keywords" content="@yield('meta-keywords', \App\Models\GeneralSetting::getValue('site_keywords', 'sedot wc, jasa sedot wc, sedot wc jakarta, wc mampet, jasa sedot wc murah'))">
    <meta name="author" content="{{ \App\Models\GeneralSetting::getValue('site_name', 'SedotWC') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og-title', \App\Models\GeneralSetting::getValue('site_title', config('app.name', 'SedotWC')))">
    <meta property="og:description" content="@yield('og-description', \App\Models\GeneralSetting::getValue('site_description', 'Jasa sedot WC profesional dengan harga terjangkau. Layanan 24 jam untuk keadaan darurat.'))">
    <meta property="og:image" content="@yield('og-image', asset(\App\Models\GeneralSetting::getValue('og_image', 'images/og-image.jpg')))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('twitter-title', \App\Models\GeneralSetting::getValue('site_title', config('app.name', 'SedotWC')))">
    <meta property="twitter:description" content="@yield('twitter-description', \App\Models\GeneralSetting::getValue('site_description', 'Jasa sedot WC profesional dengan harga terjangkau. Layanan 24 jam untuk keadaan darurat.'))">
    <meta property="twitter:image" content="@yield('twitter-image', asset(\App\Models\GeneralSetting::getValue('og_image', 'images/og-image.jpg')))">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset(\App\Models\GeneralSetting::getValue('site_favicon', 'favicon.ico')) }}">

    <!-- Bootstrap CSS (Local) -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons (Local) -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.css') }}">

    <!-- Custom CSS -->
    <style>
        /* Local Poppins Font */
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: local('Poppins Light'), local('Poppins-Light'),
                 url('{{ asset("assets/fonts/poppins-300.woff2") }}') format('woff2');
        }

        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: local('Poppins Regular'), local('Poppins-Regular'),
                 url('{{ asset("assets/fonts/poppins-400.woff2") }}') format('woff2');
        }

        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: local('Poppins Medium'), local('Poppins-Medium'),
                 url('{{ asset("assets/fonts/poppins-500.woff2") }}') format('woff2');
        }

        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: local('Poppins SemiBold'), local('Poppins-SemiBold'),
                 url('{{ asset("assets/fonts/poppins-600.woff2") }}') format('woff2');
        }

        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: local('Poppins Bold'), local('Poppins-Bold'),
                 url('{{ asset("assets/fonts/poppins-700.woff2") }}') format('woff2');
        }

        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --dark-color: #1a1a1a;
            --light-color: #f8f9fa;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --shadow-sm: 0 2px 10px rgba(0,0,0,0.1);
            --shadow-md: 0 10px 30px rgba(0,0,0,0.15);
            --shadow-lg: 0 20px 40px rgba(0,0,0,0.2);
        }

        * {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
        }

        /* Hero Section */
        .hero-section {
            background: var(--gradient-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255,255,255,0.1) 0%, transparent 50%);
            animation: patternMove 20s ease-in-out infinite;
        }

        @keyframes patternMove {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }

        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            animation: float 6s ease-in-out infinite;
        }

        .shape-1 {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 60px;
            height: 60px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .shape-3 {
            width: 100px;
            height: 100px;
            bottom: 10%;
            left: 50%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.7; }
            50% { transform: translateY(-20px) rotate(180deg); opacity: 1; }
        }

        .min-vh-80 {
            min-height: 80vh;
        }

        .text-gradient {
            background: linear-gradient(45deg, #ffc107, #ff8c00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Animations */
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .animate-fade-in-left {
            animation: fadeInLeft 1s ease-out;
        }

        .animate-fade-in-right {
            animation: fadeInRight 1s ease-out 0.3s both;
        }

        .pulse-animation {
            animation: pulse 2s ease-in-out infinite;
        }

        /* Hero Components */
        .emergency-contact {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .hero-image-container {
            position: relative;
        }

        .hero-main-image {
            transition: transform 0.3s ease;
        }

        .hero-main-image:hover {
            transform: scale(1.02);
        }

        .floating-card {
            position: absolute;
            z-index: 10;
        }

        .card-1 {
            top: -20px;
            right: -20px;
            animation: floatCard 3s ease-in-out infinite;
        }

        .card-2 {
            bottom: -20px;
            left: -20px;
            animation: floatCard 3s ease-in-out infinite 1.5s;
        }

        @keyframes floatCard {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .icon-wrapper {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }

        /* WhatsApp Button */
        .btn-whatsapp {
            background: linear-gradient(45deg, #25d366, #128c7e);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-whatsapp:hover {
            background: linear-gradient(45deg, #128c7e, #25d366);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
        }

        /* Service Cards */
        .service-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
            border-radius: 20px;
            overflow: hidden;
            background: white;
            position: relative;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: var(--shadow-lg);
        }

        .service-card:hover::before {
            transform: scaleX(1);
        }

        .service-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 2rem;
            transition: all 0.3s ease;
        }

        .service-card:hover .service-icon {
            transform: scale(1.1);
            box-shadow: var(--shadow-md);
        }

        /* Testimonial Cards */
        .testimonial-card {
            background: white;
            border-radius: 20px;
            border: none;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 4rem;
            color: rgba(102, 126, 234, 0.1);
            font-family: Georgia, serif;
            z-index: 1;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        /* Testimonial Carousel */
        .testimonial-carousel .carousel-indicators {
            bottom: auto;
            top: -40px;
            justify-content: center;
        }

        .testimonial-carousel .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid #007bff;
            background-color: transparent;
            opacity: 0.5;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .testimonial-carousel .carousel-indicators button.active {
            background-color: #007bff;
            opacity: 1;
        }

        .testimonial-carousel .carousel-control-prev-icon,
        .testimonial-carousel .carousel-control-next-icon {
            filter: invert(1);
        }

        .testimonial-carousel .carousel-control-prev,
        .testimonial-carousel .carousel-control-next {
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .testimonial-carousel .carousel-control-prev:hover,
        .testimonial-carousel .carousel-control-next:hover {
            opacity: 1;
        }

        /* Rating Stars */
        .stars-display {
            font-size: 1.5rem;
            color: #ffc107;
            text-shadow: 0 0 3px rgba(255, 193, 7, 0.3);
        }

        .rating-number {
            font-size: 0.875rem;
            font-weight: 600;
        }

        /* Customer Avatar */
        .customer-avatar img,
        .avatar-placeholder {
            border: 3px solid #007bff !important;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
        }

        /* Testimonial Stats */
        .stat-item {
            padding: 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-item i {
            transition: transform 0.3s ease;
        }

        .stat-item:hover i {
            transform: scale(1.1);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            position: relative;
            overflow: hidden;
        }

        .cta-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Buttons */
        .btn-custom {
            border-radius: 50px;
            padding: 14px 32px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-custom:hover::before {
            left: 100%;
        }

        /* Navigation */
        /* Default navbar for non-homepage pages */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            -webkit-backdrop-filter: blur(20px);
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 70px;
            padding: 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }

        /* Homepage navbar - transparent by default */
        .navbar-homepage.navbar-custom {
            background: transparent;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            box-shadow: none;
            border-bottom: none;
        }

        /* Homepage navbar when scrolled */
        .navbar-homepage.navbar-custom.scrolled {
            background: rgba(255, 255, 255, 0.95);
            -webkit-backdrop-filter: blur(20px);
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            height: 65px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        /* Brand & Logo */
        .navbar-brand {
            padding: 0;
            margin: 0;
            transition: all 0.3s ease;
        }

        .brand-logo {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
        }

        .brand-logo:hover {
            transform: scale(1.05);
            box-shadow: var(--shadow-sm);
        }

        .brand-main {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
            transition: all 0.4s ease;
        }

        /* Homepage brand - white text */
        .navbar-homepage .brand-main {
            color: rgba(255, 255, 255, 0.95);
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        /* Homepage brand when scrolled */
        .navbar-homepage.navbar-custom.scrolled .brand-main {
            color: var(--primary-color);
            text-shadow: none;
        }

        .brand-sub {
            font-size: 0.7rem;
            line-height: 1;
            margin-top: 2px;
        }

        /* Emergency Buttons */
        .btn-emergency-mobile {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(45deg, #dc3545, #e74c3c);
            border: none;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .btn-emergency-mobile:hover {
            transform: scale(1.1);
            box-shadow: var(--shadow-md);
            color: white;
        }

        .btn-emergency-mobile:active {
            transform: scale(0.95);
        }

        .btn-emergency-mobile.pulse-active {
            animation: emergencyPulse 1s ease-in-out;
        }

        @keyframes emergencyPulse {
            0%, 100% { transform: scale(1); box-shadow: var(--shadow-sm); }
            50% { transform: scale(1.15); box-shadow: 0 8px 25px rgba(220, 53, 69, 0.4); }
        }

        .btn-emergency {
            background: linear-gradient(45deg, #dc3545, #e74c3c);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-emergency:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: white;
        }

        .emergency-text {
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .emergency-number {
            display: block;
            font-size: 0.75rem;
            opacity: 0.9;
            margin-top: 2px;
        }

        /* Navigation Links */
        .navbar-nav {
            gap: 8px;
        }

        .nav-link {
            font-weight: 500;
            padding: 12px 20px;
            border-radius: 25px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            color: #495057;
            overflow: hidden;
        }

        /* Homepage navbar - transparent links */
        .navbar-homepage .nav-link {
            color: rgba(255, 255, 255, 0.9);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* Homepage navbar when scrolled */
        .navbar-homepage.navbar-custom.scrolled .nav-link {
            color: #495057;
            text-shadow: none;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover {
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
        }

        /* Default active state for non-homepage */
        .nav-link.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white !important;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.6);
            transform: translateY(-2px);
        }

        /* Homepage active state - more subtle */
        .navbar-homepage .nav-link.active {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9));
            color: white !important;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.5);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        /* Homepage active when scrolled */
        .navbar-homepage.navbar-custom.scrolled .nav-link.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.6);
            text-shadow: none;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            top: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.6);
            animation: activeDotGlow 2s ease-in-out infinite;
        }

        @keyframes activePulse {
            0%, 100% {
                transform: translateY(-2px);
                box-shadow: 0 8px 30px rgba(102, 126, 234, 0.4);
            }
            50% {
                transform: translateY(-3px);
                box-shadow: 0 12px 40px rgba(102, 126, 234, 0.6);
            }
        }

        @keyframes activeDotGlow {
            0%, 100% {
                transform: translateX(-50%) scale(1);
                opacity: 0.8;
            }
            50% {
                transform: translateX(-50%) scale(1.2);
                opacity: 1;
            }
        }

        /* User Dropdown */
        .btn-user {
            background: white;
            border: 2px solid #e9ecef;
            color: #495057;
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-user:hover {
            background: var(--gradient-primary);
            border-color: transparent;
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
        }

        .user-name {
            font-size: 0.85rem;
            font-weight: 600;
            line-height: 1.2;
        }

        .user-role {
            font-size: 0.7rem;
            line-height: 1;
        }

        .dropdown-header {
            padding: 12px 16px;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .dropdown-item {
            padding: 10px 16px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: rgba(102, 126, 234, 0.1);
            color: var(--primary-color);
        }

        /* Auth Buttons */
        .auth-buttons .btn {
            border-radius: 25px;
            font-weight: 600;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }

        .btn-login {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-login:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .btn-register {
            background: var(--gradient-primary);
            border: none;
            color: white;
        }

        .btn-register:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
            color: white;
        }

        /* Navbar Toggler */
        .navbar-toggler {
            border: none;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.4s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .navbar-toggler:focus {
            box-shadow: var(--shadow-sm);
        }

        /* Homepage navbar toggler - semi-transparent */
        .navbar-homepage .navbar-toggler {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Homepage navbar toggler when scrolled */
        .navbar-homepage.navbar-custom.scrolled .navbar-toggler {
            background: rgba(255, 255, 255, 0.9);
        }

        /* Mobile Menu */
        @media (max-width: 991.98px) {
            .navbar-custom {
                height: auto;
                padding: 8px 0;
            }

            /* Homepage mobile navbar - transparent */
            .navbar-homepage.navbar-custom {
                background: transparent;
            }

            /* Homepage mobile navbar when scrolled */
            .navbar-homepage.navbar-custom.scrolled {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
            }

            .emergency-mobile {
                margin-right: 8px;
            }

            .navbar-collapse {
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border-radius: 12px;
                margin-top: 8px;
                padding: 16px;
                border: 1px solid rgba(0,0,0,0.05);
            }

            .navbar-nav {
                gap: 0;
                margin-bottom: 16px;
            }

            .nav-item {
                margin-bottom: 4px;
            }

            .nav-link {
                padding: 12px 16px;
                margin-bottom: 4px;
                border-radius: 12px;
                font-size: 1rem;
                font-weight: 600;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .nav-link:hover {
                transform: translateX(8px);
                box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
            }

            .nav-link.active {
                background: var(--gradient-primary);
                color: white;
                transform: translateX(8px);
                box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
                animation: mobileActivePulse 2s ease-in-out infinite;
            }

            .nav-link.active::before {
                content: '●';
                position: absolute;
                left: 12px;
                top: 50%;
                transform: translateY(-50%);
                color: rgba(255, 255, 255, 0.9);
                font-size: 12px;
                animation: mobileActiveDot 2s ease-in-out infinite;
            }

            @keyframes mobileActivePulse {
                0%, 100% {
                    transform: translateX(8px);
                    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
                }
                50% {
                    transform: translateX(10px);
                    box-shadow: 0 6px 25px rgba(102, 126, 234, 0.6);
                }
            }

            @keyframes mobileActiveDot {
                0%, 100% {
                    transform: translateY(-50%) scale(1);
                    opacity: 0.9;
                }
                50% {
                    transform: translateY(-50%) scale(1.2);
                    opacity: 1;
                }
            }

            .auth-buttons {
                justify-content: center;
                gap: 12px;
            }

            .auth-buttons .btn {
                flex: 1;
                max-width: 120px;
            }
        }

        /* Extra Small Devices */
        @media (max-width: 576px) {
            .navbar-brand {
                margin-right: auto;
            }

            .brand-main {
                font-size: 1.1rem;
            }

            .auth-buttons {
                width: 100%;
                margin-top: 16px;
            }

            .auth-buttons .btn {
                flex: 1;
            }
        }

        /* Footer */
        .footer {
            background: var(--dark-color);
            color: white;
            position: relative;
        }

        .footer-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section {
                min-height: auto;
                padding: 120px 0 80px;
            }

            .display-3 {
                font-size: 2.5rem;
            }

            .floating-card {
                display: none;
            }

            .hero-image-container {
                margin-top: 2rem;
            }
        }

        @media (max-width: 576px) {
            .display-3 {
                font-size: 2rem;
            }

            .btn-custom {
                padding: 12px 24px;
                font-size: 0.9rem;
            }
        }

        /* Utilities */
        .rating-stars {
            color: #ffc107;
        }

        .bg-light-custom {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        /* Loading Animation */
        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(255,255,255,0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Emergency Indicator */
        .emergency-indicator {
            display: inline-flex;
            align-items: center;
            position: relative;
        }

        .pulse-ring {
            position: absolute;
            width: 20px;
            height: 20px;
            border: 2px solid #dc3545;
            border-radius: 50%;
            animation: pulseRing 2s infinite;
        }

        .pulse-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            position: relative;
            z-index: 2;
        }

        @keyframes pulseRing {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        /* Contact Cards */
        .contact-card {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .contact-icon {
            transition: transform 0.3s ease;
        }

        .contact-card:hover .contact-icon {
            transform: scale(1.1);
        }

        /* Trust Signals */
        .trust-signals {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Stats */
        .stat-item {
            padding: 2rem 1rem;
            transition: transform 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
        }

        /* Footer Enhancement */
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        /* Scroll Animation Classes */
        .animate-in {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Pulse Strong Animation */
        .pulse-strong {
            animation: pulseStrong 1s ease-in-out;
        }

        @keyframes pulseStrong {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Enhanced Button Hover Effects */
        .btn-custom:hover {
            box-shadow: var(--shadow-md);
        }

        /* Mobile Optimizations */
        @media (max-width: 576px) {
            .hero-section {
                padding: 100px 0 60px;
            }

            .emergency-contact {
                font-size: 0.9rem;
            }

            .btn-custom {
                font-size: 0.9rem;
                padding: 10px 20px;
            }
        }

        /* Image Fallback Styles */
        .image-fallback {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 200px;
            border-radius: 0.375rem;
        }

        .image-fallback svg {
            opacity: 0.6;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top pt-2 mb-1 {{ request()->routeIs('home') ? 'navbar-homepage' : '' }}">
        <div class="container">
            <!-- Logo & Brand -->
            <a class="navbar-brand d-flex align-items-center fw-bold text-primary" href="{{ route('home') }}">
                <div class="brand-logo me-2">
                    @if(\App\Models\GeneralSetting::getValue('site_logo'))
                        <img src="{{ asset(\App\Models\GeneralSetting::getValue('site_logo')) }}"
                             alt="{{ \App\Models\GeneralSetting::getValue('site_name', 'SedotWC') }}"
                             class="brand-logo-image" style="width: 100%; height: 100%; object-fit: contain;">
                    @else
                        <i class="bi bi-water fs-4 text-primary"></i>
                    @endif
                </div>
                <div class="brand-text">
                    <span class="brand-main">{{ \App\Models\GeneralSetting::getValue('site_name', 'SedotWC') }}</span>
                    <small class="brand-sub text-muted d-block d-lg-none">{{ \App\Models\GeneralSetting::getValue('site_title', 'Jasa Sedot WC 24 Jam') }}</small>
                </div>
            </a>

            <!-- Emergency Call (Mobile) -->
            <div class="emergency-mobile d-lg-none">
                <a href="tel:{{ \App\Models\GeneralSetting::getValue('emergency_phone', '(021) 1234-5678') }}" class="btn btn-emergency-mobile">
                    <i class="bi bi-telephone-fill"></i>
                </a>
            </div>

            <!-- Mobile Toggler -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1 d-lg-none"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}">
                            <i class="bi bi-tools me-1 d-lg-none"></i>Layanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}" href="{{ route('blog.index') }}">
                            <i class="bi bi-newspaper me-1 d-lg-none"></i>Blog
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('page.show') && request()->route('page')?->slug === 'tentang-kami' ? 'active' : '' }}" href="{{ route('page.show', 'tentang-kami') }}">
                            <i class="bi bi-info-circle me-1 d-lg-none"></i>Tentang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('page.show') && request()->route('page')?->slug === 'kontak' ? 'active' : '' }}" href="{{ route('page.show', 'kontak') }}">
                            <i class="bi bi-envelope me-1 d-lg-none"></i>Kontak
                        </a>
                    </li>
                </ul>

                <!-- Emergency Call & Auth Section -->
                <div class="d-flex align-items-center">
                    <!-- Emergency Call (Desktop) -->
                    <div class="emergency-call d-none d-lg-flex me-3">
                        <a href="tel:{{ \App\Models\GeneralSetting::getValue('emergency_phone', '(021) 1234-5678') }}" class="btn btn-emergency">
                            <i class="bi bi-telephone-fill me-1"></i>
                            <span class="emergency-text">Emergency</span>
                            <small class="emergency-number">{{ \App\Models\GeneralSetting::getValue('emergency_phone', '(021) 1234-5678') }}</small>
                        </a>
                    </div>

                    <!-- Auth Section -->
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-user dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                                <div class="user-avatar me-2">
                                    <i class="bi bi-person-circle"></i>
                                </div>
                                <div class="user-info d-none d-md-block text-start">
                                    <div class="user-name">{{ Str::limit(Auth::user()->name, 15) }}</div>
                                    <small class="user-role text-muted">{{ Auth::user()->isAdmin() ? 'Admin' : 'Customer' }}</small>
                                </div>
                                <i class="bi bi-chevron-down ms-1"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li class="dropdown-header">
                                    <strong>{{ Auth::user()->name }}</strong>
                                    <br><small class="text-muted">{{ Auth::user()->email }}</small>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                @if(Auth::user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i>Admin Dashboard
                                </a></li>
                                @else
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i>Profile
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div class="auth-buttons">
                            <a href="{{ route('login') }}" class="btn btn-login me-2">
                                <i class="bi bi-box-arrow-in-right me-1 d-lg-none"></i>
                                <span>Masuk</span>
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-register">
                                <i class="bi bi-person-plus me-1 d-lg-none"></i>
                                <span>Daftar</span>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="text-primary mb-3">
                        <i class="bi bi-water me-2"></i>{{ \App\Models\GeneralSetting::getValue('site_name', 'SedotWC') }}
                    </h5>
                    <p>{{ \App\Models\GeneralSetting::getValue('site_description', 'Jasa sedot WC profesional dengan harga terjangkau. Melayani 24 jam untuk keadaan darurat dengan tim yang berpengalaman dan peralatan modern.') }}</p>
                    <div class="mt-3">
                        @php
                            $socialMedia = \App\Models\GeneralSetting::getGroup('social_media');
                        @endphp
                        @if(isset($socialMedia['facebook']) && $socialMedia['facebook'])
                            <a href="{{ $socialMedia['facebook'] }}" class="text-light me-3" target="_blank"><i class="bi bi-facebook fs-5"></i></a>
                        @endif
                        @if(isset($socialMedia['instagram']) && $socialMedia['instagram'])
                            <a href="{{ $socialMedia['instagram'] }}" class="text-light me-3" target="_blank"><i class="bi bi-instagram fs-5"></i></a>
                        @endif
                        @if(isset($socialMedia['whatsapp_business']) && $socialMedia['whatsapp_business'])
                            <a href="{{ $socialMedia['whatsapp_business'] }}" class="text-light me-3" target="_blank"><i class="bi bi-whatsapp fs-5"></i></a>
                        @endif
                        @if(isset($socialMedia['twitter']) && $socialMedia['twitter'])
                            <a href="{{ $socialMedia['twitter'] }}" class="text-light" target="_blank"><i class="bi bi-twitter fs-5"></i></a>
                        @endif
                    </div>
                </div>

                <div class="col-md-2 mb-4">
                    <h6>Layanan</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">Sedot WC Standar</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Sedot WC Premium</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Sedot WC Darurat</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Sedot WC Apartemen</a></li>
                    </ul>
                </div>

                <div class="col-md-2 mb-4">
                    <h6>Perusahaan</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('page.show', 'tentang-kami') }}" class="text-light text-decoration-none">Tentang Kami</a></li>
                        <li><a href="{{ route('blog.index') }}" class="text-light text-decoration-none">Blog</a></li>
                        <li><a href="{{ route('page.show', 'karir') }}" class="text-light text-decoration-none">Karir</a></li>
                        <li><a href="{{ route('page.show', 'kontak') }}" class="text-light text-decoration-none">Kontak</a></li>
                    </ul>
                </div>

                <div class="col-md-4 mb-4">
                    <h6>Kontak Kami</h6>
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-geo-alt me-3 text-primary"></i>
                        <span>{{ \App\Models\GeneralSetting::getValue('contact_address', 'Jl. Sudirman No. 123, Jakarta Pusat') }}</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-telephone me-3 text-primary"></i>
                        <span>{{ \App\Models\GeneralSetting::getValue('contact_phone', '(021) 1234-5678') }}</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-whatsapp me-3 text-primary"></i>
                        <span>{{ \App\Models\GeneralSetting::getValue('emergency_whatsapp', '0812-3456-7890') }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-envelope me-3 text-primary"></i>
                        <span>{{ \App\Models\GeneralSetting::getValue('contact_email', 'info@sedotwc.com') }}</span>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ \App\Models\GeneralSetting::getValue('site_name', 'SedotWC') }}. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="{{ route('page.show', 'privacy-policy') }}" class="text-light text-decoration-none me-3">Privacy Policy</a>
                    <a href="{{ route('page.show', 'terms-of-service') }}" class="text-light text-decoration-none">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        // Prevent automatic font optimization and preload injection
        (function() {
            // Override font loading to prevent preload injection
            const originalCreateElement = document.createElement;
            document.createElement = function(tagName) {
                const element = originalCreateElement.call(document, tagName);
                if (tagName === 'link' && element.rel === 'preload') {
                    // Monitor preload links and remove unwanted ones
                    const observer = new MutationObserver(function(mutations) {
                        mutations.forEach(function(mutation) {
                            if (mutation.type === 'attributes' && mutation.attributeName === 'href') {
                                const href = element.href;
                                if (href && (href.includes('fonts.googleapis') || href.includes('&lt;'))) {
                                    element.remove();
                                }
                            }
                        });
                    });
                    observer.observe(element, { attributes: true });
                }
                return element;
            };
        })();

        // Adjust body padding for fixed navbar - skip on homepage
        function adjustBodyPadding() {
            const navbar = document.querySelector('.navbar-custom');
            const body = document.body;
            const main = document.querySelector('main');
            const isHomepage = navbar && navbar.classList.contains('navbar-homepage');

            // Skip padding adjustment on homepage to allow transparent navbar effect
            if (!isHomepage && navbar && main) {
                const navbarHeight = navbar.offsetHeight;
                body.style.paddingTop = navbarHeight + 'px';
                main.style.marginTop = '0';
            } else if (isHomepage && body) {
                // Reset padding on homepage
                body.style.paddingTop = '0';
                if (main) {
                    main.style.marginTop = '0';
                }
            }
        }

        // Navbar scroll effect - only for homepage
        let scrollTimeout;
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            const isHomepage = navbar.classList.contains('navbar-homepage');

            // Only apply scroll effect on homepage
            if (isHomepage) {
                const scrolled = window.scrollY > 100;

                // Debounce scroll event for better performance
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    if (scrolled) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                }, 10);
            }
        });

        // Smooth scrolling for anchor links with navbar offset
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const navbar = document.querySelector('.navbar-custom');
                    const navbarHeight = navbar ? navbar.offsetHeight : 0;
                    const targetPosition = target.offsetTop - navbarHeight - 20;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });

                    // Close mobile menu if open
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                        const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                            hide: true
                        });
                    }
                }
            });
        });

        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.service-card, .testimonial-card, .stat-item').forEach(card => {
            observer.observe(card);
        });

        // Enhanced button interactions
        document.querySelectorAll('.btn-custom').forEach(button => {
            button.addEventListener('click', function() {
                if (this.href && !this.classList.contains('btn-whatsapp') && !this.classList.contains('btn-emergency') && !this.classList.contains('btn-emergency-mobile')) {
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
                    this.disabled = true;

                    // Re-enable after 2 seconds (for demo purposes)
                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                        this.disabled = false;
                    }, 2000);
                }
            });
        });

        // Emergency button pulse animation
        setInterval(() => {
            const emergencyBtn = document.querySelector('.btn-emergency-mobile');
            if (emergencyBtn && !emergencyBtn.classList.contains('pulse-active')) {
                emergencyBtn.classList.add('pulse-active');
                setTimeout(() => {
                    emergencyBtn.classList.remove('pulse-active');
                }, 1000);
            }
        }, 8000);

        // Mobile menu enhancements
        document.addEventListener('DOMContentLoaded', function() {
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');

            if (navbarToggler && navbarCollapse) {
                // Add slide animation to mobile menu
                navbarCollapse.addEventListener('show.bs.collapse', function() {
                    this.style.opacity = '0';
                    this.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        this.style.transition = 'all 0.3s ease';
                        this.style.opacity = '1';
                        this.style.transform = 'translateY(0)';
                    }, 10);
                });

                navbarCollapse.addEventListener('hide.bs.collapse', function() {
                    this.style.opacity = '0';
                    this.style.transform = 'translateY(-10px)';
                });
            }
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            adjustBodyPadding();

            // Re-adjust on window resize
            window.addEventListener('resize', function() {
                setTimeout(adjustBodyPadding, 100);
            });
        });

        // Handle navbar brand click for smooth scroll to top
        document.querySelector('.navbar-brand')?.addEventListener('click', function(e) {
            if (this.getAttribute('href') === '#') {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });

        // Remove unwanted preload links and prevent font optimization issues
        document.addEventListener('DOMContentLoaded', function() {
            // Continuously monitor and remove problematic preload links
            const removeProblematicLinks = function() {
                // Remove any preload links for Google Fonts
                const preloadLinks = document.querySelectorAll('link[rel="preload"][href*="fonts.googleapis"]');
                preloadLinks.forEach(link => link.remove());

                // Remove malformed preload links
                const malformedLinks = document.querySelectorAll('link[rel="preload"][href*="&lt;link"]');
                malformedLinks.forEach(link => link.remove());

                // Remove any link with as="style" attribute that might be malformed
                const styleLinks = document.querySelectorAll('link[as="style"]');
                styleLinks.forEach(link => {
                    if (link.href.includes('&lt;') || link.href.includes('&gt;') || link.href.includes('<link')) {
                        link.remove();
                    }
                });

                // Remove any preload links without valid 'as' attribute or with invalid href
                const allPreloadLinks = document.querySelectorAll('link[rel="preload"]');
                allPreloadLinks.forEach(link => {
                    const asValue = link.getAttribute('as');
                    const hrefValue = link.getAttribute('href');

                    // Remove if 'as' attribute is missing, invalid, or href contains HTML
                    if (!asValue || !['style', 'script', 'font', 'image', 'document', 'fetch'].includes(asValue) ||
                        hrefValue.includes('<') || hrefValue.includes('>') || hrefValue.includes('&lt;') || hrefValue.includes('&gt;')) {
                        link.remove();
                    }
                });
            };

            // Run immediately
            removeProblematicLinks();

            // Run again after a short delay to catch any late injections
            setTimeout(removeProblematicLinks, 100);
            setTimeout(removeProblematicLinks, 500);
            setTimeout(removeProblematicLinks, 1000);

            // Set up a mutation observer to catch any new problematic links
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList') {
                        mutation.addedNodes.forEach(function(node) {
                            if (node.nodeType === 1 && node.tagName === 'LINK' &&
                                (node.rel === 'preload' || node.hasAttribute('as'))) {
                                const asValue = node.getAttribute('as');
                                const hrefValue = node.getAttribute('href');

                                if (!asValue || !['style', 'script', 'font', 'image', 'document', 'fetch'].includes(asValue) ||
                                    (hrefValue && (hrefValue.includes('<') || hrefValue.includes('&lt;') ||
                                                   hrefValue.includes('fonts.googleapis') || hrefValue.includes('<link')))) {
                                    node.remove();
                                }
                            }
                        });
                    }
                });
            });

            observer.observe(document.head, { childList: true, subtree: true });
        });
    </script>

    @stack('scripts')
</body>
</html>
