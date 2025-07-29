@extends('layouts.app')

@section('title', 'All Drugs')

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
                                <i class="ri ri-list-check me-2"></i>All Drugs
                            </h4>
                            <p class="text-white-50 mb-0">Lihat dan kelola semua data obat dalam sistem</p>
                        </div>
                        <div class="col-sm-4 text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <span class="badge bg-light text-dark px-3 py-2">
                                    <i class="ri ri-medicine-bottle-line me-1"></i>
                                    {{ App\Models\Obat::count() }} Total Obat
                                </span>
                                <a href="{{ route('admin.drugs.create') }}" class="btn btn-light btn-sm">
                                    <i class="ri ri-add-line me-1"></i>Add New Drug
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

    <!-- All Drugs Content -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    @include('admin.drugs.partials.all-drugs', ['suppliers' => $suppliers])
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.table-modern {
    border-collapse: separate;
    border-spacing: 0;
}

.table-modern thead th {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: none;
    font-weight: 600;
    color: #495057;
    padding: 1rem 0.75rem;
    position: sticky;
    top: 0;
    z-index: 10;
}

.table-modern tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f1f3f4;
}

.table-modern tbody tr:hover {
    background-color: #f8f9ff;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.table-modern td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border: none;
}

.drug-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: transform 0.2s ease;
}

.drug-image:hover {
    transform: scale(1.1);
}

.status-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-action {
    width: 32px;
    height: 32px;
    padding: 0;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.filter-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.pagination {
    margin: 0;
}

.pagination .page-link {
    border: none;
    padding: 0.5rem 0.75rem;
    margin: 0 2px;
    border-radius: 6px;
    color: #6c757d;
    transition: all 0.2s ease;
}

.pagination .page-link:hover {
    background-color: #e9ecef;
    color: #495057;
    transform: translateY(-1px);
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}
</style>
@endsection

@section('scripts')
<script>
// Search functionality
document.getElementById('searchDrug').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const drugName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        if (drugName.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Filter functionality
function applyFilters() {
    const category = document.getElementById('filterCategory').value;
    const stock = document.getElementById('filterStock').value;
    const expiry = document.getElementById('filterExpiry').value;
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        let show = true;
        
        // Category filter
        if (category && !row.querySelector('td:nth-child(4)').textContent.toLowerCase().includes(category)) {
            show = false;
        }
        
        // Stock filter
        if (stock) {
            const stockValue = parseInt(row.querySelector('td:nth-child(5)').textContent);
            if (stock === 'available' && stockValue <= 0) show = false;
            if (stock === 'low' && stockValue > 10) show = false;
            if (stock === 'empty' && stockValue > 0) show = false;
        }
        
        row.style.display = show ? '' : 'none';
    });
}

// Reset filters
function resetFilters() {
    document.getElementById('filterCategory').value = '';
    document.getElementById('filterStock').value = '';
    document.getElementById('filterExpiry').value = '';
    document.getElementById('searchDrug').value = '';
    
    document.querySelectorAll('tbody tr').forEach(row => {
        row.style.display = '';
    });
}

// Add event listeners to filters
document.getElementById('filterCategory').addEventListener('change', applyFilters);
document.getElementById('filterStock').addEventListener('change', applyFilters);
document.getElementById('filterExpiry').addEventListener('change', applyFilters);

// Select all functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
</script>
@endsection