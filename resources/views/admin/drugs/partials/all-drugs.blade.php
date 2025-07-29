<div class="card border-0">
    <div class="card-header bg-light border-0 py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="ri ri-list-check me-2 text-primary"></i>
                    Daftar Semua Obat
                </h6>
            </div>
            <div class="col-md-6 text-end">
                <div class="d-flex gap-2 justify-content-end">
                    <button class="btn btn-outline-danger btn-sm" onclick="deleteSelected()">
                        <i class="ri ri-delete-bin-line me-1"></i>Delete Selected
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <!-- Search and Filter -->
        <div class="filter-card card border-0 mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Search Drug</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0">
                                <i class="ri ri-search-line text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Cari nama obat..." id="searchDrug">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-medium">Category</label>
                        <select class="form-select" id="filterCategory">
                            <option value="">Semua Kategori</option>
                            <option value="tablet">Tablet</option>
                            <option value="kapsul">Kapsul</option>
                            <option value="sirup">Sirup</option>
                            <option value="salep">Salep</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-medium">Stock Status</label>
                        <select class="form-select" id="filterStock">
                            <option value="">Semua Stok</option>
                            <option value="available">Tersedia</option>
                            <option value="low">Stok Rendah</option>
                            <option value="empty">Habis</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-medium">Expiry Status</label>
                        <select class="form-select" id="filterExpiry">
                            <option value="">Semua</option>
                            <option value="expired">Kadaluarsa</option>
                            <option value="near_expiry">Akan Kadaluarsa</option>
                            <option value="fresh">Masih Fresh</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-medium">&nbsp;</label>
                        <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                            <i class="ri ri-refresh-line me-1"></i>Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Drugs Table -->
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th width="5%">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                            </div>
                        </th>
                        <th width="8%">Gambar</th>
                        <th width="18%">Nama Obat</th>
                        <th width="8%">Kategori</th>
                        <th width="8%">Stok</th>
                        <th width="10%">Harga Beli</th>
                        <th width="10%">Harga Jual</th>
                        <th width="12%">Tanggal Kadaluarsa</th>
                        <th width="10%">Status</th>
                        <th width="11%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($obats as $obat)
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $obat->id_obat }}">
                            </div>
                        </td>
                        <td>
                            @if($obat->image)
                                <img src="{{ asset('storage/' . $obat->image) }}" alt="{{ $obat->name_obat }}" class="drug-image">
                            @else
                                <div class="drug-image d-flex align-items-center justify-content-center bg-light">
                                    <i class="ri ri-image-line "></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $obat->name_obat }}</h6>
                                <small class="text-muted">{{ $obat->supplier->name_supplier ?? 'No Supplier' }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">{{ ucfirst($obat->type) }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="fw-bold {{ $obat->stok <= 10 ? 'text-danger' : 'text-success' }}">
                                    {{ $obat->stok }}
                                </span>
                                <small class="text-muted ms-1">{{ $obat->unit }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold text-secondary">Rp {{ number_format($obat->purchase_price, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <span class="fw-bold text-primary">Rp {{ number_format($obat->sale_price, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <div>
                                <span class="d-block">{{ \Carbon\Carbon::parse($obat->expdate)->format('d M Y') }}</span>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($obat->expdate)->diffForHumans() }}
                                </small>
                            </div>
                        </td>
                        <td>
                            @php
                                $expDate = \Carbon\Carbon::parse($obat->expdate);
                                $now = \Carbon\Carbon::now();
                                $isExpired = $expDate->isPast();
                                $isNearExpiry = $expDate->diffInDays($now) <= 30 && !$isExpired;
                                $isLowStock = $obat->stok <= 10;
                            @endphp
                            
                            @if($isExpired)
                                <span class="status-badge bg-danger text-white">Expired</span>
                            @elseif($isNearExpiry)
                                <span class="status-badge bg-warning text-dark">Near Expiry</span>
                            @elseif($isLowStock)
                                <span class="status-badge bg-warning text-dark">Low Stock</span>
                            @elseif($obat->stok == 0)
                                <span class="status-badge bg-secondary text-white">Out of Stock</span>
                            @else
                                <span class="status-badge bg-success text-white">Available</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-outline-info btn-action" title="View Details" 
                                        onclick="viewDrug({{ $obat->id_obat }})">
                                    <i class="ri ri-eye-line"></i>
                                </button>
                                <button class="btn btn-outline-primary btn-action" title="Edit" 
                                        onclick="editDrug({{ $obat->id_obat }})">
                                    <i class="ri ri-edit-line"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-action" title="Delete" 
                                        onclick="deleteDrug({{ $obat->id_obat }})">
                                    <i class="ri ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center">
                                <i class="ri ri-medicine-bottle-line text-muted" style="font-size: 3rem;"></i>
                                <h6 class="mt-3 text-muted">No drugs found</h6>
                                <p class="text-muted mb-3">Start by adding your first drug to the inventory</p>
                                <a href="{{ route('admin.drugs.create') }}" class="btn btn-primary">
                                    <i class="ri ri-add-line me-1"></i>Add First Drug
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($obats->count() > 0)
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Showing {{ $obats->firstItem() }} to {{ $obats->lastItem() }} of {{ $obats->total() }} drugs
            </div>
            <nav aria-label="Drugs pagination">
                {{ $obats->links() }}
            </nav>
        </div>
        @endif
    </div>
