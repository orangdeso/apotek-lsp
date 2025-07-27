@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-3">Selamat Datang Admin! 👨‍💼</h5>
                        <p class="mb-6">
                            Panel administrasi untuk mengelola seluruh sistem apotek, pengguna, supplier, dan data obat.
                        </p>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">Kelola Pengguna</a>
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

<!-- Admin Statistics Cards -->
<div class="row">
    <div class="col-lg-3 col-md-6 col-12 mb-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                    <div class="avatar flex-shrink-0">
                        <i class="bx bx-user text-primary" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <p class="mb-1">Total Pengguna</p>
                <h4 class="card-title mb-3">{{ App\Models\User::count() }}</h4>
                <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> Aktif</small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-12 mb-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                    <div class="avatar flex-shrink-0">
                        <i class="bx bx-store text-info" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <p class="mb-1">Admin</p>
                <h4 class="card-title mb-3">{{ App\Models\User::where('role', 'admin')->count() }}</h4>
                <small class="text-info fw-medium"><i class="bx bx-user-check"></i> Role</small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-12 mb-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                    <div class="avatar flex-shrink-0">
                        <i class="bx bx-health text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <p class="mb-1">Apoteker</p>
                <h4 class="card-title mb-3">{{ App\Models\User::where('role', 'apoteker')->count() }}</h4>
                <small class="text-success fw-medium"><i class="bx bx-user-plus"></i> Role</small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-12 mb-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                    <div class="avatar flex-shrink-0">
                        <i class="bx bx-group text-warning" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <p class="mb-1">Pelanggan</p>
                <h4 class="card-title mb-3">{{ App\Models\User::where('role', 'pelanggan')->count() }}</h4>
                <small class="text-warning fw-medium"><i class="bx bx-user"></i> Role</small>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-md-6 col-lg-4 mb-6">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Kelola Pengguna</h5>
                <p class="card-text">Tambah, edit, atau hapus pengguna sistem</p>
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Kelola Pengguna</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-4 mb-6">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Kelola Supplier</h5>
                <p class="card-text">Manajemen data supplier obat</p>
                <a href="{{ route('admin.suppliers.index') }}" class="btn btn-info">Kelola Supplier</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-4 mb-6">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Kelola Obat</h5>
                <p class="card-text">Manajemen data obat dan stok</p>
                <a href="{{ route('admin.obat.index') }}" class="btn btn-success">Kelola Obat</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Admin dashboard specific scripts -->
@endsection