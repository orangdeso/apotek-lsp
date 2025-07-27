@extends('layouts.app')

@section('title', 'Dashboard Pharmacist')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-6" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-white mb-3">Selamat Datang Apoteker! 💊</h5>
                        <p class="mb-6 text-white">
                            Panel apoteker untuk mengelola obat, stok, dan melayani resep pelanggan.
                        </p>
                        <a href="{{ route('pharmacist.obat.index') }}" class="btn btn-sm btn-light">Kelola Obat</a>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-6">
                        <img src="{{ asset('template-bootstrap/img/illustrations/trophy.png') }}" height="175" class="scaleX-n1-rtl" alt="Apoteker Dashboard">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Apoteker Statistics Cards -->
<div class="row">
    <div class="col-lg-3 col-md-6 col-12 mb-6">
        <div class="card h-100 border-success">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                    <div class="avatar flex-shrink-0">
                        <i class="bx bx-capsule text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <p class="mb-1">Total Obat</p>
                <h4 class="card-title mb-3 text-success">150</h4>
                <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> Tersedia</small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-12 mb-6">
        <div class="card h-100 border-warning">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                    <div class="avatar flex-shrink-0">
                        <i class="bx bx-error text-warning" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <p class="mb-1">Stok Menipis</p>
                <h4 class="card-title mb-3 text-warning">12</h4>
                <small class="text-warning fw-medium"><i class="bx bx-down-arrow-alt"></i> Perlu Restok</small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-12 mb-6">
        <div class="card h-100 border-info">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                    <div class="avatar flex-shrink-0">
                        <i class="bx bx-receipt text-info" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <p class="mb-1">Resep Hari Ini</p>
                <h4 class="card-title mb-3 text-info">25</h4>
                <small class="text-info fw-medium"><i class="bx bx-time"></i> Aktif</small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-12 mb-6">
        <div class="card h-100 border-primary">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                    <div class="avatar flex-shrink-0">
                        <i class="bx bx-check-circle text-primary" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <p class="mb-1">Resep Selesai</p>
                <h4 class="card-title mb-3 text-primary">18</h4>
                <small class="text-primary fw-medium"><i class="bx bx-check"></i> Selesai</small>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions for Apoteker -->
<div class="row">
    <div class="col-md-6 col-lg-4 mb-6">
        <div class="card h-100 border-success">
            <div class="card-body">
                <h5 class="card-title text-success">Kelola Obat</h5>
                <p class="card-text">Tambah, edit, atau hapus data obat</p>
                <a href="{{ route('pharmacist.obat.index') }}" class="btn btn-success">Kelola Obat</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-4 mb-6">
        <div class="card h-100 border-info">
            <div class="card-body">
                <h5 class="card-title text-info">Proses Resep</h5>
                <p class="card-text">Kelola resep dan transaksi</p>
                <a href="{{ route('pharmacist.resep.index') }}" class="btn btn-info">Proses Resep</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-4 mb-6">
        <div class="card h-100 border-warning">
            <div class="card-body">
                <h5 class="card-title text-warning">Laporan Stok</h5>
                <p class="card-text">Monitor stok dan laporan</p>
                <a href="{{ route('pharmacist.laporan.index') }}" class="btn btn-warning">Lihat Laporan</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Apoteker dashboard specific scripts -->
@endsection