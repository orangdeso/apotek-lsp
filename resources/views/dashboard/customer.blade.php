@extends('layouts.customer')

@section('title', 'LSP Apotek - Online Pharmacy')

@section('content')
<!-- Welcome Section -->
<div class="row mb-6">
    <div class="col-12">
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-center py-5">
                <h2 class="text-white mb-3">Welcome to LSP Apotek</h2>
                <p class="text-white mb-0 fs-5">Your trusted online pharmacy for quality medicines and healthcare products</p>
            </div>
        </div>
    </div>
</div>

<!-- Advanced Search Filter -->
<div class="row mb-6">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Find Your Medicine</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('customer.obat.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Medicine Name</label>
                            <input type="text" class="form-control" name="search" placeholder="Search medicine name..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category">
                                <option value="">All Categories</option>
                                <option value="prescription" {{ request('category') == 'prescription' ? 'selected' : '' }}>Prescription</option>
                                <option value="otc" {{ request('category') == 'otc' ? 'selected' : '' }}>Over-the-Counter</option>
                                <option value="supplement" {{ request('category') == 'supplement' ? 'selected' : '' }}>Supplements</option>
                                <option value="herbal" {{ request('category') == 'herbal' ? 'selected' : '' }}>Herbal</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Price Range</label>
                            <select class="form-select" name="price_range">
                                <option value="">All Prices</option>
                                <option value="0-50000" {{ request('price_range') == '0-50000' ? 'selected' : '' }}>Under Rp 50,000</option>
                                <option value="50000-100000" {{ request('price_range') == '50000-100000' ? 'selected' : '' }}>Rp 50,000 - 100,000</option>
                                <option value="100000-200000" {{ request('price_range') == '100000-200000' ? 'selected' : '' }}>Rp 100,000 - 200,000</option>
                                <option value="200000+" {{ request('price_range') == '200000+' ? 'selected' : '' }}>Above Rp 200,000</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri ri-search-line me-1"></i>Search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Medicine Catalog -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Medicine Catalog</h5>
                <a href="{{ route('customer.obat.index') }}" class="btn btn-outline-primary btn-sm">View All Products</a>
            </div>
            <div class="card-body">
                @if(isset($obatTerbaru) && $obatTerbaru->count() > 0)
                    <div class="row">
                        @foreach($obatTerbaru as $obat)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100 product-card">
                                <div class="card-img-top position-relative">
                                    @if($obat->image)
                                        <img src="{{ asset('storage/' . $obat->image) }}" class="img-fluid" alt="{{ $obat->name_obat }}" style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="bx bx-capsule text-muted" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                    @if($obat->stok < 10)
                                        <span class="badge bg-warning position-absolute top-0 end-0 m-2">Low Stock</span>
                                    @endif
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title">{{ $obat->name_obat }}</h6>
                                    <p class="text-muted small mb-2">{{ Str::limit($obat->description, 60) }}</p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-primary fw-bold">Rp {{ number_format($obat->sale_price, 0, ',', '.') }}</span>
                                            <small class="text-muted">Stock: {{ $obat->stok }}</small>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('customer.obat.show', $obat->id_obat) }}" class="btn btn-outline-primary btn-sm">View Details</a>
                                            @if($obat->stok > 0)
                                                <button type="button" class="btn btn-primary btn-sm" onclick="addToCart({{ $obat->id_obat }})">
                                                    <i class="bx bx-cart-add me-1"></i>Add to Cart
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                    Out of Stock
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bx bx-package text-muted" style="font-size: 4rem;"></i>
                        <h5 class="text-muted mt-3">No products available</h5>
                        <p class="text-muted">Please check back later for new products.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.product-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.card-img-top img {
    transition: transform 0.3s ease;
}

.product-card:hover .card-img-top img {
    transform: scale(1.05);
}
</style>
@endsection

@section('scripts')
<script>
// Load cart count when page loads
$(document).ready(function() {
    @auth
        updateCartCount();
    @endauth
});
function addToCart(obatId) {
    @auth
        // Disable button and show loading state
        const button = event.target;
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i>Adding...';
        
        $.ajax({
            url: '{{ route("customer.cart.add", ":id") }}'.replace(':id', obatId),
            method: 'POST',
            data: {
                quantity: 1,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Show success toast
                    showToast('success', 'Product added to cart successfully!');
                    
                    // Update cart count
                    updateCartCount();
                } else {
                    showToast('error', response.message || 'Failed to add product to cart.');
                }
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred while adding to cart.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showToast('error', errorMessage);
            },
            complete: function() {
                // Re-enable button
                button.disabled = false;
                button.innerHTML = originalText;
            }
        });
    @else
        showToast('warning', 'Please sign in to add products to cart.');
        setTimeout(() => {
            window.location.href = '{{ route("login") }}';
        }, 1500);
    @endauth
}

function showToast(type, message) {
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
        <div id="${toastId}" class="toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'warning'} border-0" role="alert" aria-live="assertive" aria-atomic="true">
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

function updateCartCount() {
    $.ajax({
        url: '{{ route("customer.cart.count") }}',
        method: 'GET',
        success: function(response) {
            if (response.success) {
                // Update cart badge in navbar
                const cartBadge = document.querySelector('#cart-count');
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