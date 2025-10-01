@extends('admin.layout', [
    'title' => 'Dashboard Admin',
    'subtitle' => 'Selamat datang di panel administrasi SedotWC'
])

@section('content')

<!-- Statistics Cards -->
<div class="row mb-4" style="min-height: 120px;">
    <div class="col-xl-2 col-md-4 col-sm-6 mb-3 d-flex">
        <div class="card border-left-primary shadow h-100 py-2 w-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Order
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalOrders) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-receipt fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-sm-6 mb-3 d-flex">
        <div class="card border-left-success shadow h-100 py-2 w-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Revenue
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-cash fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-sm-6 mb-3 d-flex">
        <div class="card border-left-warning shadow h-100 py-2 w-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pending
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($pendingOrders) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-clock fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-sm-6 mb-3 d-flex">
        <div class="card border-left-info shadow h-100 py-2 w-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Pelanggan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalCustomers) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-sm-6 mb-3 d-flex">
        <div class="card border-left-secondary shadow h-100 py-2 w-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Layanan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalServices) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-wrench-adjustable fa-2x text-secondary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-sm-6 mb-3 d-flex">
        <div class="card border-left-dark shadow h-100 py-2 w-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                            Blog
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalBlogs) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-newspaper fa-2x text-dark"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12 d-flex">
        <div class="card shadow w-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-lightning-charge me-2"></i>Aksi Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                        <a href="{{ route('admin.services.create') }}" class="btn btn-outline-primary btn-sm w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-plus-circle fs-3 mb-2"></i>
                            <span class="small">Tambah Layanan</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-success btn-sm w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-receipt fs-3 mb-2"></i>
                            <span class="small">Kelola Order</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                        <a href="{{ route('admin.blogs.create') }}" class="btn btn-outline-info btn-sm w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-newspaper fs-3 mb-2"></i>
                            <span class="small">Tulis Blog</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-warning btn-sm w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-people fs-3 mb-2"></i>
                            <span class="small">Kelola Pelanggan</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                        <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary btn-sm w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-images fs-3 mb-2"></i>
                            <span class="small">Upload Media</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                        <a href="{{ route('admin.settings.backup') }}" class="btn btn-outline-dark btn-sm w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-database fs-3 mb-2"></i>
                            <span class="small">Backup Data</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <!-- Revenue Chart -->
    <div class="col-md-8 mb-4 d-flex">
        <div class="card shadow w-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Revenue Bulanan {{ date('Y') }}</h6>
            </div>
            <div class="card-body" style="padding: 15px;">
                <div style="height: 320px; position: relative;">
                    <canvas id="revenueChart" width="100%" height="320"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Status Chart -->
    <div class="col-md-4 mb-4 d-flex">
        <div class="card shadow w-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Status Order</h6>
            </div>
            <div class="card-body" style="padding: 15px;">
                <div style="height: 320px; position: relative; display: flex; align-items: center; justify-content: center;">
                    <canvas id="orderStatusChart" width="100%" height="320"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tables Row -->
<div class="row">
    <!-- Recent Orders -->
    <div class="col-md-6 mb-4 d-flex">
        <div class="card shadow w-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Order Terbaru</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->service->title ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status_badge }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada order</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-sm">Lihat Semua Order</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Services -->
    <div class="col-md-6 mb-4 d-flex">
        <div class="card shadow w-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Layanan Populer</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Layanan</th>
                                <th>Total Order</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($popularServices as $service)
                            <tr>
                                <td>{{ $service->title }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $service->orders_count }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">Belum ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('admin.services.index') }}" class="btn btn-primary btn-sm">Kelola Layanan</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Welcome Tutorial Modal -->
