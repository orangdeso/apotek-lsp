@extends('layouts.app')

@section('title', 'Create Supplier')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-6" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-sm-8">
                            <h4 class="card-title text-white mb-2">
                                <i class="ri ri-add-circle-line me-2"></i>Create New Supplier
                            </h4>
                            <p class="text-white-50 mb-0">Tambah supplier baru ke dalam sistem</p>
                        </div>
                        <div class="col-sm-4 text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.suppliers.index') }}" class="btn btn-light btn-sm">
                                    <i class="ri ri-arrow-left-line me-1"></i>Back to All Suppliers
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ri ri-check-circle-line me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ri ri-error-warning-line me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ri ri-error-warning-line me-2"></i>
            <strong>Validation Errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Create Supplier Form -->
    @include('admin.suppliers.partials.create-supplier')
</div>
@endsection

@section('scripts')
<script>
    // Form validation and enhancement
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('#createSupplierForm');
        const submitBtn = document.querySelector('#submitBtn');
        
        // Phone number formatting
        const phoneInput = document.querySelector('#telpon');
        phoneInput.addEventListener('input', function(e) {
            // Remove non-numeric characters except + and -
            let value = e.target.value.replace(/[^0-9+\-]/g, '');
            e.target.value = value;
        });
        
        // Form submission handling
        form.addEventListener('submit', function(e) {
            // Disable submit button to prevent double submission
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="ri ri-loader-4-line me-1 spinner-border spinner-border-sm"></i>Creating...';
            
            // Re-enable button after 3 seconds (in case of error)
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="ri ri-save-line me-1"></i>Create Supplier';
            }, 3000);
        });
        
        // Auto-capitalize supplier name
        const nameInput = document.querySelector('#name_supplier');
        nameInput.addEventListener('input', function(e) {
            // Capitalize first letter of each word
            let value = e.target.value;
            e.target.value = value.replace(/\b\w/g, l => l.toUpperCase());
        });
        
        // Auto-capitalize city name
        const cityInput = document.querySelector('#kota');
        cityInput.addEventListener('input', function(e) {
            // Capitalize first letter of each word
            let value = e.target.value;
            e.target.value = value.replace(/\b\w/g, l => l.toUpperCase());
        });
    });
</script>
@endsection