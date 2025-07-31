<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="ri ri-user-heart-line me-2"></i>Pharmacists List
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
                        <th class="border-bottom-0">Pharmacist Name</th>
                        <th class="border-bottom-0">Email</th>
                        <th class="border-bottom-0">Address</th>
                        <th class="border-bottom-0">City</th>
                        <th class="border-bottom-0">Phone</th>
                        <th class="border-bottom-0">Status</th>
                        <th class="border-bottom-0">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($pharmacists->count() > 0)
                        @foreach($pharmacists as $pharmacist)
                        <tr data-pharmacist-id="{{ $pharmacist->id }}">
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input pharmacist-checkbox" type="checkbox" 
                                           value="{{ $pharmacist->id }}" 
                                           id="pharmacist_{{ $pharmacist->id }}">
                                    <label class="form-check-label" for="pharmacist_{{ $pharmacist->id }}"></label>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <div class="avatar-initial bg-label-primary rounded-circle">
                                            <i class="ri ri-user-heart-line"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $pharmacist->name }}</h6>
                                        <small class="text-muted">ID: {{ $pharmacist->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="ri ri-mail-line me-1 text-muted"></i>
                                    <span>{{ $pharmacist->email }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-truncate d-block" style="max-width: 200px;" 
                                      title="{{ $pharmacist->alamat }}">
                                    {{ Str::limit($pharmacist->alamat, 50) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-label-info">{{ $pharmacist->kota }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="ri ri-phone-line me-1 text-muted"></i>
                                    <span>{{ $pharmacist->telpon }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-label-success">
                                    <i class="ri ri-check-circle-line me-1"></i>
                                    Active
                                </span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri ri-more-2-line"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <button class="dropdown-item" onclick="editPharmacist({{ $pharmacist->id }})">
                                                <i class="ri ri-edit-line me-2"></i>Edit
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-danger" 
                                                    onclick="deletePharmacist({{ $pharmacist->id }}, '{{ addslashes($pharmacist->name) }}')">
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
                            <td colspan="8" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="ri ri-user-heart-line text-muted" style="font-size: 3rem;"></i>
                                    <h6 class="mt-3 text-muted">No pharmacists found</h6>
                                    <p class="text-muted mb-3">Start by adding your first pharmacist to the system</p>
                                    <a href="{{ route('admin.pharmacists.create') }}" class="btn btn-primary">
                                        <i class="ri ri-add-line me-1"></i>Add First Pharmacist
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($pharmacists->count() > 0)
        <div class="d-flex justify-content-between align-items-center mt-4 px-4 pb-4">
            <div class="text-muted">
                Showing {{ $pharmacists->firstItem() }} to {{ $pharmacists->lastItem() }} of {{ $pharmacists->total() }} pharmacists
            </div>
            <nav aria-label="Pharmacists pagination">
                {{ $pharmacists->links() }}
            </nav>
        </div>
        @endif
    </div>
</div>

<!-- Edit Pharmacist Modal -->
<div class="modal fade" id="editPharmacistModal" tabindex="-1" aria-labelledby="editPharmacistModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPharmacistModalLabel">
                    <i class="ri ri-edit-line me-2"></i>Edit Pharmacist
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPharmacistForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="edit_name" 
                                       name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="edit_email" 
                                       name="email" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_kota" class="form-label">City *</label>
                                <input type="text" class="form-control" id="edit_kota" 
                                       name="kota" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_telpon" class="form-label">Phone Number *</label>
                                <input type="text" class="form-control" id="edit_telpon" 
                                       name="telpon" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_alamat" class="form-label">Complete Address *</label>
                        <textarea class="form-control" id="edit_alamat" name="alamat" 
                                  rows="3" required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="edit_password" 
                                       name="password" placeholder="Leave blank to keep current password">
                                <div class="form-text">Minimum 8 characters</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="edit_password_confirmation" 
                                       name="password_confirmation" placeholder="Confirm new password">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ri ri-close-line me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ri ri-save-line me-1"></i>Update Pharmacist
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Select all functionality
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const pharmacistCheckboxes = document.querySelectorAll('.pharmacist-checkbox');
        
        selectAllCheckbox.addEventListener('change', function() {
            pharmacistCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
        
        // Update select all checkbox when individual checkboxes change
        pharmacistCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkedCount = document.querySelectorAll('.pharmacist-checkbox:checked').length;
                selectAllCheckbox.checked = checkedCount === pharmacistCheckboxes.length;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < pharmacistCheckboxes.length;
            });
        });
        
        // Handle edit form submission
        const editForm = document.getElementById('editPharmacistForm');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                
                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="ri ri-loader-4-line me-1 spinner-border spinner-border-sm"></i>Updating...';
                
                const formData = new FormData(this);
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editPharmacistModal'));
                        modal.hide();
                        
                        // Show success message
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-success alert-dismissible fade show';
                        alertDiv.innerHTML = `
                            <i class="ri ri-check-circle-line me-2"></i>
                            ${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;
                        
                        const container = document.querySelector('.container-xxl');
                        const firstCard = container.querySelector('.card');
                        container.insertBefore(alertDiv, firstCard);
                        
                        // Reload page to show updated data
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        // Show error message
                        alert('Error: ' + (data.message || 'Failed to update pharmacist'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui data apoteker.');
                })
                .finally(() => {
                    // Reset button state
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
            });
        }
    });
</script>