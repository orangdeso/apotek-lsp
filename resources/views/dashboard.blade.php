@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<!-- Dashboard specific styles -->
<style>
    .dashboard-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }
    
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        position: relative;
    }
    
    .stats-card-2 {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    
    .stats-card-3 {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    
    .stats-card-4 {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }
    
    .welcome-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 20px;
        overflow: hidden;
        position: relative;
    }
    
    .welcome-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="80" cy="20" r="20" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="60" r="15" fill="rgba(255,255,255,0.08)"/><circle cx="70" cy="80" r="10" fill="rgba(255,255,255,0.06)"/></svg>') no-repeat;
        background-size: cover;
        opacity: 0.3;
    }
    
    .chart-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        background: white;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-bottom: 1rem;
    }
    
    .stat-change {
        font-size: 0.85rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.2);
    }
    
    .icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        margin-bottom: 1rem;
    }
    
    .icon-wrapper i {
        font-size: 1.8rem;
        color: white;
    }
    
    .transaction-item {
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 0.75rem;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .transaction-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }
    
    .btn-modern {
        border-radius: 25px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        border: none;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .card-header-modern {
        background: transparent;
        border-bottom: 1px solid #e9ecef;
        padding: 1.5rem;
    }
    
    .nav-pills-modern .nav-link {
        border-radius: 25px;
        padding: 0.5rem 1.5rem;
        margin-right: 0.5rem;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }
    
    .nav-pills-modern .nav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
    }
    
    .avatar-modern {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .transaction-item {
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }
    
    .transaction-item:hover {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        padding: 15px;
        margin: 0 -15px;
    }
    
    .transaction-item:last-child {
        border-bottom: none;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%) !important;
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
    }
    
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card welcome-card mb-6">
            <div class="d-flex align-items-end row position-relative">
                <div class="col-sm-7">
                    <div class="card-body position-relative" style="z-index: 2;">
                        <h5 class="card-title mb-3" style="font-size: 1.8rem; font-weight: 700;">Selamat Datang di LSP Apotek! 🎉</h5>
                        <p class="mb-4" style="font-size: 1.1rem; opacity: 0.9;">
                            Sistem manajemen apotek yang membantu Anda mengelola data obat, pelanggan, dan transaksi dengan mudah.
                        </p>
                        <a href="#" class="btn btn-modern">Lihat Laporan</a>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-6 position-relative" style="z-index: 2;">
                        <img src="{{ asset('template-bootstrap/img/illustrations/trophy.png') }}" height="175" class="scaleX-n1-rtl" alt="View Badge User" style="filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-lg-3 col-md-6 col-12 mb-6">
        <div class="card dashboard-card stats-card h-100">
            <div class="card-body text-center">
                <div class="icon-wrapper mx-auto">
                    <i class="bx bx-capsule"></i>
                </div>
                <div class="stat-label">Total Obat</div>
                <div class="stat-number">1,245</div>
                <div class="stat-change">
                    <i class="bx bx-up-arrow-alt"></i> +12.2%
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-12 mb-6">
        <div class="card dashboard-card stats-card-2 h-100">
            <div class="card-body text-center">
                <div class="icon-wrapper mx-auto">
                    <i class="bx bx-wallet"></i>
                </div>
                <div class="stat-label">Penjualan Hari Ini</div>
                <div class="stat-number">2.45M</div>
                <div class="stat-change">
                    <i class="bx bx-up-arrow-alt"></i> +28.42%
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-12 mb-6">
        <div class="card dashboard-card stats-card-3 h-100">
            <div class="card-body text-center">
                <div class="icon-wrapper mx-auto">
                    <i class="bx bx-group"></i>
                </div>
                <div class="stat-label">Total Pelanggan</div>
                <div class="stat-number">425</div>
                <div class="stat-change">
                    <i class="bx bx-down-arrow-alt"></i> -14.82%
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-12 mb-6">
        <div class="card dashboard-card stats-card-4 h-100">
            <div class="card-body text-center">
                <div class="icon-wrapper mx-auto">
                    <i class="bx bx-credit-card"></i>
                </div>
                <div class="stat-label">Transaksi Bulan Ini</div>
                <div class="stat-number">1,892</div>
                <div class="stat-change">
                    <i class="bx bx-up-arrow-alt"></i> +25.2%
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Tables -->
<div class="row">
    <!-- Order Statistics -->
    <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
        <div class="card chart-card h-100">
            <div class="card-header card-header-modern d-flex justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1 me-2" style="font-weight: 700; color: #2c3e50;">Statistik Penjualan</h5>
                    <p class="card-subtitle text-muted">Total penjualan minggu ini</p>
                </div>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded text-muted"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                        <a class="dropdown-item" href="#">Select All</a>
                        <a class="dropdown-item" href="#">Refresh</a>
                        <a class="dropdown-item" href="#">Share</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-6">
                    <div class="d-flex flex-column align-items-center gap-1">
                        <h3 class="mb-1">8,258</h3>
                        <small>Total Transaksi</small>
                    </div>
                    <div id="orderStatisticsChart"></div>
                </div>
                <ul class="p-0 m-0">
                    <li class="d-flex align-items-center mb-4 p-3 rounded" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); border-left: 4px solid #667eea;">
                        <div class="avatar-modern flex-shrink-0 me-3 bg-gradient-primary text-white">
                            <i class="bx bx-capsule"></i>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0 fw-bold">Obat Resep</h6>
                                <small class="text-muted">Obat dengan resep dokter</small>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0 fw-bold text-primary">82.5k</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center mb-4 p-3 rounded" style="background: linear-gradient(135deg, rgba(86, 171, 47, 0.1) 0%, rgba(168, 230, 207, 0.1) 100%); border-left: 4px solid #56ab2f;">
                        <div class="avatar-modern flex-shrink-0 me-3 bg-gradient-success text-white">
                            <i class="bx bx-plus-medical"></i>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0 fw-bold">Obat Bebas</h6>
                                <small class="text-muted">Obat tanpa resep</small>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0 fw-bold text-success">23.8k</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center mb-4 p-3 rounded" style="background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%); border-left: 4px solid #4facfe;">
                        <div class="avatar-modern flex-shrink-0 me-3 bg-gradient-info text-white">
                            <i class="bx bx-health"></i>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0 fw-bold">Vitamin & Suplemen</h6>
                                <small class="text-muted">Suplemen kesehatan</small>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0 fw-bold text-info">849k</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center p-3 rounded" style="background: linear-gradient(135deg, rgba(240, 147, 251, 0.1) 0%, rgba(245, 87, 108, 0.1) 100%); border-left: 4px solid #f093fb;">
                        <div class="avatar-modern flex-shrink-0 me-3 bg-gradient-warning text-white">
                            <i class="bx bx-first-aid"></i>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0 fw-bold">Alat Kesehatan</h6>
                                <small class="text-muted">Peralatan medis</small>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0 fw-bold" style="color: #f093fb;">99</h6>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--/ Order Statistics -->
    
    <!-- Expense Overview -->
    <div class="col-md-6 col-lg-8 order-1 mb-6">
        <div class="card chart-card h-100">
            <div class="card-header card-header-modern nav-align-top">
                <ul class="nav nav-pills nav-pills-modern" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tabs-line-card-income" aria-controls="navs-tabs-line-card-income" aria-selected="true">
                            Pendapatan
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab">Pengeluaran</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab">Profit</button>
                    </li>
                </ul>
            </div>
            <div class="card-body px-0">
                <div class="tab-content p-0">
                    <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                        <div class="d-flex p-6 pt-0">
                            <div class="avatar-modern flex-shrink-0 me-3 bg-gradient-primary text-white">
                                <i class="bx bx-wallet"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Total Pendapatan</h6>
                                <small class="text-muted">Minggu ini dibandingkan minggu lalu</small>
                            </div>
                        </div>
                        <div id="incomeChart"></div>
                        <div class="d-flex align-items-center justify-content-center mt-6 gap-3 p-4 rounded" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);">
                            <div class="flex-shrink-0">
                                <div id="expensesOfWeek"></div>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold" style="font-size: 1.5rem; color: #667eea;">Rp 4,230,000</h6>
                                <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> 58% lebih tinggi dari minggu lalu</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Expense Overview -->