</div>

<!-- Edit Drug Modal -->
<div class="modal fade" id="editDrugModal" tabindex="-1" aria-labelledby="editDrugModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDrugModalLabel">
                    <i class="ri ri-edit-line me-2"></i>Edit Drug
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editDrugForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0"><i class="ri ri-information-line me-2"></i>Basic Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="edit_name_obat" class="form-label">Drug Name *</label>
                                        <input type="text" class="form-control" id="edit_name_obat" name="name_obat" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="edit_type" class="form-label">Type *</label>
                                            <select class="form-select" id="edit_type" name="type" required>
                                                <option value="">Select Type</option>
                                                <option value="tablet">Tablet</option>
                                                <option value="kapsul">Kapsul</option>
                                                <option value="sirup">Sirup</option>
                                                <option value="salep">Salep</option>
                                                <option value="krim">Krim</option>
                                                <option value="tetes">Tetes</option>
                                                <option value="injeksi">Injeksi</option>
                                                <option value="suspensi">Suspensi</option>
                                                <option value="gel">Gel</option>
                                                <option value="spray">Spray</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_unit" class="form-label">Unit *</label>
                                            <select class="form-select" id="edit_unit" name="unit" required>
                                                <option value="">Select Unit</option>
                                                <option value="pcs">Pieces (pcs)</option>
                                                <option value="botol">Botol</option>
                                                <option value="kotak">Kotak</option>
                                                <option value="strip">Strip</option>
                                                <option value="tube">Tube</option>
                                                <option value="vial">Vial</option>
                                                <option value="ampul">Ampul</option>
                                                <option value="sachet">Sachet</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_description" class="form-label">Description</label>
                                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pricing & Inventory -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0"><i class="ri ri-money-dollar-circle-line me-2"></i>Pricing Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="edit_purchase_price" class="form-label">Purchase Price *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" class="form-control" id="edit_purchase_price" name="purchase_price" min="0" step="100" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_sale_price" class="form-label">Sale Price *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" class="form-control" id="edit_sale_price" name="sale_price" min="0" step="100" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-info mt-3" id="edit_margin_info">
                                        <strong>Margin:</strong> <span id="edit_margin_percentage">0%</span><br>
                                        <strong>Profit:</strong> <span id="edit_profit_display">Rp 0</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="edit_stok" class="form-label">Stock Quantity *</label>
                                            <input type="number" class="form-control" id="edit_stok" name="stok" min="0" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_expdate" class="form-label">Expiration Date *</label>
                                            <input type="date" class="form-control" id="edit_expdate" name="expdate" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0"><i class="ri ri-truck-line me-2"></i>Supplier Information</h6>
                                </div>
                                <div class="card-body">
                                    <label for="edit_id_supplier" class="form-label">Supplier *</label>
                                    <select class="form-select" id="edit_id_supplier" name="id_supplier" required>
                                        <option value="">Select Supplier</option>
                                        @foreach($suppliers ?? [] as $supplier)
                                            <option value="{{ $supplier->id_supplier }}">{{ $supplier->name_supplier }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Image Upload -->
                    <div class="card border-0 shadow-sm mt-3">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="ri ri-image-line me-2"></i>Product Image</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="edit_image" class="form-label">Upload New Image</label>
                                    <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, GIF. Max size: 2MB</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Current Image</label>
                                    <div id="edit_current_image_preview">
                                        <!-- Current image will be displayed here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ri ri-close-line me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ri ri-save-line me-1"></i>Update Drug
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteDrugModal" tabindex="-1" aria-labelledby="deleteDrugModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger" id="deleteDrugModalLabel">
                    <i class="ri ri-delete-bin-line me-2"></i>Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <i class="ri ri-error-warning-line text-danger" style="font-size: 4rem;"></i>
                </div>
                <h6 class="mb-3">Are you sure you want to delete this drug?</h6>
                <p class="text-muted mb-3" id="delete_drug_info">This action cannot be undone.</p>
                <div class="alert alert-danger">
                    <strong>Warning:</strong> Deleting this drug will permanently remove it from your inventory.
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="ri ri-close-line me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="ri ri-delete-bin-line me-1"></i>Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Drug actions
function viewDrug(id) {
    // Implement view drug details
    alert('View drug details for ID: ' + id);
}

function editDrug(id) {
    // Fetch drug data and populate modal
    fetch(`/admin/drugs/${id}/edit`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const drug = data.drug;
                const suppliers = data.suppliers;
                
                // Populate form fields
                document.getElementById('edit_name_obat').value = drug.name_obat || '';
                document.getElementById('edit_purchase_price').value = drug.purchase_price || '';
                document.getElementById('edit_sale_price').value = drug.sale_price || '';
                document.getElementById('edit_stok').value = drug.stok || '';
                document.getElementById('edit_description').value = drug.description || '';
                // Format expiration date for date input (YYYY-MM-DD)
                let expdate = drug.expdate || '';
                if (expdate) {
                    const date = new Date(expdate);
                    if (!isNaN(date.getTime())) {
                        expdate = date.toISOString().split('T')[0];
                    }
                }
                document.getElementById('edit_expdate').value = expdate;
                
                // Populate supplier dropdown
                const supplierSelect = document.getElementById('edit_id_supplier');
                supplierSelect.innerHTML = '<option value="">Select Supplier</option>';
                if (suppliers && suppliers.length > 0) {
                    suppliers.forEach(supplier => {
                        const option = document.createElement('option');
                        option.value = supplier.id_supplier;
                        option.textContent = supplier.name_supplier;
                        if (drug.id_supplier == supplier.id_supplier) {
                            option.selected = true;
                        }
                        supplierSelect.appendChild(option);
                    });
                }
                
                // Update form action
                document.getElementById('editDrugForm').action = `/admin/drugs/${id}`;
                
                // Display current image
                const imagePreview = document.getElementById('edit_current_image_preview');
                if (drug.image) {
                    imagePreview.innerHTML = `<img src="/storage/${drug.image}" alt="Current Image" class="img-thumbnail" style="max-height: 100px;">`;
                } else {
                    imagePreview.innerHTML = '<p class="text-muted">No image uploaded</p>';
                }
                
                // Show modal
                const modalElement = document.getElementById('editDrugModal');
                const modal = new bootstrap.Modal(modalElement);
                
                // Set dropdown values after modal is fully shown
                modalElement.addEventListener('shown.bs.modal', function () {
                    // Set Type dropdown
                    const typeSelect = document.getElementById('edit_type');
                    console.log('Setting type value:', drug.type);
                    typeSelect.value = drug.type || '';
                    typeSelect.dispatchEvent(new Event('change'));
                    
                    // Set Unit dropdown
                    const unitSelect = document.getElementById('edit_unit');
                    console.log('Setting unit value:', drug.unit);
                    unitSelect.value = drug.unit || '';
                    unitSelect.dispatchEvent(new Event('change'));
                    
                    // Calculate margin
                    calculateEditMargin();
                }, { once: true });
                
                modal.show();
            } else {
                alert('Error loading drug data');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading drug data');
        });
}

