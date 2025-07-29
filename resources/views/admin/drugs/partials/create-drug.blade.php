<form action="{{ route('admin.drugs.store') }}" method="POST" enctype="multipart/form-data" class="form-modern">
    @csrf
    
    <div class="row">
        <!-- Left Column -->
        <div class="col-md-6">
            <!-- Product Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-primary text-white">
                    <h6 class="mb-0">
                        <i class="ri ri-information-line me-2"></i>
                        Product Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name_obat" class="form-label">Nama Obat *</label>
                        <input type="text" class="form-control @error('name_obat') is-invalid @enderror" 
                               id="name_obat" name="name_obat" value="{{ old('name_obat') }}" 
                               placeholder="Masukkan nama obat" required>
                        @error('name_obat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="type" class="form-label">Tipe Obat *</label>
                                <select class="form-select @error('type') is-invalid @enderror" 
                                        id="type" name="type" required>
                                    <option value="">Pilih Tipe</option>
                                    <option value="tablet" {{ old('type') == 'tablet' ? 'selected' : '' }}>Tablet</option>
                                    <option value="kapsul" {{ old('type') == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                                    <option value="sirup" {{ old('type') == 'sirup' ? 'selected' : '' }}>Sirup</option>
                                    <option value="salep" {{ old('type') == 'salep' ? 'selected' : '' }}>Salep</option>
                                    <option value="krim" {{ old('type') == 'krim' ? 'selected' : '' }}>Krim</option>
                                    <option value="tetes" {{ old('type') == 'tetes' ? 'selected' : '' }}>Tetes</option>
                                    <option value="injeksi" {{ old('type') == 'injeksi' ? 'selected' : '' }}>Injeksi</option>
                                    <option value="suspensi" {{ old('type') == 'suspensi' ? 'selected' : '' }}>Suspensi</option>
                                    <option value="gel" {{ old('type') == 'gel' ? 'selected' : '' }}>Gel</option>
                                    <option value="spray" {{ old('type') == 'spray' ? 'selected' : '' }}>Spray</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="unit" class="form-label">Unit *</label>
                                <select class="form-select @error('unit') is-invalid @enderror" 
                                        id="unit" name="unit" required>
                                    <option value="">Pilih Unit</option>
                                    <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>Pieces (pcs)</option>
                                    <option value="botol" {{ old('unit') == 'botol' ? 'selected' : '' }}>Botol</option>
                                    <option value="kotak" {{ old('unit') == 'kotak' ? 'selected' : '' }}>Kotak</option>
                                    <option value="strip" {{ old('unit') == 'strip' ? 'selected' : '' }}>Strip</option>
                                    <option value="tube" {{ old('unit') == 'tube' ? 'selected' : '' }}>Tube</option>
                                    <option value="vial" {{ old('unit') == 'vial' ? 'selected' : '' }}>Vial</option>
                                    <option value="ampul" {{ old('unit') == 'ampul' ? 'selected' : '' }}>Ampul</option>
                                    <option value="sachet" {{ old('unit') == 'sachet' ? 'selected' : '' }}>Sachet</option>
                                </select>
                                @error('unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="Masukkan deskripsi obat (opsional)">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Image Upload -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-info text-white">
                    <h6 class="mb-0">
                        <i class="ri ri-image-line me-2"></i>
                        Product Image
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Gambar</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*" onchange="previewImage(this)">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: JPG, PNG, GIF. Max size: 2MB</small>
                    </div>
                    
                    <div class="text-center">
                        <div class="image-preview" id="imagePreview">
                            <div class="text-muted">
                                <i class="ri ri-image-add-line" style="font-size: 2rem;"></i>
                                <p class="mt-2 mb-0">Click to upload image</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="col-md-6">
            <!-- Pricing -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-success text-white">
                    <h6 class="mb-0">
                        <i class="ri ri-money-dollar-circle-line me-2"></i>
                        Pricing Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="purchase_price" class="form-label">Harga Beli *</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('purchase_price') is-invalid @enderror" 
                                           id="purchase_price" name="purchase_price" value="{{ old('purchase_price') }}" 
                                           placeholder="0" min="0" step="100" required>
                                </div>
                                @error('purchase_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sale_price" class="form-label">Harga Jual *</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('sale_price') is-invalid @enderror" 
                                           id="sale_price" name="sale_price" value="{{ old('sale_price') }}" 
                                           placeholder="0" min="0" step="100" required>
                                </div>
                                @error('sale_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Price Calculator -->
                    <div class="price-calculator">
                        <h6 class="mb-2">Margin Calculator</h6>
                        <div id="marginDisplay" class="margin-display">
                            <span class="text-muted">Masukkan harga untuk melihat margin</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Inventory -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-warning text-white">
                    <h6 class="mb-0">
                        <i class="ri ri-archive-line me-2"></i>
                        Inventory Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stok" class="form-label">Stok Awal *</label>
                                <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                       id="stok" name="stok" value="{{ old('stok') }}" 
                                       placeholder="0" min="0" required>
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="expdate" class="form-label">Tanggal Kadaluarsa *</label>
                                <input type="date" class="form-control @error('expdate') is-invalid @enderror" 
                                       id="expdate" name="expdate" value="{{ old('expdate') }}" 
                                       min="{{ date('Y-m-d') }}" required>
                                @error('expdate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Supplier Selection -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-primary text-white">
                    <h6 class="mb-0">
                        <i class="ri ri-building-2-line me-2"></i>
                        Supplier Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="id_supplier" class="form-label">Pilih Supplier *</label>
                        <select class="form-select @error('id_supplier') is-invalid @enderror" 
                                id="id_supplier" name="id_supplier" required>
                            <option value="">Pilih Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id_supplier }}" 
                                        data-contact="{{ $supplier->telpon }}" 
                                        data-address="{{ $supplier->alamat }}"
                                        {{ old('id_supplier') == $supplier->id_supplier ? 'selected' : '' }}>
                                    {{ $supplier->name_supplier }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_supplier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div id="supplierInfo" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Form Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">* Required fields</small>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.drugs.index') }}" class="btn btn-secondary-modern btn-modern">
                                <i class="ri ri-close-line me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary-modern btn-modern">
                                <i class="ri ri-save-line me-1"></i>Save Drug
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>