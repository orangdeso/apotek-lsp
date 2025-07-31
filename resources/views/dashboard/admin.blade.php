@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('styles')
<style>
.stats-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 20px rgba(0,0,0,0.08);
}
.stats-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}
.welcome-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 16px;
    border: none;
    box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
}
.chart-container {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: none;
}
.stats-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}
.stats-number {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
}
.stats-label {
    color: #6c757d;
    font-size: 0.875rem;
    margin: 0;
}
.quick-action-card {
    border: 2px dashed #e9ecef;
    border-radius: 12px;
    transition: all 0.3s ease;
}
.quick-action-card:hover {
    border-color: #8c57ff;
    background-color: #f8f7ff;
    transform: translateY(-2px);
}
.activity-item {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    background: #f8f9fa;
    border-left: 4px solid #8c57ff;
}
</style>
@endsection

@section('content')
<!-- Welcome Card -->
<div class="row">
    <div class="col-12">
        <div class="card welcome-card mb-6">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-white mb-3">Welcome, Admin! 👨‍💼</h5>
                        <p class="mb-4 text-white-50">
                            Panel administrasi untuk mengelola seluruh sistem apotek. Kelola pengguna, supplier, inventori, dan transaksi dengan mudah.
                        </p>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="#" class="btn btn-light btn-sm">
                                <i class="bx bx-user me-1"></i>Kelola Pengguna
                            </a>
                            <a href="#" class="btn btn-outline-light btn-sm">
                                <i class="bx bx-package me-1"></i>Kelola Obat
                            </a>
                            <a href="#" class="btn btn-outline-light btn-sm">
                                <i class="bx bx-bar-chart-alt-2 me-1"></i>Lihat Laporan
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-6">
                        <img src="{{ asset('template-bootstrap/img/illustrations/trophy.png') }}" height="175" class="scaleX-n1-rtl" alt="Admin Dashboard">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-lg-8 mb-6 order-0">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-6 mb-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <i class="stat-icon bx bx-user text-primary"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded text-muted"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                    <a class="dropdown-item" href="#">Lihat Detail</a>
                                    <a class="dropdown-item" href="#">Kelola Pengguna</a>
                                </div>
                            </div>
                        </div>
                        <p class="stat-label mb-1">Total Pengguna</p>
                        <h4 class="stat-number mb-0">{{ App\Models\User::count() }}</h4>
                        <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +12% dari bulan lalu</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-6 mb-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <i class="stat-icon bx bx-health text-success"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded text-muted"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="cardOpt2">
                                    <a class="dropdown-item" href="#">Lihat Detail</a>
                                    <a class="dropdown-item" href="#">Kelola Apoteker</a>
                                </div>
                            </div>
                        </div>
                        <p class="stat-label mb-1">Apoteker</p>
                        <h4 class="stat-number mb-0">{{ App\Models\User::where('role', 'apoteker')->count() }}</h4>
                        <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +8% dari bulan lalu</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-6 mb-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <i class="stat-icon bx bx-group text-warning"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded text-muted"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="cardOpt3">
                                    <a class="dropdown-item" href="#">Lihat Detail</a>
                                    <a class="dropdown-item" href="#">Kelola Pelanggan</a>
                                </div>
                            </div>
                        </div>
                        <p class="stat-label mb-1">Pelanggan</p>
                        <h4 class="stat-number mb-0">{{ App\Models\User::where('role', 'pelanggan')->count() }}</h4>
                        <small class="text-info fw-medium"><i class="bx bx-user-check"></i> +15% dari bulan lalu</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-6 mb-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <i class="stat-icon bx bx-package text-info"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded text-muted"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="cardOpt4">
                                    <a class="dropdown-item" href="#">Lihat Detail</a>
                                    <a class="dropdown-item" href="#">Kelola Obat</a>
                                </div>
                            </div>
                        </div>
                        <p class="stat-label mb-1">Total Obat</p>
                        <h4 class="stat-number mb-0">{{ App\Models\Obat::count() ?? 0 }}</h4>
                        <small class="text-warning fw-medium"><i class="bx bx-package"></i> Stok tersedia</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-6 mb-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <i class="stat-icon bx bx-dollar text-success"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded text-muted"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="cardOpt5">
                                    <a class="dropdown-item" href="#">View Details</a>
                                    <a class="dropdown-item" href="#">Revenue Report</a>
                                </div>
                            </div>
                        </div>
                        <p class="stat-label mb-1">Revenue</p>
                        <h4 class="stat-number mb-0">$95.2k</h4>
                        <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +18.2% from last month</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-6 mb-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <i class="stat-icon bx bx-receipt text-primary"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded text-muted"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="cardOpt6">
                                    <a class="dropdown-item" href="#">View Details</a>
                                    <a class="dropdown-item" href="#">Transaction History</a>
                                </div>
                            </div>
                        </div>
                        <p class="stat-label mb-1">Transactions</p>
                        <h4 class="stat-number mb-0">1.2k</h4>
                        <small class="text-info fw-medium"><i class="bx bx-trending-up"></i> +5.8% from last week</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Analytics -->
