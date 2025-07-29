@extends('layouts.app')

@section('title', 'Edit Drug')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-6" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-sm-8">
                            <h4 class="card-title text-white mb-2">
                                <i class="ri ri-edit-line me-2"></i>Edit Drug
                            </h4>
                            <p class="text-white-50 mb-0">Update drug information in the system</p>
                        </div>
                        <div class="col-sm-4 text-end">
                            <a href="{{ route('admin.drugs.index') }}" class="btn btn-light btn-sm">
                                <i class="ri ri-arrow-left-line me-1"></i>Back to All Drugs
                            </a>
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

    <!-- Edit Form -->
    <form action="{{ route('admin.drugs.update', $obat->id_obat) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Basic Information -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="ri ri-information-line me-2"></i>Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name_obat" class="form-label">Drug Name *</label>
                            <input type="text" class="form-control @error('name_obat') is-invalid @enderror" 
                                   id="name_obat" name="name_obat" value="{{ old('name_obat', $obat->name_obat) }}" required>
                            @error('name_obat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label for="type" class="form-label">Type *</label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="Tablet" {{ old('type', $obat->type) == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                                    <option value="Capsule" {{ old('type', $obat->type) == 'Capsule' ? 'selected' : '' }}>Capsule</option>
                                    <option value="Syrup" {{ old('type', $obat->type) == 'Syrup' ? 'selected' : '' }}>Syrup</option>
                                    <option value="Injection" {{ old('type', $obat->type) == 'Injection' ? 'selected' : '' }}>Injection</option>
                                    <option value="Cream" {{ old('type', $obat->type) == 'Cream' ? 'selected' : '' }}>Cream</option>
                                    <option value="Ointment" {{ old('type', $obat->type) == 'Ointment' ? 'selected' : '' }}>Ointment</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="unit" class="form-label">Unit *</label>
                                <select class="form-select @error('unit') is-invalid @enderror" id="unit" name="unit" required>
                                    <option value="">Select Unit</option>
                                    <option value="Pieces (pcs)" {{ old('unit', $obat->unit) == 'Pieces (pcs)' ? 'selected' : '' }}>Pieces (pcs)</option>
                                    <option value="Bottles" {{ old('unit', $obat->unit) == 'Bottles' ? 'selected' : '' }}>Bottles</option>
                                    <option value="Boxes" {{ old('unit', $obat->unit) == 'Boxes' ? 'selected' : '' }}>Boxes</option>
                                    <option value="Strips" {{ old('unit', $obat->unit) == 'Strips' ? 'selected' : '' }}>Strips</option>
                                </select>
                                @error('unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $obat->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pricing & Inventory -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="ri ri-money-dollar-circle-line me-2"></i>Pricing Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="purchase_price" class="form-label">Purchase Price *</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('purchase_price') is-invalid @enderror" 
                                           id="purchase_price" name="purchase_price" value="{{ old('purchase_price', $obat->purchase_price) }}" 
                                           min="0" step="100" required>
                                </div>
                                @error('purchase_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="sale_price" class="form-label">Sale Price *</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('sale_price') is-invalid @enderror" 
                                           id="sale_price" name="sale_price" value="{{ old('sale_price', $obat->sale_price) }}" 
                                           min="0" step="100" required>
                                </div>
                                @error('sale_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="alert alert-info mt-3" id="margin_info">
                            <strong>Margin:</strong> <span id="margin_percentage">0%</span><br>
                            <strong>Profit:</strong> <span id="profit_display">Rp 0</span>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label for="stok" class="form-label">Stock Quantity *</label>
                                <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                       id="stok" name="stok" value="{{ old('stok', $obat->stok) }}" min="0" required>
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="expdate" class="form-label">Expiration Date *</label>
                                <input type="date" class="form-control @error('expdate') is-invalid @enderror" 
                                       id="expdate" name="expdate" value="{{ old('expdate', $obat->expdate) }}" required>
                                @error('expdate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="ri ri-truck-line me-2"></i>Supplier Information</h6>
                    </div>
                    <div class="card-body">
                        <label for="id_supplier" class="form-label">Supplier *</label>
                        <select class="form-select @error('id_supplier') is-invalid @enderror" id="id_supplier" name="id_supplier" required>
                            <option value="">Select Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id_supplier }}" 
                                        {{ old('id_supplier', $obat->id_supplier) == $supplier->id_supplier ? 'selected' : '' }}>
                                    {{ $supplier->name_supplier }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_supplier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Image Upload -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="ri ri-image-line me-2"></i>Product Image</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="image" class="form-label">Upload New Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, GIF. Max size: 2MB. Leave empty to keep current image.</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Current Image</label>
                        <div>
                            @if($obat->image)
                                <img src="{{ asset('storage/' . $obat->image) }}" alt="Current Image" 
                                     class="img-thumbnail" style="max-height: 150px;">
                            @else
                                <p class="text-muted">No image uploaded</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Actions -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.drugs.index') }}" class="btn btn-secondary">
                        <i class="ri ri-arrow-left-line me-1"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ri ri-save-line me-1"></i>Update Drug
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Calculate margin
function calculateMargin() {
    const purchasePrice = parseFloat(document.getElementById('purchase_price').value) || 0;
    const salePrice = parseFloat(document.getElementById('sale_price').value) || 0;
    
    if (purchasePrice > 0 && salePrice > 0) {
        const profit = salePrice - purchasePrice;
        const margin = ((profit / purchasePrice) * 100).toFixed(2);
        
        document.getElementById('margin_percentage').textContent = margin + '%';
        document.getElementById('profit_display').textContent = formatPriceDisplay(profit);
    } else {
        document.getElementById('margin_percentage').textContent = '0%';
        document.getElementById('profit_display').textContent = 'Rp 0';
    }
}

// Format price display
function formatPriceDisplay(price) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(price);
}

// Add event listeners
document.getElementById('purchase_price').addEventListener('input', calculateMargin);
document.getElementById('sale_price').addEventListener('input', calculateMargin);

// Calculate initial margin
calculateMargin();
</script>
@endsection