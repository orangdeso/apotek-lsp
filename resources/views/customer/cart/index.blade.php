@extends('layouts.customer')

@section('title', 'Shopping Cart - LSP Apotek')

@section('styles')
<style>
    .cart-card {
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .cart-item {
        border-bottom: 1px solid #f0f0f0;
        padding: 1.5rem 0;
    }
    .cart-item:last-child {
        border-bottom: none;
    }
    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }
    .quantity-input {
        width: 80px;
        text-align: center;
    }
    .btn-quantity {
        width: 30px;
        height: 30px;
        padding: 0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .summary-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 15px;
        color: white;
    }
    .empty-cart {
        text-align: center;
        padding: 3rem 0;
    }
    .btn-checkout {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        border-radius: 8px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card summary-card">
                <div class="card-body text-center py-4">
                    <h2 class="text-white mb-2">
                        <i class="ri ri-shopping-cart-line me-2"></i>
                        Shopping Cart
                    </h2>
                    <p class="text-white mb-0">Review your selected medicines before checkout</p>
                </div>
            </div>
        </div>
    </div>

    @if($cartItems->count() > 0)
    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8 mb-4">
            <div class="card cart-card">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="ri ri-list-check me-2"></i>
                        Cart Items ({{ $totalItems }} items)
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($cartItems as $item)
                    <div class="cart-item" data-cart-id="{{ $item->id_cart }}">
                        <div class="row align-items-center">
                            <!-- Product Image -->
                            <div class="col-md-2 col-3">
                                @if($item->obat->image)
                                    <img src="{{ asset('storage/' . $item->obat->image) }}" 
                                         alt="{{ $item->obat->name_obat }}" 
                                         class="product-image">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center product-image">
                                        <i class="ri ri-image-line text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Info -->
                            <div class="col-md-4 col-9">
                                <h6 class="mb-1">{{ $item->obat->name_obat }}</h6>
                                <small class="text-muted">{{ $item->obat->type }}</small>
                                <br>
                                <small class="text-success">Stock: {{ $item->obat->stok }}</small>
                            </div>
                            
                            <!-- Price -->
                            <div class="col-md-2 col-6">
                                <div class="text-center">
                                    <small class="text-muted d-block">Price</small>
                                    <span class="fw-bold text-primary">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            
                            <!-- Quantity -->
                            <div class="col-md-2 col-6">
                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="button" class="btn btn-outline-secondary btn-quantity minus-btn" 
                                            onclick="decreaseQuantity({{ $item->id_cart }})" 
                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                        <i class="ri ri-subtract-line"></i>
                                    </button>
                                    <input type="number" class="form-control quantity-input mx-2" 
                                           value="{{ $item->quantity }}" 
                                           min="1" max="{{ $item->obat->stok }}"
                                           onchange="updateQuantity({{ $item->id_cart }}, parseInt(this.value))">
                                    <button type="button" class="btn btn-outline-secondary btn-quantity plus-btn" 
                                            onclick="increaseQuantity({{ $item->id_cart }})" 
                                            {{ $item->quantity >= $item->obat->stok ? 'disabled' : '' }}>
                                        <i class="ri ri-add-line"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Subtotal & Actions -->
                            <div class="col-md-2 col-12">
                                <div class="text-center">
                                    <div class="fw-bold text-success mb-2" id="subtotal-{{ $item->id_cart }}">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div>
                                    <button type="button" class="btn btn-outline-danger btn-sm" 
                                            onclick="removeFromCart({{ $item->id_cart }})">
                                        <i class="ri ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <!-- Clear Cart Button -->
                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-outline-danger" onclick="clearCart()">
                            <i class="ri ri-delete-bin-line me-1"></i>
                            Clear Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card cart-card">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="ri ri-calculator-line me-2"></i>
                        Order Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal ({{ $totalItems }} items)</span>
                        <span id="cart-subtotal">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping</span>
                        <span class="text-success">Free</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total</strong>
                        <strong class="text-primary" id="cart-total">Rp {{ number_format($totalPrice, 0, ',', '.') }}</strong>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-checkout text-white" onclick="proceedToCheckout()">
                            <i class="ri ri-secure-payment-line me-2"></i>
                            Proceed to Checkout
                        </button>
                        <a href="{{ route('customer.obat.index') }}" class="btn btn-outline-primary">
                            <i class="ri ri-arrow-left-line me-1"></i>
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Shipping Info -->
            <div class="card cart-card mt-3">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="ri ri-truck-line me-2"></i>
                        Shipping Information
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="ri ri-check-line text-success me-2"></i>
                            Free shipping for all orders
                        </li>
                        <li class="mb-2">
                            <i class="ri ri-time-line text-info me-2"></i>
                            Delivery within 1-3 business days
                        </li>
                        <li>
                            <i class="ri ri-shield-check-line text-warning me-2"></i>
                            Secure packaging guaranteed
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Empty Cart -->
    <div class="row">
        <div class="col-12">
            <div class="card cart-card">
                <div class="card-body empty-cart">
                    <i class="ri ri-shopping-cart-line text-muted" style="font-size: 4rem;"></i>
                    <h4 class="text-muted mt-3">Your cart is empty</h4>
                    <p class="text-muted mb-4">Looks like you haven't added any medicines to your cart yet.</p>
                    <a href="{{ route('customer.obat.index') }}" class="btn btn-primary">
                        <i class="ri ri-shopping-bag-line me-2"></i>
                        Start Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
// Add CSRF token to all AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Load cart count when page loads
$(document).ready(function() {
    updateCartCount();
});

function increaseQuantity(cartId) {
    const cartItem = $(`.cart-item[data-cart-id="${cartId}"]`);
    const quantityInput = cartItem.find('.quantity-input');
    const currentQuantity = parseInt(quantityInput.val());
    const maxStock = parseInt(quantityInput.attr('max'));
    
    if (currentQuantity < maxStock) {
        updateQuantity(cartId, currentQuantity + 1);
    }
}

function decreaseQuantity(cartId) {
    const cartItem = $(`.cart-item[data-cart-id="${cartId}"]`);
    const quantityInput = cartItem.find('.quantity-input');
    const currentQuantity = parseInt(quantityInput.val());
    
    if (currentQuantity > 1) {
        updateQuantity(cartId, currentQuantity - 1);
    }
}

function updateQuantity(cartId, quantity) {
    // Validate quantity
    quantity = parseInt(quantity);
    if (isNaN(quantity) || quantity < 1) {
        // Reset to current value if invalid
        const cartItem = $(`.cart-item[data-cart-id="${cartId}"]`);
        const currentQuantity = parseInt(cartItem.find('.quantity-input').val());
        cartItem.find('.quantity-input').val(currentQuantity);
        return;
    }
    
    // Check stock limit
    const cartItem = $(`.cart-item[data-cart-id="${cartId}"]`);
    const maxStock = parseInt(cartItem.find('.quantity-input').attr('max'));
    if (quantity > maxStock) {
        showToast(`Maximum quantity available is ${maxStock}`, 'error');
        cartItem.find('.quantity-input').val(maxStock);
        quantity = maxStock;
    }
    
    $.ajax({
        url: `/customer/cart/update/${cartId}`,
        method: 'PUT',
        data: {
            quantity: quantity
        },
        success: function(response) {
            if (response.success) {
                // Update the quantity input field
                cartItem.find('.quantity-input').val(quantity);
                
                // Update subtotal for this item
                $(`#subtotal-${cartId}`).text(`Rp ${new Intl.NumberFormat('id-ID').format(response.subtotal)}`);
                
                // Update cart totals
                $('#cart-subtotal').text(`Rp ${new Intl.NumberFormat('id-ID').format(response.total_price)}`);
                $('#cart-total').text(`Rp ${new Intl.NumberFormat('id-ID').format(response.total_price)}`);
                
                // Update cart count in navbar
                updateCartCount();
                
                // Update button states
                updateButtonStates(cartId, quantity, maxStock);
                
                // Show success message
                showToast(response.message, 'success');
            } else {
                showToast(response.message, 'error');
                // Reset to previous value
                location.reload();
            }
        },
        error: function() {
            showToast('An error occurred while updating cart', 'error');
            // Reset to previous value
            location.reload();
        }
    });
}

function updateButtonStates(cartId, quantity, maxStock) {
    const cartItem = $(`.cart-item[data-cart-id="${cartId}"]`);
    
    // Update minus button state
    const minusBtn = cartItem.find('.minus-btn');
    minusBtn.prop('disabled', quantity <= 1);
    
    // Update plus button state
    const plusBtn = cartItem.find('.plus-btn');
    plusBtn.prop('disabled', quantity >= maxStock);
}

function removeFromCart(cartId) {
    if (!confirm('Are you sure you want to remove this item from cart?')) {
        return;
    }
    
    $.ajax({
        url: `/customer/cart/remove/${cartId}`,
        method: 'DELETE',
        success: function(response) {
            if (response.success) {
                // Remove item from DOM
                $(`[data-cart-id="${cartId}"]`).fadeOut(300, function() {
                    $(this).remove();
                    
                    // Check if cart is empty
                    if ($('.cart-item').length === 0) {
                        location.reload();
                    }
                });
                
                // Update cart totals
                $('#cart-subtotal').text(`Rp ${new Intl.NumberFormat('id-ID').format(response.total_price)}`);
                $('#cart-total').text(`Rp ${new Intl.NumberFormat('id-ID').format(response.total_price)}`);
                
                // Update cart count in navbar
                updateCartCount();
                
                showToast(response.message, 'success');
            } else {
                showToast(response.message, 'error');
            }
        },
        error: function() {
            showToast('An error occurred while removing item', 'error');
        }
    });
}

function clearCart() {
    if (!confirm('Are you sure you want to clear your entire cart?')) {
        return;
    }
    
    $.ajax({
        url: '/customer/cart/clear',
        method: 'DELETE',
        success: function(response) {
            if (response.success) {
                // Update cart count to 0
                updateCartCount();
                location.reload();
            } else {
                showToast(response.message, 'error');
            }
        },
        error: function() {
            showToast('An error occurred while clearing cart', 'error');
        }
    });
}

function proceedToCheckout() {
    // Redirect to checkout page
    window.location.href = '{{ route("customer.checkout") }}';
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
        toastContainer.style.cssText = `
            position: fixed;
            top: 160px;
            right: 20px;
            z-index: 9999;
            max-width: 350px;
        `;
        document.body.appendChild(toastContainer);
    }

    // Create toast element
    const toast = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
    
    toast.className = `toast align-items-center text-white ${bgColor} border-0 mb-2`;
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="ri ${type === 'success' ? 'ri-check-line' : type === 'error' ? 'ri-close-line' : 'ri-information-line'} me-2"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    
    // Initialize and show toast
    const bsToast = new bootstrap.Toast(toast, {
        autohide: true,
        delay: 3000
    });
    
    bsToast.show();
    
    // Remove toast element after it's hidden
    toast.addEventListener('hidden.bs.toast', function() {
        toast.remove();
    });
}
</script>
@endsection