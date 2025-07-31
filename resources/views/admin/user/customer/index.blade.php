@extends('layouts.app')

@section('title', 'Customer Management')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bx bx-error-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-6" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-sm-8">
                            <h4 class="card-title text-white mb-2">
                                <i class="ri ri-user-line me-2"></i>All Customers
                            </h4>
                            <p class="text-white-50 mb-0">Lihat dan kelola semua data pelanggan dalam sistem</p>
                        </div>
                        <div class="col-sm-4 text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <span class="badge bg-light text-dark px-3 py-2">
                                    <i class="ri ri-user-line me-1"></i>
                                    {{ App\Models\User::where('role', 'pelanggan')->count() }} Total Customer
                                </span>
                                <a href="{{ route('admin.customers.create') }}" class="btn btn-light btn-sm">
                                    <i class="ri ri-add-line me-1"></i>Add New Customer
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-6">
        <div class="col-lg-3 col-md-6 col-12 mb-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="content-left">
                            <span class="text-heading">Total Customer</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $customers->total() }}</h4>
                            </div>
                            <small class="mb-0">Pelanggan terdaftar</small>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-user bx-lg"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12 mb-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="content-left">
                            <span class="text-heading">Customer Aktif</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $customers->where('created_at', '>=', now()->subDays(30))->count() }}</h4>
                            </div>
                            <small class="mb-0">30 hari terakhir</small>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bx-user-check bx-lg"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="ri ri-user-line me-2"></i>Customers List
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
                            <th class="border-bottom-0">Customer Name</th>
                            <th class="border-bottom-0">Email</th>
                            <th class="border-bottom-0">Address</th>
                            <th class="border-bottom-0">City</th>
                            <th class="border-bottom-0">Phone</th>
                            <th class="border-bottom-0">Status</th>
                            <th class="border-bottom-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($customers->count() > 0)
                            @foreach($customers as $customer)
                            <tr data-customer-id="{{ $customer->id }}">
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input customer-checkbox" type="checkbox" 
                                               value="{{ $customer->id }}" 
                                               id="customer_{{ $customer->id }}">
                                        <label class="form-check-label" for="customer_{{ $customer->id }}"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-3">
                                            <div class="avatar-initial bg-label-success rounded-circle">
                                                <i class="ri ri-user-line"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $customer->name }}</h6>
                                            <small class="text-muted">ID: {{ $customer->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="ri ri-mail-line me-1 text-muted"></i>
                                        <span>{{ $customer->email }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-truncate d-block" style="max-width: 200px;" 
                                          title="{{ $customer->alamat }}">
                                        {{ Str::limit($customer->alamat, 50) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-label-info">{{ $customer->kota }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="ri ri-phone-line me-1 text-muted"></i>
                                        <span>{{ $customer->telpon }}</span>
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
                                                <a class="dropdown-item" href="{{ route('admin.customers.edit', $customer->id) }}">
                                                    <i class="ri ri-edit-line me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-danger" 
                                                        onclick="deleteCustomer({{ $customer->id }}, '{{ addslashes($customer->name) }}')">
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
                                <td colspan="8" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="ri ri-user-x-line ri-2x text-muted mb-2"></i>
                                        <span class="text-muted">No customers found</span>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
            @if($customers->hasPages())
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Menampilkan {{ $customers->firstItem() }} sampai {{ $customers->lastItem() }} dari {{ $customers->total() }} data
                    </small>
                    {{ $customers->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>


@endsection



@section('scripts')
<script>
    // Delete customer function
    function deleteCustomer(id, name) {
        if (confirm(`Apakah Anda yakin ingin menghapus customer "${name}"?
    
    Peringatan: Aksi ini tidak dapat dibatalkan!`)) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            const url = `/admin/customers/${id}`;
            
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : '',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                return response.text();
            })
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    if (data.success) {
                        // Show success message
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-success alert-dismissible fade show';
                        alertDiv.innerHTML = `
                            <i class="ri ri-check-circle-line me-2"></i>
                            ${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;
                        
                        // Insert alert at the top of the content
                        const container = document.querySelector('.container-xxl');
                        const firstCard = container.querySelector('.card');
                        if (firstCard && firstCard.nextSibling) {
                            container.insertBefore(alertDiv, firstCard.nextSibling);
                        } else if (firstCard) {
                            container.insertBefore(alertDiv, firstCard);
                        } else {
                            container.appendChild(alertDiv);
                        }
                        
                        // Remove the customer row from table
                        const customerRow = document.querySelector(`tr[data-customer-id="${id}"]`);
                        if (customerRow) {
                            customerRow.remove();
                        }
                        
                        // Auto dismiss alert after 5 seconds
                        setTimeout(() => {
                            if (alertDiv && alertDiv.parentNode) {
                                alertDiv.remove();
                            }
                        }, 5000);
                    } else {
                        alert('Error: ' + (data.message || 'Failed to delete customer'));
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    alert('Error: Invalid response from server');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: Failed to delete customer');
            });
        }
    }
    
    // Select all functionality
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const customerCheckboxes = document.querySelectorAll('.customer-checkbox');
        
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                customerCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        }
        
        // Update select all checkbox when individual checkboxes change
        customerCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkedCount = document.querySelectorAll('.customer-checkbox:checked').length;
                const totalCount = customerCheckboxes.length;
                
                if (selectAllCheckbox) {
                    selectAllCheckbox.checked = checkedCount === totalCount;
                    selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < totalCount;
                }
            });
        });
    });
</script>
@endsection