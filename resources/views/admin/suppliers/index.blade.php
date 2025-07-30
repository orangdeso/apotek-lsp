@extends('layouts.app')

@section('title', 'All Suppliers')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-6" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-sm-8">
                            <h4 class="card-title text-white mb-2">
                                <i class="ri ri-building-2-line me-2"></i>All Suppliers
                            </h4>
                            <p class="text-white-50 mb-0">Lihat dan kelola semua data supplier dalam sistem</p>
                        </div>
                        <div class="col-sm-4 text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <span class="badge bg-light text-dark px-3 py-2">
                                    <i class="ri ri-building-2-line me-1"></i>
                                    {{ App\Models\Supplier::count() }} Total Supplier
                                </span>
                                <a href="{{ route('admin.suppliers.create') }}" class="btn btn-light btn-sm">
                                    <i class="ri ri-add-line me-1"></i>Add New Supplier
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

    <!-- Suppliers Table -->
    @include('admin.suppliers.partials.all-suppliers')
</div>
@endsection

@section('scripts')
<script>
    // Delete supplier function
    function deleteSupplier(id, name) {
        if (confirm(`Apakah Anda yakin ingin menghapus supplier "${name}"?
    
    Peringatan: Aksi ini tidak dapat dibatalkan!`)) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            const url = `/admin/suppliers/${id}`;
            
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
                        
                        // Immediately remove the supplier row from DOM
                        const supplierRow = document.querySelector(`tr[data-supplier-id="${id}"]`);
                        if (supplierRow) {
                            supplierRow.style.transition = 'opacity 0.3s ease';
                            supplierRow.style.opacity = '0';
                            setTimeout(() => {
                                supplierRow.remove();
                                
                                // Update total count badge if exists
                                const totalBadge = document.querySelector('.card-header .badge');
                                if (totalBadge && totalBadge.textContent.includes('Total Supplier')) {
                                    const match = totalBadge.textContent.match(/\d+/);
                                    if (match) {
                                        let currentCount = parseInt(match[0]);
                                        if (currentCount > 0) {
                                            totalBadge.textContent = `${--currentCount} Total Supplier`;
                                        }
                                    }
                                }
                                
                                // Check if table is empty and reload if needed
                                const remainingRows = document.querySelectorAll('tr[data-supplier-id]');
                                if (remainingRows.length === 0) {
                                    setTimeout(() => {
                                        location.reload();
                                    }, 500);
                                }
                            }, 300);
                        }
                    } else {
                        alert('Error: ' + data.message);
                    }
                } catch (e) {
                    console.error('Parse error:', e);
                    console.error('Response content:', text);
                    
                    // Show user-friendly error message
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                    alertDiv.innerHTML = `
                        <i class="ri ri-error-warning-line me-2"></i>
                        Terjadi kesalahan saat memproses respons server. Silakan coba lagi.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    
                    const container = document.querySelector('.container-xxl');
                    const firstCard = container.querySelector('.card');
                    if (firstCard && firstCard.nextSibling) {
                        container.insertBefore(alertDiv, firstCard.nextSibling);
                    } else if (firstCard) {
                        container.insertBefore(alertDiv, firstCard);
                    } else {
                        container.appendChild(alertDiv);
                    }
                    
                    // Reload page after 2 seconds to ensure data consistency
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                
                // Show user-friendly error message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                alertDiv.innerHTML = `
                    <i class="ri ri-error-warning-line me-2"></i>
                    Terjadi kesalahan koneksi. Silakan periksa koneksi internet Anda dan coba lagi.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                
                const container = document.querySelector('.container-xxl');
                const firstCard = container.querySelector('.card');
                if (firstCard && firstCard.nextSibling) {
                    container.insertBefore(alertDiv, firstCard.nextSibling);
                } else if (firstCard) {
                    container.insertBefore(alertDiv, firstCard);
                } else {
                    container.appendChild(alertDiv);
                }
            });
        }
    }

    // Edit supplier function
    function editSupplier(id) {
        fetch(`/admin/suppliers/${id}/edit`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const supplier = data.supplier;
                
                // Populate form fields
                document.getElementById('edit_name_supplier').value = supplier.name_supplier || '';
                document.getElementById('edit_alamat').value = supplier.alamat || '';
                document.getElementById('edit_kota').value = supplier.kota || '';
                document.getElementById('edit_telpon').value = supplier.telpon || '';
                
                // Set form action
                document.getElementById('editSupplierForm').action = `/admin/suppliers/${id}`;
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('editSupplierModal'));
                modal.show();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengambil data supplier.');
        });
    }
</script>
@endsection