<div class="row">
    <!-- Weekly Overview Chart -->
    <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between pb-0">
                <div class="card-title mb-0">
                    <h5 class="m-0 me-2">Aktivitas Mingguan</h5>
                    <small class="text-muted">Total 48.5k kunjungan</small>
                </div>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                        <a class="dropdown-item" href="javascript:void(0);">Lihat Detail</a>
                        <a class="dropdown-item" href="javascript:void(0);">Download</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex flex-column align-items-center gap-1">
                        <h2 class="mb-2">8,258</h2>
                        <span class="badge bg-label-success">+2.6%</span>
                    </div>
                    <div id="weeklyOverviewChart"></div>
                </div>
                <ul class="p-0 m-0">
                    <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-user"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">Pengguna Baru</h6>
                                <small class="text-muted">Registrasi minggu ini</small>
                            </div>
                            <div class="user-progress">
                                <small class="fw-medium">+12</small>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-package"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">Obat Terjual</h6>
                                <small class="text-muted">Penjualan minggu ini</small>
                            </div>
                            <div class="user-progress">
                                <small class="fw-medium">+8.2k</small>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- User Distribution Chart -->
    <div class="col-md-6 col-lg-4 order-1 mb-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Distribusi Pengguna</h5>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="userDistribution" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDistribution">
                        <a class="dropdown-item" href="javascript:void(0);">Lihat Detail</a>
                        <a class="dropdown-item" href="javascript:void(0);">Download</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="userDistributionChart"></div>
                <ul class="p-0 m-0">
                    <li class="d-flex mb-3">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-user-check"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="text-muted d-block">Admin</small>
                                <h6 class="mb-0">{{ App\Models\User::where('role', 'admin')->count() }}</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                                <h6 class="mb-0">{{ number_format((App\Models\User::where('role', 'admin')->count() / max(App\Models\User::count(), 1)) * 100, 1) }}%</h6>
                                <span class="text-muted">dari total</span>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex mb-3">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-health"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="text-muted d-block">Apoteker</small>
                                <h6 class="mb-0">{{ App\Models\User::where('role', 'apoteker')->count() }}</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                                <h6 class="mb-0">{{ number_format((App\Models\User::where('role', 'apoteker')->count() / max(App\Models\User::count(), 1)) * 100, 1) }}%</h6>
                                <span class="text-muted">dari total</span>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-group"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="text-muted d-block">Pelanggan</small>
                                <h6 class="mb-0">{{ App\Models\User::where('role', 'pelanggan')->count() }}</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                                <h6 class="mb-0">{{ number_format((App\Models\User::where('role', 'pelanggan')->count() / max(App\Models\User::count(), 1)) * 100, 1) }}%</h6>
                                <span class="text-muted">dari total</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="col-md-12 col-lg-4 order-2 mb-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.pharmacists.index') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="bx bx-user me-2"></i>
                        <div class="text-start">
                            <div class="fw-medium">Kelola Pengguna</div>
                            <small class="text-white-50">Tambah, edit, hapus pengguna</small>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-info d-flex align-items-center">
                        <i class="bx bx-store me-2"></i>
                        <div class="text-start">
                            <div class="fw-medium">Kelola Supplier</div>
                            <small class="text-white-50">Manajemen data supplier</small>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.obat.index') }}" class="btn btn-success d-flex align-items-center">
                        <i class="bx bx-package me-2"></i>
                        <div class="text-start">
                            <div class="fw-medium">Kelola Obat</div>
                            <small class="text-white-50">Manajemen data obat & stok</small>
                        </div>
                    </a>
                    
                    <div class="mt-3">
                        <h6 class="mb-3">Statistik Hari Ini</h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Login Pengguna</span>
                            <span class="fw-medium">24</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Obat Terjual</span>
                            <span class="fw-medium">156</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Transaksi</span>
                            <span class="fw-medium">42</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0">Aktivitas Terbaru</h5>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="recentActivity" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="recentActivity">
                        <a class="dropdown-item" href="javascript:void(0);">Lihat Semua</a>
                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="timeline">
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-primary"></span>
                        <div class="timeline-event">
                            <div class="timeline-header mb-1">
                                <h6 class="mb-0">Pengguna baru terdaftar</h6>
                                <small class="text-muted">2 menit yang lalu</small>
                            </div>
                            <p class="mb-0">John Doe mendaftar sebagai pelanggan baru</p>
                        </div>
                    </li>
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-success"></span>
                        <div class="timeline-event">
                            <div class="timeline-header mb-1">
                                <h6 class="mb-0">Obat baru ditambahkan</h6>
                                <small class="text-muted">1 jam yang lalu</small>
                            </div>
                            <p class="mb-0">Paracetamol 500mg berhasil ditambahkan ke inventory</p>
                        </div>
                    </li>
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-info"></span>
                        <div class="timeline-event">
                            <div class="timeline-header mb-1">
                                <h6 class="mb-0">Supplier diperbarui</h6>
                                <small class="text-muted">3 jam yang lalu</small>
                            </div>
                            <p class="mb-0">Data supplier PT. Kimia Farma telah diperbarui</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Vendors JS -->
