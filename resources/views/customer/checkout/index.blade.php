@extends('layouts.customer')

@section('title', 'Checkout - LSP Apotek')

@section('styles')
<style>
    .checkout-card {
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        transition: all 0.3s ease;
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
    .summary-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 15px;
        color: white;
    }
    .btn-place-order {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        border-radius: 8px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-place-order:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
    }
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
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
                        <i class="ri ri-secure-payment-line me-2"></i>
                        Checkout
                    </h2>
                    <p class="text-white mb-0">Complete your order and provide delivery information</p>
                </div>
            </div>
        </div>
    </div>

    <form id="checkout-form">
        @csrf
        <div class="row">
            <!-- Order Summary -->
            <div class="col-lg-8 mb-4">
                <!-- Delivery Address -->
                <div class="card checkout-card mb-4">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="ri ri-map-pin-line me-2"></i>
                            Delivery Address
                        </h5>
                        <a href="{{ route('customer.addresses.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="ri ri-add-line me-1"></i>
                            Add New Address
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="address_id" class="form-label">Select Delivery Address *</label>
                            <select class="form-select" id="address_id" name="address_id" required>
                                <option value="">Choose delivery address...</option>
                                @foreach(Auth::user()->addresses()->orderBy('is_default', 'desc')->get() as $address)
                                    <option value="{{ $address->id }}" 
                                            {{ $address->is_default ? 'selected' : '' }}
                                            data-recipient="{{ $address->recipient_name }}"
                                            data-phone="{{ $address->phone }}"
                                            data-address="{{ $address->address }}"
                                            data-city="{{ $address->city }}"
                                            data-postal="{{ $address->postal_code }}">
                                        {{ $address->label }} - {{ $address->recipient_name }} ({{ $address->phone }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Address Preview -->
                        <div id="address-preview" class="border rounded p-3 bg-light" style="display: none;">
                            <h6 class="mb-2">Delivery Details:</h6>
                            <div id="preview-recipient"></div>
                            <div id="preview-phone"></div>
                            <div id="preview-address"></div>
                            <div id="preview-city"></div>
                        </div>
                        
                        <div class="mt-3">
                            <label for="notes" class="form-label">Order Notes (Optional)</label>
                            <textarea class="form-control" id="notes" name="notes" 
                                      rows="2" placeholder="Any special instructions for your order"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card checkout-card">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title mb-0">
                            <i class="ri ri-list-check me-2"></i>
                            Order Items ({{ $totalItems }} items)
                        </h5>
                    </div>
                    <div class="card-body">
                        @foreach($cartItems as $item)
                        <div class="order-item">
                            <div class="row align-items-center">
                                <div class="col-auto">
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
                                <div class="col">
                                    <h6 class="mb-1">{{ $item->obat->name_obat }}</h6>
                                    <small class="text-muted">{{ $item->obat->type }}</small>
                                </div>
                                <div class="col-auto text-end">
                                    <div class="fw-medium">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                    <div class="text-primary fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="col-lg-4">
                <div class="card checkout-card">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title mb-0">
                            <i class="ri ri-calculator-line me-2"></i>
                            Payment Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal ({{ $totalItems }} items)</span>
                            <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
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
                            <strong class="text-primary">Rp {{ number_format($totalPrice, 0, ',', '.') }}</strong>
                        </div>
                        
                        <!-- Payment Method -->
                        <div class="mb-4">
                            <label class="form-label fw-medium">Payment Method *</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                <label class="form-check-label" for="cod">
                                    <i class="ri ri-hand-coin-line me-2"></i>
                                    Cash on Delivery (COD)
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="transfer" value="transfer">
                                <label class="form-check-label" for="transfer">
                                    <i class="ri ri-bank-line me-2"></i>
                                    Bank Transfer
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-place-order text-white">
                                <i class="ri ri-secure-payment-line me-2"></i>
                                Place Order
                            </button>
                            <a href="{{ route('customer.cart.view') }}" class="btn btn-outline-secondary">
                                <i class="ri ri-arrow-left-line me-1"></i>
                                Back to Cart
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Security Info -->
                <div class="card checkout-card mt-3">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="ri ri-shield-check-line me-2 text-success"></i>
                            Secure Checkout
                        </h6>
                        <ul class="list-unstyled mb-0 small">
                            <li class="mb-2">
                                <i class="ri ri-check-line text-success me-2"></i>
                                SSL encrypted transaction
                            </li>
                            <li class="mb-2">
                                <i class="ri ri-check-line text-success me-2"></i>
                                Secure payment processing
                            </li>
                            <li>
                                <i class="ri ri-check-line text-success me-2"></i>
                                Your data is protected
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
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

// Handle address selection
$('#address_id').on('change', function() {
    const selectedOption = $(this).find('option:selected');
    const addressPreview = $('#address-preview');
    
    if (selectedOption.val()) {
        const recipient = selectedOption.data('recipient');
        const phone = selectedOption.data('phone');
        const address = selectedOption.data('address');
        const city = selectedOption.data('city');
        const postal = selectedOption.data('postal');
        
        $('#preview-recipient').html('<strong>' + recipient + '</strong>');
        $('#preview-phone').html('<i class="ri ri-phone-line me-2"></i>' + phone);
        $('#preview-address').html('<i class="ri ri-map-pin-line me-2"></i>' + address);
        $('#preview-city').html('<i class="ri ri-building-line me-2"></i>' + city + (postal ? ' - ' + postal : ''));
        
        addressPreview.show();
    } else {
        addressPreview.hide();
    }
});

// Trigger address preview on page load if default address is selected
$(document).ready(function() {
    if ($('#address_id').val()) {
        $('#address_id').trigger('change');
    }
});

$('#checkout-form').on('submit', function(e) {
    e.preventDefault();
    
    // Get form data
    const formData = {
        address_id: $('#address_id').val(),
        notes: $('#notes').val(),
        payment_method: $('input[name="payment_method"]:checked').val()
    };
    
    // Validate required fields
    if (!formData.address_id) {
        showMessage('Please select a delivery address', 'error');
        return;
    }
    
    if (!formData.payment_method) {
        showMessage('Please select a payment method', 'error');
        return;
    }
    
    // Show loading state
    const submitBtn = $('button[type="submit"]');
    const originalText = submitBtn.html();
    submitBtn.html('<i class="ri ri-loader-4-line me-2 spinner-border spinner-border-sm"></i>Processing...');
    submitBtn.prop('disabled', true);
    
    // Process checkout
    $.ajax({
        url: '{{ route("customer.checkout.process") }}',
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.success) {
                showMessage('Order placed successfully! Redirecting to confirmation page...', 'success');
                
                // Redirect to order confirmation
                setTimeout(() => {
                    window.location.href = '{{ url("/customer/order/confirmation") }}/' + response.order_id;
                }, 1500);
            } else {
                showMessage(response.message || 'Failed to place order', 'error');
                submitBtn.html(originalText);
                submitBtn.prop('disabled', false);
            }
        },
        error: function(xhr) {
            let errorMessage = 'An error occurred while processing your order';
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = xhr.responseJSON.errors;
                errorMessage = Object.values(errors).flat().join(', ');
            }
            
            showMessage(errorMessage, 'error');
            submitBtn.html(originalText);
            submitBtn.prop('disabled', false);
        }
    });
});

function showMessage(message, type) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'error' ? 'danger' : 'success'} position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        <i class="ri ri-${type === 'error' ? 'error-warning' : 'check'}-line me-2"></i>
        ${message}
        <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, 5000);
}
</script>
@endsection