<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ \App\Models\GeneralSetting::getValue('site_name', config('app.name', 'Laravel')) }} - Admin Panel</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- jQuery (required for Summernote) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            padding: 12px 20px;
            margin: 4px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .sidebar .nav-link:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            color: white !important;
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: -12px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: white;
            border-radius: 2px;
        }

        .sidebar .dropdown-menu {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 8px;
            padding: 8px 0;
        }

        .sidebar .dropdown-item {
            color: #495057 !important;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .sidebar .dropdown-item:hover {
            background-color: rgba(102, 126, 234, 0.1);
            color: #667eea !important;
            transform: translateX(5px);
        }

        .sidebar .dropdown-item.active {
            background-color: rgba(102, 126, 234, 0.2);
            color: #667eea !important;
            font-weight: 600;
        }

        .sidebar .brand-logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .sidebar .brand-logo .logo-text {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
        }

        .main-content {
            margin-left: 260px;
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        .top-navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .menu-toggle {
            background: none;
            border: none;
            color: #6c757d;
            font-size: 1.2rem;
            padding: 8px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .menu-toggle:hover {
            background-color: #f8f9fa;
            color: #495057;
        }

        .content-wrapper {
            padding: 30px;
        }

        .page-header {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.12);
        }

        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 16px;
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .content-wrapper {
                padding: 20px 15px;
            }

            .page-header {
                padding: 20px;
                margin-bottom: 20px;
            }
        }

        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        .mobile-overlay.show {
            display: block;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="brand-logo">
            <a href="{{ route('admin.dashboard') }}" class="logo-text">
                @if(\App\Models\GeneralSetting::getValue('site_logo'))
                    <img src="{{ asset(\App\Models\GeneralSetting::getValue('site_logo')) }}"
                         alt="{{ \App\Models\GeneralSetting::getValue('site_name', 'SedotWC') }}"
                         style="width: 24px; height: 24px; object-fit: contain; margin-right: 8px; border-radius: 4px;">
                @else
                    <i class="bi bi-tools me-2"></i>
                @endif
                {{ \App\Models\GeneralSetting::getValue('site_name', 'SedotWC') }} Admin
            </a>
        </div>

        <div class="px-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                        <i class="bi bi-wrench-adjustable me-2"></i>
                        <span>Layanan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="bi bi-receipt me-2"></i>
                        <span>Order</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                        <i class="bi bi-people me-2"></i>
                        <span>Pelanggan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.blogs.index') }}" class="nav-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                        <i class="bi bi-newspaper me-2"></i>
                        <span>Blog</span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.cms.*', 'admin.home.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                        <i class="bi bi-file-text me-2"></i>
                        <span>CMS</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request()->routeIs('admin.home.*') ? 'active' : '' }}" href="{{ route('admin.home.index') }}">
                            <i class="bi bi-house-door me-2"></i>Home Page
                        </a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('admin.cms.*') ? 'active' : '' }}" href="{{ route('admin.cms.index') }}">
                            <i class="bi bi-file-text me-2"></i>Custom Pages
                        </a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-quote me-2"></i>
                        <span>Testimonial</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.media.index') }}" class="nav-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                        <i class="bi bi-images me-2"></i>
                        <span>Media</span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.seo.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                        <i class="bi bi-search me-2"></i>
                        <span>SEO</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request()->routeIs('admin.seo.index') ? 'active' : '' }}" href="{{ route('admin.seo.index') }}">
                            <i class="bi bi-list me-2"></i>SEO Settings
                        </a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('admin.seo.sitemap') ? 'active' : '' }}" href="{{ route('admin.seo.sitemap') }}">
                            <i class="bi bi-diagram-3 me-2"></i>Sitemap Generator
                        </a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('admin.seo.robots') ? 'active' : '' }}" href="{{ route('admin.seo.robots') }}">
                            <i class="bi bi-robot me-2"></i>Robots.txt
                        </a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('admin.seo.page-speed') ? 'active' : '' }}" href="{{ route('admin.seo.page-speed') }}">
                            <i class="bi bi-speedometer2 me-2"></i>Page Speed
                        </a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.notifications.index') }}" class="nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                        <i class="bi bi-bell me-2"></i>
                        <span>Notifikasi</span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                        <i class="bi bi-gear me-2"></i>
                        <span>Pengaturan</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                            <i class="bi bi-sliders me-2"></i>Umum
                        </a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('admin.settings.social-media') ? 'active' : '' }}" href="{{ route('admin.settings.social-media') }}">
                            <i class="bi bi-share me-2"></i>Sosial Media
                        </a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('admin.settings.logs') ? 'active' : '' }}" href="{{ route('admin.settings.logs') }}">
                            <i class="bi bi-file-earmark-text me-2"></i>Log Files
                        </a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('admin.settings.backup') ? 'active' : '' }}" href="{{ route('admin.settings.backup') }}">
                            <i class="bi bi-database me-2"></i>Backup
                        </a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('admin.settings.maintenance') ? 'active' : '' }}" href="{{ route('admin.settings.maintenance') }}">
                            <i class="bi bi-tools me-2"></i>Maintenance
                        </a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('admin.settings.activity') ? 'active' : '' }}" href="{{ route('admin.settings.activity') }}">
                            <i class="bi bi-activity me-2"></i>Activity Log
                        </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="menu-toggle me-3" id="menuToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">{{ $title ?? 'Admin Panel' }}</h5>
                        <small class="text-muted">{{ $subtitle ?? 'Kelola sistem SedotWC' }}</small>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <!-- Notifications -->
                    <div class="dropdown me-3">
                        <button class="btn btn-link text-dark position-relative" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-bell fs-5"></i>
                            @php
                                $unreadCount = \App\Models\Notification::forUser(auth()->id())->unread()->count();
                            @endphp
                            @if($unreadCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                            </span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="width: 320px; max-height: 400px; overflow-y: auto;">
                            <li><h6 class="dropdown-header d-flex justify-content-between align-items-center">
                                Notifikasi
                                @if($unreadCount > 0)
                                <span class="badge bg-danger">{{ $unreadCount }}</span>
                                @endif
                            </h6></li>
                            @php
                                $recentNotifications = \App\Models\Notification::forUser(auth()->id())
                                    ->latest()
                                    ->take(5)
                                    ->get();
                            @endphp
                            @forelse($recentNotifications as $notification)
                            <li>
                                <a class="dropdown-item d-flex align-items-start {{ $notification->is_read ? 'text-muted' : '' }}"
                                   href="{{ $notification->action_url ?? '#' }}"
                                   onclick="markAsRead({{ $notification->id }})">
                                    <div class="me-3 mt-1">
                                        <i class="bi {{ $notification->icon ?? 'bi-bell' }} text-{{ $notification->color ?? 'primary' }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold small">{{ $notification->title }}</div>
                                        <div class="small text-muted">{{ Str::limit($notification->message, 60) }}</div>
                                        <div class="small text-muted">{{ $notification->created_at->diffForHumans() }}</div>
                                    </div>
                                    @if(!$notification->is_read)
                                    <div class="ms-2">
                                        <span class="badge bg-{{ $notification->color ?? 'primary' }} rounded-pill" style="width: 8px; height: 8px;"></span>
                                    </div>
                                    @endif
                                </a>
                            </li>
                            @empty
                            <li><a class="dropdown-item text-center text-muted" href="#">Belum ada notifikasi</a></li>
                            @endforelse
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-center" href="{{ route('admin.notifications.index') ?? '#' }}">Lihat Semua Notifikasi</a></li>
                        </ul>
                    </div>

                    <!-- User Menu -->
                    <div class="dropdown">
                        <button class="btn btn-link text-dark d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div class="text-start d-none d-md-block">
                                <div class="fw-bold">{{ Auth::user()->name }}</div>
                                <small class="text-muted">Administrator</small>
                            </div>
                            <i class="bi bi-chevron-down ms-2"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person me-2"></i>Profile
                            </a></li>
                            <li><a class="dropdown-item" href="#">
                                <i class="bi bi-gear me-2"></i>Pengaturan
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const menuToggle = document.getElementById('menuToggle');
            const mobileOverlay = document.getElementById('mobileOverlay');

            // Toggle sidebar
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');

                if (window.innerWidth <= 768) {
                    mobileOverlay.classList.toggle('show');
                }
            });

            // Close sidebar when clicking overlay on mobile
            mobileOverlay.addEventListener('click', function() {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
                mobileOverlay.classList.remove('show');
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');
                    mobileOverlay.classList.remove('show');
                }
            });

            // Auto-collapse sidebar on mobile load
            if (window.innerWidth <= 768) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
        });

        // Mark notification as read
        function markAsRead(notificationId) {
            fetch(`/admin/notifications/${notificationId}/mark-read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                if (response.ok) {
                    // Update UI - you might want to refresh the notification count
                    location.reload();
                }
            }).catch(error => {
                console.error('Error marking notification as read:', error);
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
