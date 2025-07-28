@extends('layouts.customer')

@section('title', 'My Addresses')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Address Management</h4>
                    <p class="text-muted mb-0">Add new address and manage your delivery addresses</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Address Form Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri ri-add-line me-2"></i>
                        <span id="formTitle">Add New Address</span>
                    </h5>
                </div>
                <div class="card-body">
                    <form id="addressForm">
                        @csrf
                        <input type="hidden" id="addressId" name="address_id">
                        <input type="hidden" id="formMethod" name="_method" value="POST">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="label" class="form-label">Address Label <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="label" name="label" placeholder="e.g., Home, Office, etc." required>
                                <div class="invalid-feedback"></div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="recipient_name" class="form-label">Recipient Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="recipient_name" name="recipient_name" placeholder="Full name of recipient" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="e.g., 08123456789" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="e.g., Jakarta" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Full Address <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter complete address including street, building number, etc." required></textarea>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="postal_code" class="form-label">Postal Code</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="e.g., 12345">
                                <div class="invalid-feedback"></div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1">
                                    <label class="form-check-label" for="is_default">
                                        Set as default address
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary" id="resetFormBtn">
                                <i class="ri ri-refresh-line me-2"></i>
                                Reset Form
                            </button>
                            <button type="button" class="btn btn-primary" id="saveAddressBtn">
                                <i class="ri ri-save-line me-2"></i>
                                Save Address
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Addresses List Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri ri-map-pin-line me-2"></i>
                        My Addresses ({{ $addresses->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($addresses as $address)
                        <div class="row mb-4">
                            <div class="col-lg-8 col-md-7">
                                <div class="card h-100 {{ $address->is_default ? 'border-primary' : '' }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h6 class="card-title mb-1">
                                                    {{ $address->label }}
                                                    @if($address->is_default)
                                                        <span class="badge bg-primary ms-2">Default</span>
                                                    @endif
                                                </h6>
                                                <small class="text-muted">{{ $address->recipient_name }}</small>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="ri ri-more-2-line"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <button class="dropdown-item" onclick="editAddress({{ $address->id }})">
                                                            <i class="ri ri-edit-line me-2"></i>
                                                            Edit
                                                        </button>
                                                    </li>
                                                    @if(!$address->is_default)
                                                    <li>
                                                        <button class="dropdown-item" onclick="setAsDefault({{ $address->id }})">
                                                            <i class="ri ri-star-line me-2"></i>
                                                            Set as Default
                                                        </button>
                                                    </li>
                                                    @endif
                                                    @if($addresses->count() > 1)
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <button class="dropdown-item text-danger" onclick="deleteAddress({{ $address->id }})">
                                                            <i class="ri ri-delete-bin-line me-2"></i>
                                                            Delete
                                                        </button>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <div class="address-details">
                                            <div class="mb-2">
                                                <i class="ri ri-phone-line me-2 text-muted"></i>
                                                <span>{{ $address->phone }}</span>
                                            </div>
                                            <div class="mb-2">
                                                <i class="ri ri-map-pin-line me-2 text-muted"></i>
                                                <span>{{ $address->address }}</span>
                                            </div>
                                            <div class="mb-2">
                                                <i class="ri ri-building-line me-2 text-muted"></i>
                                                <span>{{ $address->city }}</span>
                                                @if($address->postal_code)
                                                    <span class="text-muted"> - {{ $address->postal_code }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-5">
                                 <div class="card h-100 bg-light address-actions-card">
                                    <div class="card-body d-flex flex-column justify-content-center">
                                        <div class="text-center mb-3">
                                            <i class="ri ri-map-pin-2-fill text-primary" style="font-size: 2.5rem;"></i>
                                        </div>
                                        <h6 class="text-center mb-3">Address Actions</h6>
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-outline-primary btn-sm" onclick="editAddress({{ $address->id }})">
                                                <i class="ri ri-edit-line me-2"></i>
                                                Edit Address
                                            </button>
                                            @if(!$address->is_default)
                                            <button class="btn btn-outline-warning btn-sm" onclick="setAsDefault({{ $address->id }})">
                                                <i class="ri ri-star-line me-2"></i>
                                                Set as Default
                                            </button>
                                            @else
                                            <button class="btn btn-success btn-sm" disabled>
                                                <i class="ri ri-star-fill me-2"></i>
                                                Default Address
                                            </button>
                                            @endif
                                            @if($addresses->count() > 1)
                                            <button class="btn btn-outline-danger btn-sm" onclick="deleteAddress({{ $address->id }})">
                                                <i class="ri ri-delete-bin-line me-2"></i>
                                                Delete
                                            </button>
                                            @endif
                                        </div>
                                        <div class="mt-3 text-center">
                                            <small class="text-muted">
                                                <i class="ri ri-time-line me-1"></i>
                                                Added {{ $address->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="ri ri-map-pin-line display-4 text-muted mb-3"></i>
                                    <h5 class="mb-3">No Addresses Found</h5>
                                    <p class="text-muted mb-4">You haven't added any delivery addresses yet. Use the form above to add your first address.</p>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
@media (max-width: 768px) {
    .address-actions-card {
        margin-top: 1rem;
    }
    
    .address-actions-card .card-body {
        padding: 1rem;
    }
    
    .address-actions-card h6 {
        font-size: 0.9rem;
    }
    
    .address-actions-card .btn {
        font-size: 0.8rem;
        padding: 0.375rem 0.75rem;
    }
}

@media (max-width: 576px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .address-actions-card .d-grid {
        gap: 0.5rem !important;
    }
}

.address-actions-card {
    transition: transform 0.2s ease-in-out;
}

.address-actions-card:hover {
    transform: translateY(-2px);
}

.address-details .mb-2 {
    display: flex;
    align-items: flex-start;
    word-break: break-word;
}

.address-details .mb-2 i {
    margin-top: 0.125rem;
    flex-shrink: 0;
}
</style>
@endsection

@section('scripts')
<script>
// Add CSRF token to all AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Global variables
let isEditMode = false;
let currentAddressId = null;

// Initialize form with user data
$(document).ready(function() {
    resetForm();
});

// Reset form to add mode
function resetForm() {
    isEditMode = false;
    currentAddressId = null;
    
    // Reset form
    $('#addressForm')[0].reset();
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').text('');
    
    $('#formTitle').text('Add New Address');
    $('#saveAddressBtn').html('<i class="ri ri-save-line me-2"></i>Save Address');
    $('#formMethod').val('POST');
    $('#addressId').val('');
    
    // Pre-fill with user data if available
    @auth
    $('#recipient_name').val('{{ Auth::user()->name }}');
    $('#phone').val('{{ Auth::user()->telpon ?? "" }}');
    $('#city').val('{{ Auth::user()->kota ?? "" }}');
    $('#address').val('{{ Auth::user()->alamat ?? "" }}');
    @endauth
}

// Edit address function
function editAddress(addressId) {
    isEditMode = true;
    currentAddressId = addressId;
    
    // Clear previous errors
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').text('');
    
    $('#formTitle').text('Edit Address');
    $('#saveAddressBtn').html('<i class="ri ri-save-line me-2"></i>Update Address');
    $('#formMethod').val('PUT');
    $('#addressId').val(addressId);
    
    // Load address data
    loadAddressData(addressId);
    
    // Scroll to form
    $('html, body').animate({
        scrollTop: $('#addressForm').offset().top - 100
    }, 500);
}

// Load address data for editing
function loadAddressData(addressId) {
    // Find address data from the page
    const addresses = @json($addresses);
    const address = addresses.find(addr => addr.id == addressId);
    
    if (address) {
        $('#label').val(address.label);
        $('#recipient_name').val(address.recipient_name);
        $('#phone').val(address.phone);
        $('#city').val(address.city);
        $('#address').val(address.address);
        $('#postal_code').val(address.postal_code || '');
        $('#is_default').prop('checked', address.is_default);
    }
}

// Handle reset form button
$('#resetFormBtn').on('click', function() {
    resetForm();
});

// Handle form submission
$('#saveAddressBtn').on('click', function() {
    const btn = $(this);
    const originalText = btn.html();
    
    // Show loading state
    btn.prop('disabled', true).html('<i class="ri ri-loader-4-line me-2 spinner-border spinner-border-sm"></i>Saving...');
    
    // Clear previous errors
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').text('');
    
    // Prepare form data
    const formData = $('#addressForm').serialize();
    const url = isEditMode ? `/customer/addresses/${currentAddressId}` : '{{ route("customer.addresses.store") }}';
    const method = isEditMode ? 'PUT' : 'POST';
    
    $.ajax({
        url: url,
        method: method,
        data: formData,
        success: function(response) {
            if (response.success) {
                showMessage(response.message, 'success');
                resetForm();
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showMessage(response.message || 'Failed to save address', 'error');
            }
            btn.prop('disabled', false).html(originalText);
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                // Validation errors
                const errors = xhr.responseJSON.errors;
                Object.keys(errors).forEach(function(field) {
                    const input = $(`[name="${field}"]`);
                    input.addClass('is-invalid');
                    input.siblings('.invalid-feedback').text(errors[field][0]);
                });
            } else {
                const errorMessage = xhr.responseJSON?.message || 'An error occurred while saving address';
                showMessage(errorMessage, 'error');
            }
            btn.prop('disabled', false).html(originalText);
        }
    });
});

function setAsDefault(addressId) {
    if (confirm('Set this address as your default delivery address?')) {
        $.ajax({
            url: `/customer/addresses/${addressId}/set-default`,
            method: 'POST',
            success: function(response) {
                if (response.success) {
                    showMessage(response.message, 'success');
                    location.reload();
                } else {
                    showMessage(response.message || 'Failed to set default address', 'error');
                }
            },
            error: function() {
                showMessage('An error occurred while setting default address', 'error');
            }
        });
    }
}

function deleteAddress(addressId) {
    if (confirm('Are you sure you want to delete this address? This action cannot be undone.')) {
        $.ajax({
            url: `/customer/addresses/${addressId}`,
            method: 'DELETE',
            success: function(response) {
                if (response.success) {
                    showMessage(response.message, 'success');
                    location.reload();
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