</div>

<!-- Recent Transactions -->
<div class="row">
    <div class="col-md-6 col-lg-4 order-2 mb-6">
        <div class="card chart-card h-100">
            <div class="card-header card-header-modern d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2" style="font-weight: 700; color: #2c3e50;">Transaksi Terbaru</h5>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded text-muted"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                        <a class="dropdown-item" href="#">Last 28 Days</a>
                        <a class="dropdown-item" href="#">Last Month</a>
                        <a class="dropdown-item" href="#">Last Year</a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-4">
                <ul class="p-0 m-0">
                    <li class="transaction-item">
                        <div class="d-flex align-items-center">
                            <div class="avatar-modern flex-shrink-0 me-3 bg-gradient-primary text-white">
                                <i class="bx bx-credit-card"></i>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="d-block text-muted fw-medium">Paypal</small>
                                    <h6 class="fw-bold mb-0">Penjualan Obat</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-2">
                                    <h6 class="fw-bold mb-0 text-success">+Rp 82,600</h6>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="transaction-item">
                        <div class="d-flex align-items-center">
                            <div class="avatar-modern flex-shrink-0 me-3 bg-gradient-warning text-white">
                                <i class="bx bx-wallet"></i>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="d-block text-muted fw-medium">Wallet</small>
                                    <h6 class="fw-bold mb-0">Pembelian Stok</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-2">
                                    <h6 class="fw-bold mb-0 text-danger">-Rp 270,700</h6>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="transaction-item">
                        <div class="d-flex align-items-center">
                            <div class="avatar-modern flex-shrink-0 me-3 bg-gradient-info text-white">
                                <i class="bx bx-transfer"></i>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="d-block text-muted fw-medium">Transfer</small>
                                    <h6 class="fw-bold mb-0">Refund</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-2">
                                    <h6 class="fw-bold mb-0 text-success">+Rp 637,430</h6>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="transaction-item">
                        <div class="d-flex align-items-center">
                            <div class="avatar-modern flex-shrink-0 me-3 bg-gradient-success text-white">
                                <i class="bx bx-credit-card-alt"></i>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="d-block text-muted fw-medium">Credit Card</small>
                                    <h6 class="fw-bold mb-0">Digital Wallet</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-2">
                                    <h6 class="fw-bold mb-0 text-danger">-Rp 838,710</h6>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="transaction-item" style="margin-bottom: 0;">
                        <div class="d-flex align-items-center">
                            <div class="avatar-modern flex-shrink-0 me-3" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white;">
                                <i class="bx bx-building-house"></i>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="d-block text-muted fw-medium">Bank Transfer</small>
                                    <h6 class="fw-bold mb-0">Withdraw</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-2">
                                    <h6 class="fw-bold mb-0 text-danger">-Rp 546,500</h6>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--/ Transactions -->
    
    <!-- Activity Timeline -->
    <div class="col-md-6 col-lg-8 order-3 order-lg-2">
        <div class="row">
            <div class="col-6 mb-6">
                <div class="card dashboard-card h-100" style="background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%); color: white;">
                    <div class="card-body text-center">
                        <div class="icon-wrapper mx-auto">
                            <i class="bx bx-trending-up"></i>
                        </div>
                        <div class="stat-label">Profit</div>
                        <div class="stat-number" style="font-size: 2rem;">12.6K</div>
                        <div class="stat-change">
                            <i class="bx bx-up-arrow-alt"></i> +72.80%
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 mb-6">
                <div class="card dashboard-card h-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                    <div class="card-body text-center">
                        <div class="icon-wrapper mx-auto">
                            <i class="bx bx-line-chart"></i>
                        </div>
                        <div class="stat-label">Sales</div>
                        <div class="stat-number" style="font-size: 2rem;">4.67K</div>
                        <div class="stat-change">
                            <i class="bx bx-up-arrow-alt"></i> +28.80%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('template-bootstrap/js/dashboards-analytics.js') }}"></script>
@endsection