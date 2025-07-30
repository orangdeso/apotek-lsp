<form action="{{ route('admin.suppliers.store') }}" method="POST" id="createSupplierForm" class="form-modern">
    @csrf
    
    <div class="row">
        <!-- Left Column -->
        <div class="col-md-6">
            <!-- Supplier Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-success text-white">
                    <h6 class="mb-0">
                        <i class="ri ri-information-line me-2"></i>
                        Supplier Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name_supplier" class="form-label">Supplier Name *</label>
                        <input type="text" class="form-control @error('name_supplier') is-invalid @enderror" 
                               id="name_supplier" name="name_supplier" value="{{ old('name_supplier') }}" 
                               placeholder="Masukkan nama supplier" required>
                        @error('name_supplier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="ri ri-information-line me-1"></i>
                            Contoh: PT. Kimia Farma, CV. Apotek Sehat
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="kota" class="form-label">City *</label>
                        <input type="text" class="form-control @error('kota') is-invalid @enderror" 
                               id="kota" name="kota" value="{{ old('kota') }}" 
                               placeholder="Masukkan nama kota" required>
                        @error('kota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="ri ri-map-pin-line me-1"></i>
                            Contoh: Jakarta, Surabaya, Bandung
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="telpon" class="form-label">Phone Number *</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="ri ri-phone-line"></i>
                            </span>
                            <input type="text" class="form-control @error('telpon') is-invalid @enderror" 
                                   id="telpon" name="telpon" value="{{ old('telpon') }}" 
                                   placeholder="Masukkan nomor telepon" required>
                        </div>
                        @error('telpon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="ri ri-information-line me-1"></i>
                            Contoh: 021-1234567, +62-21-1234567
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="col-md-6">
            <!-- Address Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-info text-white">
                    <h6 class="mb-0">
                        <i class="ri ri-map-pin-line me-2"></i>
                        Address Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Complete Address *</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="6" 
                                  placeholder="Masukkan alamat lengkap supplier" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="ri ri-information-line me-1"></i>
                            Masukkan alamat lengkap termasuk jalan, nomor, RT/RW, kelurahan, kecamatan
                        </div>
                    </div>
                    
                    <!-- Preview Card -->
                    <div class="card bg-light border-0">
                        <div class="card-body p-3">
                            <h6 class="card-title mb-2">
                                <i class="ri ri-eye-line me-1"></i>Preview
                            </h6>
                            <div class="preview-content">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar avatar-sm me-2">
                                        <div class="avatar-initial bg-success rounded-circle">
                                            <i class="ri ri-building-2-line"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <span id="preview-name" class="fw-medium text-muted">Supplier Name</span>
                                    </div>
                                </div>
                                <div class="small text-muted">
                                    <div><i class="ri ri-map-pin-line me-1"></i><span id="preview-address">Address</span></div>
                                    <div><i class="ri ri-building-line me-1"></i><span id="preview-city">City</span></div>
                                    <div><i class="ri ri-phone-line me-1"></i><span id="preview-phone">Phone</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Submit Button -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Ready to create supplier?</h6>
                            <small class="text-muted">Make sure all information is correct before submitting</small>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">
                                <i class="ri ri-close-line me-1"></i>Cancel
                            </a>
                            <button type="submit" id="submitBtn" class="btn btn-success">
                                <i class="ri ri-save-line me-1"></i>Create Supplier
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
// Real-time preview update
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name_supplier');
    const addressInput = document.getElementById('alamat');
    const cityInput = document.getElementById('kota');
    const phoneInput = document.getElementById('telpon');
    
    const previewName = document.getElementById('preview-name');
    const previewAddress = document.getElementById('preview-address');
    const previewCity = document.getElementById('preview-city');
    const previewPhone = document.getElementById('preview-phone');
    
    function updatePreview() {
        previewName.textContent = nameInput.value || 'Supplier Name';
        previewAddress.textContent = addressInput.value || 'Address';
        previewCity.textContent = cityInput.value || 'City';
        previewPhone.textContent = phoneInput.value || 'Phone';
    }
    
    nameInput.addEventListener('input', updatePreview);
    addressInput.addEventListener('input', updatePreview);
    cityInput.addEventListener('input', updatePreview);
    phoneInput.addEventListener('input', updatePreview);
});
</script>