@extends('layouts.app')

@section('title', 'Edit Address')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('customer.addresses.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="ri ri-arrow-left-line"></i>
                </a>
                <div>
                    <h4 class="mb-1">Edit Address</h4>
                    <p class="text-muted mb-0">Update your delivery address information</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Address Form -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('customer.addresses.update', $address->id) }}" method="POST" id="addressForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="label" class="form-label">Address Label <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('label') is-invalid @enderror" 
                                       id="label" name="label" value="{{ old('label', $address->label) }}" 
                                       placeholder="e.g., Home, Office, etc." required>
                                @error('label')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="recipient_name" class="form-label">Recipient Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('recipient_name') is-invalid @enderror" 
                                       id="recipient_name" name="recipient_name" value="{{ old('recipient_name', $address->recipient_name) }}" 
                                       placeholder="Full name of recipient" required>
                                @error('recipient_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $address->phone) }}" 
                                       placeholder="e.g., 08123456789" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                       id="city" name="city" value="{{ old('city', $address->city) }}" 
                                       placeholder="e.g., Jakarta" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Full Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" 
                                      placeholder="Enter complete address including street, building number, etc." required>{{ old('address', $address->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="postal_code" class="form-label">Postal Code</label>
                                <input type="text" class="form-control @error('postal_code') is-invalid @enderror" 
                                       id="postal_code" name="postal_code" value="{{ old('postal_code', $address->postal_code) }}" 
                                       placeholder="e.g., 12345">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1" 
                                           {{ old('is_default', $address->is_default) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_default">
                                        Set as default address
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('customer.addresses.index') }}" class="btn btn-outline-secondary">
                                <i class="ri ri-arrow-left-line me-2"></i>
                                Back to Addresses
                            </a>
                            <div>
                                @if($addresses->count() > 1)
                                <button type="button" class="btn btn-outline-danger me-2" onclick="deleteAddress({{ $address->id }})">
                                    <i class="ri ri-delete-bin-line me-2"></i>
                                    Delete
                                </button>
                                @endif
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="ri ri-save-line me-2"></i>
                                    Update Address
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

$(document).ready(function() {
    $('#addressForm').on('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = $('#submitBtn');
        const originalText = submitBtn.html();
        
        // Show loading state
        submitBtn.prop('disabled', true).html('<i class="ri ri-loader-4-line me-2 spinner-border spinner-border-sm"></i>Updating...');
        
        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    showMessage(response.message, 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("customer.addresses.index") }}';
                    }, 1500);
                } else {
                    showMessage(response.message || 'Failed to update address', 'error');
                    submitBtn.prop('disabled', false).html(originalText);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(field) {
                        const input = $(`[name="${field}"]`);
                        input.addClass('is-invalid');
                        input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                    });
                } else {
                    showMessage('An error occurred while updating address', 'error');
                }
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
});

function deleteAddress(addressId) {
    if (confirm('Are you sure you want to delete this address? This action cannot be undone.')) {
        $.ajax({
            url: `/customer/addresses/${addressId}`,
            method: 'DELETE',
            success: function(response) {
                if (response.success) {
                    showMessage(response.message, 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("customer.addresses.index") }}';
                    }, 1500);
                } else {
                    showMessage(response.message || 'Failed to delete address', 'error');
                }
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred while deleting address';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showMessage(errorMessage, 'error');
            }
        });
    }
}

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