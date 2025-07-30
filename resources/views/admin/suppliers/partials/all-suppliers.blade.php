<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="ri ri-building-2-line me-2"></i>Suppliers List
        </h5>
        <div class="d-flex gap-2">
            <!-- Search functionality can be added here later -->
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-bottom-0">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll"></label>
                            </div>
                        </th>
                        <th class="border-bottom-0">Supplier Name</th>
                        <th class="border-bottom-0">Address</th>
                        <th class="border-bottom-0">City</th>
                        <th class="border-bottom-0">Phone</th>
                        <th class="border-bottom-0">Total Drugs</th>
                        <th class="border-bottom-0">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($suppliers->count() > 0)
                        @foreach($suppliers as $supplier)
                        <tr data-supplier-id="{{ $supplier->id_supplier }}">
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input supplier-checkbox" type="checkbox" 
                                           value="{{ $supplier->id_supplier }}" 
                                           id="supplier_{{ $supplier->id_supplier }}">
                                    <label class="form-check-label" for="supplier_{{ $supplier->id_supplier }}"></label>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <div class="avatar-initial bg-label-success rounded-circle">
                                            <i class="ri ri-building-2-line"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $supplier->name_supplier }}</h6>
                                        <small class="text-muted">ID: {{ $supplier->id_supplier }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-truncate d-block" style="max-width: 200px;" 
                                      title="{{ $supplier->alamat }}">
                                    {{ Str::limit($supplier->alamat, 50) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-label-info">{{ $supplier->kota }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="ri ri-phone-line me-1 text-muted"></i>
                                    <span>{{ $supplier->telpon }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="ri ri-medicine-bottle-line me-1 text-primary"></i>
                                    <span class="badge bg-label-primary">{{ $supplier->obats_count ?? 0 }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri ri-more-2-line"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <button class="dropdown-item" onclick="editSupplier({{ $supplier->id_supplier }})">
                                                <i class="ri ri-edit-line me-2"></i>Edit
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-danger" 
                                                    onclick="deleteSupplier({{ $supplier->id_supplier }}, '{{ addslashes($supplier->name_supplier) }}')">
                                                <i class="ri ri-delete-bin-line me-2"></i>Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="ri ri-building-2-line text-muted" style="font-size: 3rem;"></i>
                                    <h6 class="mt-3 text-muted">No suppliers found</h6>
                                    <p class="text-muted mb-3">Start by adding your first supplier to the system</p>
                                    <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">
                                        <i class="ri ri-add-line me-1"></i>Add First Supplier
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($suppliers->count() > 0)
        <div class="d-flex justify-content-between align-items-center mt-4 px-4 pb-4">
            <div class="text-muted">
                Showing {{ $suppliers->firstItem() }} to {{ $suppliers->lastItem() }} of {{ $suppliers->total() }} suppliers
            </div>
            <nav aria-label="Suppliers pagination">
                {{ $suppliers->links() }}
            </nav>
        </div>
        @endif
    </div>
</div>

<!-- Edit Supplier Modal -->
<div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSupplierModalLabel">
                    <i class="ri ri-edit-line me-2"></i>Edit Supplier
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editSupplierForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_name_supplier" class="form-label">Supplier Name *</label>
                                <input type="text" class="form-control" id="edit_name_supplier" 
                                       name="name_supplier" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_kota" class="form-label">City *</label>
                                <input type="text" class="form-control" id="edit_kota" 
                                       name="kota" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="edit_alamat" class="form-label">Address *</label>
                                <textarea class="form-control" id="edit_alamat" name="alamat" 
                                          rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_telpon" class="form-label">Phone *</label>
                                <input type="text" class="form-control" id="edit_telpon" 
                                       name="telpon" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ri ri-close-line me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ri ri-save-line me-1"></i>Update Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Handle edit form submission
document.getElementById('editSupplierForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const actionUrl = this.action;
    
    fetch(actionUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('editSupplierModal'));
            modal.hide();
            
            // Show success message and reload page
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memperbarui supplier.');
    });
});

// Handle select all checkbox
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.supplier-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
</script>