let deleteId = null;

function deleteDrug(id) {
    deleteId = id;
    
    // Fetch drug info for confirmation
    fetch(`/admin/drugs/${id}/edit`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const drug = data.drug;
                document.getElementById('delete_drug_info').innerHTML = 
                    `You are about to delete <strong>${drug.name_obat}</strong>. This action cannot be undone.`;
                
                // Show modal
                new bootstrap.Modal(document.getElementById('deleteDrugModal')).show();
            } else {
                alert('Error loading drug data');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Fallback to simple confirmation
            document.getElementById('delete_drug_info').innerHTML = 'This action cannot be undone.';
            new bootstrap.Modal(document.getElementById('deleteDrugModal')).show();
        });
}

// Confirm delete action
document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (deleteId) {
        // Create a form to submit DELETE request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/drugs/${deleteId}`;
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add method spoofing for DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        document.body.appendChild(form);
        form.submit();
    }
});

// Calculate margin for edit form
function calculateEditMargin() {
    const purchasePrice = parseFloat(document.getElementById('edit_purchase_price').value) || 0;
    const salePrice = parseFloat(document.getElementById('edit_sale_price').value) || 0;
    
    if (purchasePrice > 0 && salePrice > 0) {
        const profit = salePrice - purchasePrice;
        const margin = ((profit / purchasePrice) * 100).toFixed(2);
        
        document.getElementById('edit_margin_percentage').textContent = margin + '%';
        document.getElementById('edit_profit_display').textContent = formatPriceDisplay(profit);
    } else {
        document.getElementById('edit_margin_percentage').textContent = '0%';
        document.getElementById('edit_profit_display').textContent = 'Rp 0';
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

// Add event listeners for margin calculation
document.getElementById('edit_purchase_price').addEventListener('input', calculateEditMargin);
document.getElementById('edit_sale_price').addEventListener('input', calculateEditMargin);

function deleteSelected() {
    const selected = document.querySelectorAll('tbody input[type="checkbox"]:checked');
    if (selected.length === 0) {
        alert('Please select drugs to delete');
        return;
    }
    
    if (confirm(`Are you sure you want to delete ${selected.length} selected drugs? This action cannot be undone.`)) {
        // Get all selected drug IDs
        const drugIds = Array.from(selected).map(checkbox => checkbox.value);
        
        // Create a form to submit DELETE requests for each selected drug
        drugIds.forEach(drugId => {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/drugs/${drugId}`;
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Add method spoofing for DELETE
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            document.body.appendChild(form);
        });
        
        // Submit all forms (this will delete all selected drugs)
        const forms = document.querySelectorAll('form[action*="/admin/drugs/"]');
        if (forms.length > 0) {
            forms[0].submit(); // Submit the first form, which will redirect and show success message
        }
    }
}

// Select all functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
</script>