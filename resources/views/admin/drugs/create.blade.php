@extends('layouts.app')

@section('title', 'Create Drug')

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
                                <i class="ri ri-add-circle-line me-2"></i>Create New Drug
                            </h4>
                            <p class="text-white-50 mb-0">Tambah obat baru ke dalam sistem inventory</p>
                        </div>
                        <div class="col-sm-4 text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.drugs.index') }}" class="btn btn-light btn-sm">
                                    <i class="ri ri-arrow-left-line me-1"></i>Back to All Drugs
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
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Create Drug Form -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    @include('admin.drugs.partials.create-drug')
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-modern .form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

.form-modern .form-control,
.form-modern .form-select {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    background-color: #fff;
}

.form-modern .form-control:focus,
.form-modern .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    background-color: #fff;
}

.form-modern .form-control.is-invalid {
    border-color: #dc3545;
}

.form-modern .invalid-feedback {
    display: block;
    font-size: 0.875rem;
    color: #dc3545;
    margin-top: 0.25rem;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

.bg-gradient-success {
    background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%) !important;
}

.bg-gradient-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;
}

.image-preview {
    width: 150px;
    height: 150px;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
}

.image-preview:hover {
    border-color: #667eea;
    background-color: #f0f2ff;
}

.image-preview img {
    max-width: 100%;
    max-height: 100%;
    border-radius: 6px;
}

.price-calculator {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 8px;
    padding: 1rem;
    margin-top: 1rem;
}

.margin-display {
    font-size: 1.25rem;
    font-weight: 700;
    color: #28a745;
}

.btn-modern {
    border-radius: 8px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-primary-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
}

.btn-secondary-modern {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    border: none;
    color: white;
}

.card-header {
    border-bottom: 1px solid #e9ecef;
}

.supplier-select {
    position: relative;
}

.supplier-info {
    background: #f8f9fa;
    border-radius: 6px;
    padding: 0.75rem;
    margin-top: 0.5rem;
    border-left: 4px solid #667eea;
}
</style>
@endsection

@section('scripts')
<script>
// Image preview functionality
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        }
        reader.readAsDataURL(file);
    }
}

// Price calculator
function calculateMargin() {
    const purchasePrice = parseFloat(document.getElementById('purchase_price').value) || 0;
    const salePrice = parseFloat(document.getElementById('sale_price').value) || 0;
    
    if (purchasePrice > 0 && salePrice > 0) {
        const margin = ((salePrice - purchasePrice) / purchasePrice * 100).toFixed(2);
        const profit = (salePrice - purchasePrice).toFixed(0);
        
        document.getElementById('marginDisplay').innerHTML = `
            <div class="d-flex justify-content-between">
                <span>Margin: <strong>${margin}%</strong></span>
                <span>Profit: <strong>Rp ${formatPriceDisplay(profit)}</strong></span>
            </div>
        `;
    } else {
        document.getElementById('marginDisplay').innerHTML = '<span class="text-muted">Masukkan harga untuk melihat margin</span>';
    }
}

// Supplier selection handler
document.getElementById('id_supplier').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const supplierInfo = document.getElementById('supplierInfo');
    
    if (this.value) {
        const supplierData = selectedOption.dataset;
        supplierInfo.innerHTML = `
            <div class="supplier-info">
                <strong>${selectedOption.text}</strong><br>
                <small class="text-muted">
                    ${supplierData.contact || 'No contact info'} | 
                    ${supplierData.address || 'No address info'}
                </small>
            </div>
        `;
        supplierInfo.style.display = 'block';
    } else {
        supplierInfo.style.display = 'none';
    }
});

// Form validation
document.querySelector('.form-modern').addEventListener('submit', function(e) {
    const requiredFields = ['name_obat', 'type', 'unit', 'purchase_price', 'sale_price', 'stok', 'expdate', 'id_supplier'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = document.getElementById(field);
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Please fill in all required fields.');
    }
});

// Price input validation and formatting
document.getElementById('purchase_price').addEventListener('input', function() {
    // Remove any non-numeric characters except decimal point
    this.value = this.value.replace(/[^\d]/g, '');
    calculateMargin();
});

document.getElementById('sale_price').addEventListener('input', function() {
    // Remove any non-numeric characters except decimal point
    this.value = this.value.replace(/[^\d]/g, '');
    calculateMargin();
});

// Format display only (not the actual value)
function formatPriceDisplay(value) {
    if (value && !isNaN(value)) {
        return new Intl.NumberFormat('id-ID').format(value);
    }
    return value;
}
</script>
@endsection