<div class="modal fade" id="welcomeTutorialModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-stars me-2"></i>Selamat Datang di SedotWC Admin!
                </h5>
            </div>
            <div class="modal-body">
                <div id="tutorialCarousel" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-inner">
                        <!-- Slide 1: Introduction -->
                        <div class="carousel-item active">
                            <div class="text-center mb-4">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-tools text-primary fs-1"></i>
                                </div>
                                <h4 class="fw-bold">Selamat Datang!</h4>
                                <p class="text-muted">Ini adalah panel administrasi SedotWC. Mari kita jelajahi fitur-fitur utamanya.</p>
                            </div>
                        </div>

                        <!-- Slide 2: Navigation -->
                        <div class="carousel-item">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="bg-light rounded p-3 mb-3">
                                        <i class="bi bi-list text-primary fs-2 me-2"></i>
                                        <span class="fw-bold">Menu Toggle</span>
                                        <p class="text-muted small mb-0">Klik untuk menyembunyikan/tampilkan sidebar</p>
                                    </div>
                                    <div class="bg-light rounded p-3">
                                        <i class="bi bi-bell text-warning fs-2 me-2"></i>
                                        <span class="fw-bold">Notifikasi</span>
                                        <p class="text-muted small mb-0">Pantau aktivitas terbaru sistem</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-gradient rounded p-4 text-white text-center">
                                        <h5>Sidebar Navigation</h5>
                                        <p class="mb-0">Menu navigasi utama untuk mengakses semua fitur admin</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 3: Dashboard -->
                        <div class="carousel-item">
                            <div class="text-center mb-4">
                                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-speedometer2 text-success fs-1"></i>
                                </div>
                                <h4 class="fw-bold">Dashboard Overview</h4>
                                <p class="text-muted">Pantau statistik penting bisnis Anda di satu tempat</p>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card border-primary">
                                        <div class="card-body text-center">
                                            <i class="bi bi-receipt text-primary fs-2 mb-2"></i>
                                            <h6>Total Order</h6>
                                            <small class="text-muted">Lihat semua pesanan</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-success">
                                        <div class="card-body text-center">
                                            <i class="bi bi-cash text-success fs-2 mb-2"></i>
                                            <h6>Total Revenue</h6>
                                            <small class="text-muted">Pantau pendapatan</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-info">
                                        <div class="card-body text-center">
                                            <i class="bi bi-people text-info fs-2 mb-2"></i>
                                            <h6>Total Pelanggan</h6>
                                            <small class="text-muted">Kelola basis pelanggan</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 4: Main Features -->
                        <div class="carousel-item">
                            <h5 class="fw-bold mb-3">Fitur Utama yang Tersedia:</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-wrench-adjustable text-primary me-3 fs-4"></i>
                                        <div>
                                            <h6 class="mb-1">Kelola Layanan</h6>
                                            <small class="text-muted">Tambah, edit, dan nonaktifkan layanan sedot WC</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-receipt text-success me-3 fs-4"></i>
                                        <div>
                                            <h6 class="mb-1">Kelola Order</h6>
                                            <small class="text-muted">Pantau dan update status pesanan</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-people text-info me-3 fs-4"></i>
                                        <div>
                                            <h6 class="mb-1">Kelola Pelanggan</h6>
                                            <small class="text-muted">Data dan riwayat pelanggan</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-newspaper text-warning me-3 fs-4"></i>
                                        <div>
                                            <h6 class="mb-1">Kelola Blog</h6>
                                            <small class="text-muted">Konten dan artikel website</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 5: Getting Started -->
                        <div class="carousel-item">
                            <div class="text-center mb-4">
                                <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-rocket-takeoff text-info fs-1"></i>
                                </div>
                                <h4 class="fw-bold">Siap Memulai?</h4>
                                <p class="text-muted">Anda sudah siap mengelola bisnis SedotWC dengan panel admin ini!</p>
                            </div>
                            <div class="alert alert-info">
                                <h6><i class="bi bi-lightbulb me-2"></i>Tips untuk Memulai:</h6>
                                <ul class="mb-0 text-start">
                                    <li>Periksa dashboard untuk melihat statistik terkini</li>
                                    <li>Kelola layanan di menu "Layanan"</li>
                                    <li>Pantau pesanan masuk di menu "Order"</li>
                                    <li>Update konten website melalui menu "Blog" dan "CMS Pages"</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Carousel Controls -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button class="btn btn-outline-secondary" type="button" data-bs-target="#tutorialCarousel" data-bs-slide="prev">
                            <i class="bi bi-chevron-left me-1"></i>Sebelumnya
                        </button>
                        <div>
                            <span class="badge bg-primary me-2" id="currentSlide">1</span>
                            <small class="text-muted">dari 5</small>
                        </div>
                        <button class="btn btn-primary" type="button" data-bs-target="#tutorialCarousel" data-bs-slide="next" id="nextBtn">
                            Selanjutnya<i class="bi bi-chevron-right ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="dontShowAgain">
                    <label class="form-check-label small text-muted" for="dontShowAgain">
                        Jangan tampilkan lagi
                    </label>
                </div>
                <button type="button" class="btn btn-success" id="finishTutorial" style="display: none;">
                    <i class="bi bi-check-circle me-1"></i>Saya Mengerti!
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show tutorial modal for first-time users
    const tutorialModal = new bootstrap.Modal(document.getElementById('welcomeTutorialModal'), {
        backdrop: 'static',
        keyboard: false
    });

    // Check if user has seen tutorial before
    const hasSeenTutorial = localStorage.getItem('sedotwc_admin_tutorial_seen');
    if (!hasSeenTutorial) {
        tutorialModal.show();
    }

    // Update slide indicator
    const carousel = document.getElementById('tutorialCarousel');
    const currentSlideBadge = document.getElementById('currentSlide');
    const nextBtn = document.getElementById('nextBtn');
    const finishBtn = document.getElementById('finishTutorial');

    carousel.addEventListener('slid.bs.carousel', function(event) {
        const activeIndex = event.to + 1;
        currentSlideBadge.textContent = activeIndex;

        if (activeIndex === 5) {
            nextBtn.style.display = 'none';
            finishBtn.style.display = 'inline-block';
        } else {
            nextBtn.style.display = 'inline-block';
            finishBtn.style.display = 'none';
        }
    });

    // Finish tutorial
    finishBtn.addEventListener('click', function() {
        const dontShowAgain = document.getElementById('dontShowAgain').checked;
        if (dontShowAgain) {
            localStorage.setItem('sedotwc_admin_tutorial_seen', 'true');
        }
        tutorialModal.hide();
    });

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const monthlyRevenue = @json($monthlyRevenue);

    const revenueData = Array.from({length: 12}, (_, i) => {
        const month = i + 1;
        const data = monthlyRevenue.find(item => item.month == month);
        return data ? data.revenue : 0;
    });

    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Revenue (Rp)',
                data: revenueData,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                x: {
                    ticks: {
                        maxTicksLimit: 12
                    }
                }
            }
        }
    });

    // Order Status Chart
    const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
    const orderStatuses = @json($orderStatuses);

    const statusLabels = orderStatuses.map(item => {
        const statusMap = {
            'pending': 'Pending',
            'confirmed': 'Dikonfirmasi',
            'in_progress': 'Dikerjakan',
            'completed': 'Selesai',
            'cancelled': 'Dibatalkan'
        };
        return statusMap[item.status] || item.status;
    });

    const statusColors = {
        'pending': '#ffc107',
        'confirmed': '#17a2b8',
        'in_progress': '#007bff',
        'completed': '#28a745',
        'cancelled': '#dc3545'
    };

    const statusData = orderStatuses.map(item => item.count);

    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData,
                backgroundColor: orderStatuses.map(item => statusColors[item.status] || '#6c757d'),
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 10
                    }
                }
            }
        }
    });
});
</script>
@endpush

