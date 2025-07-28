@extends('layouts.customer')

@section('title', 'Order Detail - LSP Apotek')

@section('styles')
<style>
    .detail-card {
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .header-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 15px;
        color: white;
    }
    .order-item {
        border-bottom: 1px solid #f0f0f0;
        padding: 1.5rem 0;
    }
    .order-item:last-child {
        border-bottom: none;
    }
    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
    }
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    .status-confirmed {
        background-color: #d1ecf1;
        color: #0c5460;
    }
    .status-completed {
        background-color: #d4edda;
        color: #155724;
    }
    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }
    .info-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid #f8f9fa;
    }
    .info-item:last-child {
        border-bottom: none;
    }
    .btn-action {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-action:hover {
        transform: translateY(-2px);
    }
    .timeline {
        position: relative;
        padding-left: 2rem;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 0.5rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #dee2e6;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -1.75rem;
        top: 0.25rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #28a745;
        border: 2px solid white;
        box-shadow: 0 0 0 2px #28a745;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card header-card">
                <div class="card-body text-center py-4">
                    <h2 class="text-white mb-2">
                        <i class="ri ri-file-list-3-line me-2"></i>
                        Order Detail
                    </h2>
                    <p class="text-white mb-3">Complete information about your order</p>
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <span class="text-white">Order ID:</span>
                        <span class="badge bg-white text-primary fs-6 px-3 py-2">#{{ str_pad($penjualan->id_penjualan, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Information -->
        <div class="col-lg-8 mb-4">
            <!-- Order Status & Info -->
            <div class="card detail-card mb-4">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title mb-0">
                                <i class="ri ri-information-line me-2"></i>
                                Order Information
                            </h5>
                        </div>
                        <div class="col-auto">
                            <span class="status-badge status-{{ $penjualan->status }}">{{ ucfirst($penjualan->status) }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <strong>Order Date:</strong><br>
                                <span class="text-muted">{{ $penjualan->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="info-item">
                                <strong>Customer Name:</strong><br>
                                <span class="text-muted">{{ $penjualan->user->name }}</span>
                            </div>
                            <div class="info-item">
                                <strong>Email:</strong><br>
                                <span class="text-muted">{{ $penjualan->user->email }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <strong>Phone:</strong><br>
                                <span class="text-muted">{{ $penjualan->user->telpon ?? 'Not provided' }}</span>
                            </div>
                            <div class="info-item">
                                <strong>City:</strong><br>
                                <span class="text-muted">{{ $penjualan->user->kota ?? 'Not provided' }}</span>
                            </div>
                            <div class="info-item">
                                <strong>Address:</strong><br>
                                <span class="text-muted">{{ $penjualan->user->alamat ?? 'Not provided' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card detail-card">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="ri ri-list-check me-2"></i>
                        Order Items ({{ $penjualan->penjualanDetails->count() }} items)
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($penjualan->penjualanDetails as $detail)
                    <div class="order-item">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                @if($detail->obat->image)
                                    <img src="{{ asset('storage/' . $detail->obat->image) }}" 
                                         alt="{{ $detail->obat->name_obat }}" 
                                         class="product-image">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center product-image">
                                        <i class="ri ri-image-line text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col">
                                <h6 class="mb-1">{{ $detail->obat->name_obat }}</h6>
                                <p class="text-muted mb-1">{{ $detail->obat->type }}</p>
                                <small class="text-muted">Unit: {{ $detail->obat->unit }}</small>
                            </div>
                            <div class="col-auto text-center">
                                <div class="fw-medium">Quantity</div>
                                <div class="fs-5 text-primary">{{ $detail->quantity }}</div>
                            </div>
                            <div class="col-auto text-center">
                                <div class="fw-medium">Unit Price</div>
                                <div class="text-muted">Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</div>
                            </div>
                            <div class="col-auto text-end">
                                <div class="fw-medium">Subtotal</div>
                                <div class="fs-5 text-primary fw-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Summary & Actions -->
        <div class="col-lg-4">
            <!-- Order Summary -->
            <div class="card detail-card mb-4">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="ri ri-calculator-line me-2"></i>
                        Order Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal ({{ $penjualan->penjualanDetails->sum('quantity') }} items)</span>
                        <span>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping</span>
                        <span class="text-success">Free</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Tax</span>
                        <span>Rp 0</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total</strong>
                        <strong class="text-primary fs-5">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</strong>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('customer.orders.history') }}" class="btn btn-primary btn-action">
                            <i class="ri ri-arrow-left-line me-2"></i>
                            Back to Orders
                        </a>
                        <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary btn-action">
                            <i class="ri ri-home-line me-2"></i>
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="card detail-card">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="ri ri-time-line me-2"></i>
                        Order Timeline
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="fw-medium">Order Placed</div>
                            <small class="text-muted">{{ $penjualan->created_at->format('d M Y, H:i') }}</small>
                        </div>
                        
                        @if($penjualan->status !== 'pending')
                        <div class="timeline-item">
                            <div class="fw-medium">Order Confirmed</div>
                            <small class="text-muted">{{ $penjualan->updated_at->format('d M Y, H:i') }}</small>
                        </div>
                        @endif
                        
                        @if($penjualan->status === 'completed')
                        <div class="timeline-item">
                            <div class="fw-medium">Order Completed</div>
                            <small class="text-muted">{{ $penjualan->updated_at->format('d M Y, H:i') }}</small>
                        </div>
                        @endif
                        
                        @if($penjualan->status === 'cancelled')
                        <div class="timeline-item">
                            <div class="fw-medium text-danger">Order Cancelled</div>
                            <small class="text-muted">{{ $penjualan->updated_at->format('d M Y, H:i') }}</small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Add any JavaScript functionality here if needed
$(document).ready(function() {
    // Add smooth scrolling or other interactions
    console.log('Order detail page loaded');
});
</script>
@endsection