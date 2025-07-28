@extends('layouts.customer')

@section('title', 'Medicine Catalog - LSP Apotek')

@section('styles')
<style>
    .product-card {
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        transition: all 0.3s ease;
        height: 100%;
    }
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    .product-image {
        height: 200px;
        object-fit: cover;
        border-radius: 12px 12px 0 0;
    }
    .price-tag {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 15px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .stock-badge {
        padding: 3px 8px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .search-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 15px;
    }
    .filter-card {
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card search-card">
                <div class="card-body text-center py-4">
                    <h2 class="text-white mb-2">Medicine Catalog</h2>
                    <p class="text-white mb-0">Find the medicines you need from our comprehensive collection</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card filter-card">
                <div class="card-body">
                    <form action="{{ route('customer.obat.index') }}" method="GET" class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Search Medicine</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="ri ri-search-line"></i>
                                </span>
                                <input type="text" class="form-control" name="search" 
                                       placeholder="Search by medicine name or type..." 
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-medium">Medicine Type</label>
                            <select class="form-select" name="type">
                                <option value="">All Types</option>
                                @foreach($types as $type)
                                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-medium">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="ri ri-search-line me-1"></i>
                                    Search
                                </button>
                                <a href="{{ route('customer.obat.index') }}" class="btn btn-outline-secondary">
                                    <i class="ri ri-refresh-line"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Info -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    @if(request('search'))
                        Search results for "{{ request('search') }}"
                    @else
                        All Medicines
                    @endif
                    <span class="text-muted">({{ $obats->total() }} items)</span>
                </h5>
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted">Showing {{ $obats->firstItem() ?? 0 }}-{{ $obats->lastItem() ?? 0 }} of {{ $obats->total() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    @if($obats->count() > 0)
        <div class="row">
            @foreach($obats as $obat)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card product-card">
                        <!-- Product Image -->
                        <div class="position-relative">
                            @if($obat->image)
                                <img src="{{ asset('storage/' . $obat->image) }}" 
                                     alt="{{ $obat->name_obat }}" 
                                     class="card-img-top product-image">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center product-image">
                                    <i class="ri ri-image-line text-muted" style="font-size: 2.5rem;"></i>
                                </div>
                            @endif
                            
                            <!-- Stock Badge -->
                            <div class="position-absolute top-0 end-0 m-2">
                                @if($obat->stok > 0)
                                    @if($obat->isLowStock())
                                        <span class="stock-badge bg-warning text-dark">
                                            Low Stock
                                        </span>
                                    @else
                                        <span class="stock-badge bg-success text-white">
                                            In Stock
                                        </span>
                                    @endif
                                @else
                                    <span class="stock-badge bg-danger text-white">
                                        Out of Stock
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title mb-2 fw-bold">{{ $obat->name_obat }}</h6>
                            
                            <div class="mb-2">
                                <small class="text-muted">{{ ucfirst($obat->type) }} • {{ $obat->unit }}</small>
                            </div>
                            
                            @if($obat->description)
                                <p class="card-text text-muted small mb-3" style="height: 40px; overflow: hidden;">
                                    {{ Str::limit($obat->description, 80) }}
                                </p>
                            @endif
                            
                            <!-- Price -->
                            <div class="mb-3">
                                <span class="price-tag">Rp {{ number_format($obat->sale_price, 0, ',', '.') }}</span>
                            </div>
                            
                            <!-- Stock Info -->
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="ri ri-box-3-line me-1"></i>
                                    Stock: {{ $obat->stok }} {{ $obat->unit }}
                                </small>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="mt-auto d-flex gap-2">
                                <a href="{{ route('customer.obat.show', $obat->id_obat) }}" 
                                   class="btn btn-outline-primary btn-sm flex-grow-1">
                                    <i class="ri ri-eye-line me-1"></i>
                                    View Details
                                </a>
                                @if($obat->stok > 0 && !$obat->isExpired())
                                    <button class="btn btn-primary btn-sm" 
                                            onclick="quickAddToCart({{ $obat->id_obat }})">
                                        <i class="ri ri-shopping-cart-line"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $obats->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @else
        <!-- No Results -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="ri ri-search-line text-muted" style="font-size: 4rem;"></i>
                        <h5 class="mt-3 mb-2">No medicines found</h5>
                        <p class="text-muted mb-3">
                            @if(request('search'))
                                No medicines match your search criteria. Try different keywords.
                            @else
                                No medicines are currently available.
                            @endif
                        </p>
                        @if(request('search') || request('type'))
                            <a href="{{ route('customer.obat.index') }}" class="btn btn-primary">
                                <i class="ri ri-refresh-line me-1"></i>
                                Clear Filters
                            </a>
                        @endif
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
function quickAddToCart(obatId) {
    // Show loading state
    const button = event.target;
    const originalHTML = button.innerHTML;
    button.innerHTML = '<i class="ri ri-loader-4-line spinner-border spinner-border-sm"></i>';
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
            quantity: 1,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            // Reset button
            button.innerHTML = originalHTML;
            button.disabled = false;
            
            // Update cart count in navbar
            updateCartCount();
            
            // Show success message
            showToast(response.message || 'Product added to cart successfully!', 'success');
        },
        error: function(xhr) {
            // Reset button
            button.innerHTML = originalHTML;
            button.disabled = false;
            
            // Show error message
            const errorMessage = xhr.responseJSON?.message || 'Failed to add product to cart';
            showToast(errorMessage, 'danger');
        }
    });
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