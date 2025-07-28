@extends('layouts.customer')

@section('title', 'Order Confirmation - LSP Apotek')

@section('styles')
<style>
    .confirmation-card {
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .success-header {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        border-radius: 15px;
        color: white;
    }
    .order-item {
        border-bottom: 1px solid #f0f0f0;
        padding: 1rem 0;
    }
    .order-item:last-child {
        border-bottom: none;
    }
    .product-image {
        width: 60px;
        height: 60px;
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
    .btn-action {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-action:hover {
        transform: translateY(-2px);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Success Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card success-header">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <i class="ri ri-check-double-line" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="text-white mb-2">Order Placed Successfully!</h2>
                    <p class="text-white mb-3">Thank you for your order. We'll process it shortly.</p>
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <span class="text-white">Order ID:</span>
                        <span class="badge bg-white text-success fs-6 px-3 py-2">#{{ str_pad($penjualan->id_penjualan, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Details -->
        <div class="col-lg-8 mb-4">
            <!-- Order Information -->
            <div class="card confirmation-card mb-4">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="ri ri-information-line me-2"></i>
                        Order Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Order Date:</strong><br>
                            <span class="text-muted">{{ $penjualan->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Status:</strong><br>
                            <span class="status-badge status-{{ $penjualan->status }}">{{ ucfirst($penjualan->status) }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Customer:</strong><br>
                            <span class="text-muted">{{ $penjualan->user->name }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Email:</strong><br>
                            <span class="text-muted">{{ $penjualan->user->email }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card confirmation-card">
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
                                <small class="text-muted">{{ $detail->obat->type }}</small>
                            </div>
                            <div class="col-auto text-end">
                                <div class="fw-medium">{{ $detail->quantity }} x Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</div>
                                <div class="text-primary fw-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card confirmation-card">
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
                        <strong class="text-primary">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</strong>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('customer.orders.history') }}" class="btn btn-primary btn-action">
                            <i class="ri ri-history-line me-2"></i>
                            View Order History
                        </a>
                        <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary btn-action">
                            <i class="ri ri-home-line me-2"></i>
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="card confirmation-card mt-3">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="ri ri-information-line me-2 text-info"></i>
                        What's Next?
                    </h6>
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2">
                            <i class="ri ri-check-line text-success me-2"></i>
                            We'll process your order within 24 hours
                        </li>
                        <li class="mb-2">
                            <i class="ri ri-check-line text-success me-2"></i>
                            You'll receive an email confirmation
                        </li>
                        <li class="mb-2">
                            <i class="ri ri-check-line text-success me-2"></i>
                            Track your order in Order History
                        </li>
                        <li>
                            <i class="ri ri-check-line text-success me-2"></i>
                            Contact us if you have any questions
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Auto-refresh cart count since cart was cleared
$(document).ready(function() {
    updateCartCount();
});

function updateCartCount() {
    $.ajax({
        url: '{{ route("customer.cart.count") }}',
        method: 'GET',
        success: function(response) {
            if (response.success) {
                const cartBadge = document.getElementById('cart-count');
                if (cartBadge) {
                    cartBadge.textContent = response.count;
                    if (response.count > 0) {
                        cartBadge.style.display = 'inline';
                    } else {
                        cartBadge.style.display = 'none';
                    }
                }
            }
        },
        error: function(xhr) {
            console.error('Failed to update cart count:', xhr);
        }
    });
}
</script>
@endsection