@extends('layout.app')

@section('title', 'Dashboard')

@section('styles')
<!-- Dashboard specific styles -->
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-3">Selamat Datang di LSP Apotek! 🎉</h5>
                        <p class="mb-6">
                            Sistem manajemen apotek yang membantu Anda mengelola data obat, pelanggan, dan transaksi dengan mudah.
                        </p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Laporan</a>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-6">
                        <img src="{{ asset('template-bootstrap/img/illustrations/trophy.png') }}" height="175" class="scaleX-n1-rtl" alt="View Badge User">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-lg-3 col-md-6 col-12 mb-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('template-bootstrap/img/icons/misc/aviato.png') }}" alt="chart success" class="rounded">
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                            <a class="dropdown-item" href="#">View More</a>
                            <a class="dropdown-item" href="#">Delete</a>
                        </div>
                    </div>
                </div>
                <p class="mb-1">Total Obat</p>
                <h4 class="card-title mb-3">1,245</h4>
                <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +12.2%</small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-12 mb-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('template-bootstrap/img/icons/misc/wallet-info.png') }}" alt="wallet info" class="rounded">
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                            <a class="dropdown-item" href="#">View More</a>
                            <a class="dropdown-item" href="#">Delete</a>
                        </div>
                    </div>
                </div>
                <p class="mb-1">Penjualan Hari Ini</p>
                <h4 class="card-title mb-3">Rp 2,450,000</h4>
                <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-12 mb-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('template-bootstrap/img/icons/misc/paypal.png') }}" alt="paypal" class="rounded">
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                            <a class="dropdown-item" href="#">View More</a>
                            <a class="dropdown-item" href="#">Delete</a>
                        </div>
                    </div>
                </div>
                <p class="mb-1">Total Pelanggan</p>
                <h4 class="card-title mb-3">425</h4>
                <small class="text-danger fw-medium"><i class="bx bx-down-arrow-alt"></i> -14.82%</small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-12 mb-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('template-bootstrap/img/icons/misc/cc-primary.png') }}" alt="cc primary" class="rounded">
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded text-muted"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="cardOpt1">
                            <a class="dropdown-item" href="#">View More</a>
                            <a class="dropdown-item" href="#">Delete</a>
                        </div>
                    </div>
                </div>
                <p class="mb-1">Transaksi Bulan Ini</p>
                <h4 class="card-title mb-3">1,892</h4>
                <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +25.2%</small>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Tables -->
<div class="row">
    <!-- Order Statistics -->
    <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1 me-2">Statistik Penjualan</h5>
                    <p class="card-subtitle">Total penjualan minggu ini</p>
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
                    <li class="d-flex align-items-center mb-5">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">Obat Resep</h6>
                                <small>Mobile, Earbuds, TV</small>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0">82.5k</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center mb-5">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">Obat Bebas</h6>
                                <small>T-shirt, Jeans, Shoes</small>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0">23.8k</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center mb-5">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">Vitamin & Suplemen</h6>
                                <small>Fine Art, Dining</small>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0">849k</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-football"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">Alat Kesehatan</h6>
                                <small>Cricket Kit, Golf</small>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0">99</h6>
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
        <div class="card h-100">
            <div class="card-header nav-align-top">
                <ul class="nav nav-pills" role="tablist">
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
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{ asset('template-bootstrap/img/icons/misc/wallet-info.png') }}" alt="User">
                            </div>
                            <div>
                                <h6 class="mb-0">Total Pendapatan</h6>
                                <small>Minggu ini dibandingkan minggu lalu</small>
                            </div>
                        </div>
                        <div id="incomeChart"></div>
                        <div class="d-flex align-items-center justify-content-center mt-6 gap-3">
                            <div class="flex-shrink-0">
                                <div id="expensesOfWeek"></div>
                            </div>
                            <div>
                                <h6 class="mb-0">Rp 4,230,000</h6>
                                <small>58% lebih tinggi dari minggu lalu</small>
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
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Transaksi Terbaru</h5>
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
                    <li class="d-flex align-items-center mb-6">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="{{ asset('template-bootstrap/img/icons/misc/paypal.png') }}" alt="paypal" class="rounded">
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="d-block">Paypal</small>
                                <h6 class="fw-normal mb-0">Penjualan Obat</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="fw-normal mb-0">+Rp 82,600</h6>
                                <span class="text-muted">USD</span>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center mb-6">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="{{ asset('template-bootstrap/img/icons/misc/wallet.png') }}" alt="wallet" class="rounded">
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="d-block">Wallet</small>
                                <h6 class="fw-normal mb-0">Pembelian Stok</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="fw-normal mb-0">-Rp 270,700</h6>
                                <span class="text-muted">USD</span>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center mb-6">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="{{ asset('template-bootstrap/img/icons/misc/chart.png') }}" alt="transfer" class="rounded">
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="d-block">Transfer</small>
                                <h6 class="fw-normal mb-0">Refund</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="fw-normal mb-0">+Rp 637,430</h6>
                                <span class="text-muted">USD</span>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center mb-6">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="{{ asset('template-bootstrap/img/icons/misc/cc-success.png') }}" alt="credit card" class="rounded">
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="d-block">Credit Card</small>
                                <h6 class="fw-normal mb-0">Digital Wallet</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="fw-normal mb-0">-Rp 838,710</h6>
                                <span class="text-muted">USD</span>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="{{ asset('template-bootstrap/img/icons/misc/bank.png') }}" alt="bank" class="rounded">
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="d-block">Bank Transfer</small>
                                <h6 class="fw-normal mb-0">Withdraw</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="fw-normal mb-0">-Rp 546,500</h6>
                                <span class="text-muted">USD</span>
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
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('template-bootstrap/img/icons/misc/chart-success.png') }}" alt="chart success" class="rounded">
                            </div>
                        </div>
                        <p class="mb-1">Profit</p>
                        <h4 class="card-title mb-3">Rp 12,628</h4>
                        <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +72.80%</small>
                    </div>
                </div>
            </div>
            <div class="col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('template-bootstrap/img/icons/misc/cc-warning.png') }}" alt="cc warning" class="rounded">
                            </div>
                        </div>
                        <p class="mb-1">Sales</p>
                        <h4 class="card-title mb-3">Rp 4,679</h4>
                        <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.80%</small>
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