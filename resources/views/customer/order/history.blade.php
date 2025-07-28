@extends('layouts.customer')

@section('title', 'Order History - LSP Apotek')

@section('styles')
<style>
    .history-card {
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .history-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    }
    .header-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 6px;
    }
    .status-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 15px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.7rem;
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
    .btn-view {
        border-radius: 6px;
        padding: 0.4rem 1rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }
    .empty-state {
        text-align: center;
        padding: 3rem 0;
    }
    .empty-state i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1rem;
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
                        <i class="ri ri-history-line me-2"></i>
                        Order History
                    </h2>
                    <p class="text-white mb-0">Track and manage your previous orders</p>
                </div>
            </div>
        </div>
    </div>

    @if($orders->count() > 0)
        <div class="row">
            @foreach($orders as $order)
            <div class="col-12 mb-4">
                <div class="card history-card">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-1">
                                    <i class="ri ri-shopping-bag-line me-2"></i>
                                    Order #{{ str_pad($order->id_penjualan, 6, '0', STR_PAD_LEFT) }}
                                </h6>
                                <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                            </div>
                            <div class="col-auto">
                                <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Order Items Preview -->
                            <div class="col-lg-8">
                                <h6 class="mb-3">Items ({{ $order->penjualanDetails->count() }} items)</h6>
                                @foreach($order->penjualanDetails->take(3) as $detail)
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
                                            <h6 class="mb-1 fs-6">{{ $detail->obat->name_obat }}</h6>
                                            <small class="text-muted">{{ $detail->obat->type }}</small>
                                        </div>
                                        <div class="col-auto text-end">
                                            <div class="small">{{ $detail->quantity }} x Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</div>
                                            <div class="text-primary fw-medium">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                
                                @if($order->penjualanDetails->count() > 3)
                                <div class="text-center mt-2">
                                    <small class="text-muted">and {{ $order->penjualanDetails->count() - 3 }} more items...</small>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Order Summary -->
                            <div class="col-lg-4">
                                <div class="bg-light rounded p-3">
                                    <h6 class="mb-3">Order Summary</h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="small">Total Items:</span>
                                        <span class="small fw-medium">{{ $order->penjualanDetails->sum('quantity') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="small">Shipping:</span>
                                        <span class="small text-success">Free</span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between mb-3">
                                        <strong>Total:</strong>
                                        <strong class="text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                                    </div>
                                    
                                    <div class="d-grid">
                                        <a href="{{ route('customer.order.detail', $order->id_penjualan) }}" 
                                           class="btn btn-outline-primary btn-view">
                                            <i class="ri ri-eye-line me-1"></i>
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="card history-card">
                    <div class="card-body">
                        <div class="empty-state">
                            <i class="ri ri-shopping-bag-line"></i>
                            <h4 class="text-muted mb-3">No Orders Yet</h4>
                            <p class="text-muted mb-4">You haven't placed any orders yet. Start shopping to see your order history here.</p>
                            <a href="{{ route('customer.obat.index') }}" class="btn btn-primary">
                                <i class="ri ri-shopping-cart-line me-2"></i>
                                Start Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
// Add any JavaScript functionality here if needed
$(document).ready(function() {
    // Add hover effects or other interactions
    $('.history-card').hover(
        function() {
            $(this).addClass('shadow-lg');
        },
        function() {
            $(this).removeClass('shadow-lg');
        }
    );
});
</script>
@endsection