<script src="{{ asset('template-bootstrap/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Page JS -->
<script>
'use strict';

(function () {
  let cardColor, labelColor, borderColor, legendColor;
  
  cardColor = '#fff';
  labelColor = '#6d6777';
  borderColor = '#eae9ec';
  legendColor = '#6d6777';

  // Weekly Overview Chart
  const weeklyOverviewChartEl = document.querySelector('#weeklyOverviewChart');
  if (weeklyOverviewChartEl) {
    const weeklyOverviewChartConfig = {
      chart: {
        type: 'bar',
        height: 200,
        offsetY: -9,
        offsetX: -16,
        parentHeightOffset: 0,
        toolbar: {
          show: false
        }
      },
      series: [
        {
          name: 'Kunjungan',
          data: [32, 55, 45, 75, 55, 35, 70]
        }
      ],
      colors: ['#8c57ff'],
      plotOptions: {
        bar: {
          borderRadius: 8,
          columnWidth: '30%',
          endingShape: 'rounded',
          startingShape: 'rounded'
        }
      },
      dataLabels: {
        enabled: false
      },
      legend: {
        show: false
      },
      grid: {
        show: false,
        padding: {
          top: -15,
          bottom: -12,
          left: 0,
          right: 0
        }
      },
      xaxis: {
        categories: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
        labels: {
          show: false
        },
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        }
      },
      yaxis: {
        show: false
      },
      responsive: [
        {
          breakpoint: 1025,
          options: {
            chart: {
              height: 199
            }
          }
        }
      ]
    };
    const weeklyOverviewChart = new ApexCharts(weeklyOverviewChartEl, weeklyOverviewChartConfig);
    weeklyOverviewChart.render();
  }

  // User Distribution Chart
  const userDistributionChartEl = document.querySelector('#userDistributionChart');
  if (userDistributionChartEl) {
    const userDistributionConfig = {
      chart: {
        height: 165,
        width: 130,
        type: 'donut'
      },
      labels: ['Admin', 'Apoteker', 'Pelanggan'],
      series: [{{ App\Models\User::where('role', 'admin')->count() }}, {{ App\Models\User::where('role', 'apoteker')->count() }}, {{ App\Models\User::where('role', 'pelanggan')->count() }}],
      colors: ['#8c57ff', '#56ca00', '#ffb400'],
      stroke: {
        width: 5,
        colors: cardColor
      },
      dataLabels: {
        enabled: false,
        formatter: function (val, opt) {
          return parseInt(val) + '%';
        }
      },
      legend: {
        show: false
      },
      grid: {
        padding: {
          top: 0,
          bottom: 0,
          right: 15
        }
      },
      plotOptions: {
        pie: {
          donut: {
            size: '75%',
            labels: {
              show: true,
              value: {
                fontSize: '1.5rem',
                fontFamily: 'Inter',
                color: labelColor,
                offsetY: 16,
                formatter: function (val) {
                  return parseInt(val);
                }
              },
              name: {
                offsetY: -10,
                show: true,
                fontSize: '1rem',
                color: labelColor,
                fontFamily: 'Inter',
                formatter: function (val) {
                  return val;
                }
              },
              total: {
                show: true,
                fontSize: '1rem',
                color: labelColor,
                label: 'Total',
                formatter: function (w) {
                  return {{ App\Models\User::count() }};
                }
              }
            }
          }
        }
      }
    };
    const userDistributionChart = new ApexCharts(userDistributionChartEl, userDistributionConfig);
    userDistributionChart.render();
  }
})();
</script>
@endsection