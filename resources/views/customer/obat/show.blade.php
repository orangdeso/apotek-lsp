@extends('layouts.customer')

@section('title', $obat->name_obat . ' - LSP Apotek')

@section('styles')
<style>
    .product-image {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .price-tag {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
    }
    .stock-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 500;
    }
    .info-card {
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
    }
    .btn-add-cart {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-add-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.obat.index') }}">Medicines</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $obat->name_obat }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image -->
        <div class="col-lg-6 mb-4">
            <div class="card info-card">
                <div class="card-body p-4">
                    @if($obat->image)
                        <img src="{{ asset('storage/' . $obat->image) }}" 
                             alt="{{ $obat->name_obat }}" 
                             class="img-fluid product-image w-100" 
                             style="max-height: 400px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center product-image" 
                             style="height: 400px;">
                            <div class="text-center">
                                <i class="ri ri-image-line text-muted" style="font-size: 4rem;"></i>
                                <p class="text-muted mt-2 mb-0">No Image Available</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-6">
            <div class="card info-card">
                <div class="card-body p-4">
                    <!-- Product Name -->
                    <h2 class="mb-3 fw-bold text-dark">{{ $obat->name_obat }}</h2>
                    
                    <!-- Price -->
                    <div class="mb-3">
                        <span class="price-tag fs-4">Rp {{ number_format($obat->sale_price, 0, ',', '.') }}</span>
                    </div>
                    
                    <!-- Stock Status -->
                    <div class="mb-4">
                        @if($obat->stok > 0)
                            @if($obat->isLowStock())
                                <span class="stock-badge bg-warning text-dark">
                                    <i class="ri ri-error-warning-line me-1"></i>
                                    Low Stock: {{ $obat->stok }} {{ $obat->unit }} left
                                </span>
                            @else
                                <span class="stock-badge bg-success text-white">
                                    <i class="ri ri-check-line me-1"></i>
                                    In Stock: {{ $obat->stok }} {{ $obat->unit }}
                                </span>
                            @endif
                        @else
                            <span class="stock-badge bg-danger text-white">
                                <i class="ri ri-close-line me-1"></i>
                                Out of Stock
                            </span>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="row mb-4">
                        <div class="col-6">
                            <h6 class="text-muted mb-1">Type</h6>
                            <p class="mb-0 fw-medium">{{ ucfirst($obat->type) }}</p>
                        </div>
                        <div class="col-6">
                            <h6 class="text-muted mb-1">Unit</h6>
                            <p class="mb-0 fw-medium">{{ $obat->unit }}</p>
                        </div>
                    </div>

                    @if($obat->expdate)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-muted mb-1">Expiry Date</h6>
                            <p class="mb-0 fw-medium
                                @if($obat->isExpired()) text-danger
                                @elseif($obat->expdate->diffInDays(now()) <= 30) text-warning
                                @else text-success
                                @endif">
                                {{ $obat->expdate->format('d M Y') }}
                                @if($obat->isExpired())
                                    <small class="text-danger">(Expired)</small>
                                @elseif($obat->expdate->diffInDays(now()) <= 30)
                                    <small class="text-warning">(Expires soon)</small>
                                @endif
                            </p>
                        </div>
                    </div>
                    @endif

                    <!-- Supplier Info -->
                    @if($obat->supplier)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-muted mb-1">Supplier</h6>
                            <p class="mb-0 fw-medium">{{ $obat->supplier->name_supplier }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Add to Cart -->
                    @if($obat->stok > 0 && !$obat->isExpired())
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="input-group" style="max-width: 120px;">
                            <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">-</button>
                            <input type="number" class="form-control text-center" id="quantity" value="1" min="1" max="{{ $obat->stok }}">
                            <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">+</button>
                        </div>
                        <button class="btn btn-primary btn-add-cart flex-grow-1" onclick="addToCart({{ $obat->id_obat }})">
                            <i class="ri ri-shopping-cart-line me-2"></i>
                            Add to Cart
                        </button>
                    </div>
                    @else
                    <div class="alert alert-warning" role="alert">
                        <i class="ri ri-information-line me-2"></i>
                        This product is currently unavailable.
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('customer.obat.index') }}" class="btn btn-outline-secondary">
                            <i class="ri ri-arrow-left-line me-1"></i>
                            Back to Catalog
                        </a>
                        <button class="btn btn-outline-primary" onclick="shareProduct()">
                            <i class="ri ri-share-line me-1"></i>
                            Share
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Description -->
    @if($obat->description)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card info-card">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3">
                        <i class="ri ri-file-text-line me-2"></i>
                        Product Description
                    </h5>
                    <p class="text-muted mb-0">{{ $obat->description }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
// Load cart count when page loads
$(document).ready(function() {
    @auth
        updateCartCount();
    @endauth
});
function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const maxValue = parseInt(quantityInput.max);
    
    if (currentValue < maxValue) {
        quantityInput.value = currentValue + 1;
    }
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const minValue = parseInt(quantityInput.min);
    
    if (currentValue > minValue) {
        quantityInput.value = currentValue - 1;
    }
}

function addToCart(obatId) {
    const quantity = document.getElementById('quantity').value;
    
    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="ri ri-loader-4-line me-2 spinner-border spinner-border-sm"></i>Adding...';
    button.disabled = true;
    
    // Setup CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Send AJAX request
    $.ajax({
        url: '{{ route("customer.cart.add", ":id") }}'.replace(':id', obatId),
        method: 'POST',
        data: {
            quantity: quantity,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            // Reset button
            button.innerHTML = originalText;
            button.disabled = false;
            
            // Update cart count in navbar
            updateCartCount();
            
            // Show success message
            showToast(response.message || 'Product added to cart successfully!', 'success');
        },
        error: function(xhr) {
            // Reset button
            button.innerHTML = originalText;
            button.disabled = false;
            
            // Show error message
            const errorMessage = xhr.responseJSON?.message || 'Failed to add product to cart';
            showToast(errorMessage, 'danger');
        }
    });
}

function shareProduct() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $obat->name_obat }}',
            text: 'Check out this medicine at LSP Apotek',
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            showToast('Product link copied to clipboard!', 'info');
        });
    }
}

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

function showToast(message, type = 'success') {
    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'position-fixed end-0 p-3';
        toastContainer.style.top = '80px'; // Position below header
        toastContainer.style.zIndex = '1055';
        document.body.appendChild(toastContainer);
    }
    
    // Create toast element
    const toastId = 'toast-' + Date.now();
    const toastHtml = `
        <div id="${toastId}" class="toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'danger' ? 'danger' : 'warning'} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    
    // Initialize and show toast
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, {
        autohide: true,
        delay: 3000
    });
    
    toast.show();
    
    // Remove toast element after it's hidden
    toastElement.addEventListener('hidden.bs.toast', function() {
        toastElement.remove();
    });
}
</script>
@endsection