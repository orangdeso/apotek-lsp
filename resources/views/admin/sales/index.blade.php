@extends('layouts.app')

@section('title', 'All Sales - Admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Sales Management /</span> All Sales
            </h4>
            <p class="text-muted mb-0">Manage and view all sales transactions</p>
        </div>
        <div>
            <a href="{{ route('admin.sales.create') }}" class="btn btn-primary">
                <i class="ri-add-line me-1"></i>
                New Sale
            </a>
        </div>
    </div>

    <!-- Sales Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="ri-shopping-cart-line me-2"></i>
                Sales Transactions
            </h5>
            <div class="d-flex gap-2">
                <div class="input-group" style="width: 250px;">
                    <span class="input-group-text"><i class="ri-search-line"></i></span>
                    <input type="text" class="form-control" placeholder="Search transactions..." id="searchInput">
                </div>
            </div>
        </div>
        
        <div class="card-body">
            @if($penjualans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Total Amount</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualans as $penjualan)
                            <tr>
                                <td>
                                    <span class="fw-medium">#{{ str_pad($penjualan->id_penjualan, 4, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded-circle bg-label-primary">
                                                {{ strtoupper(substr($penjualan->user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="fw-medium">{{ $penjualan->user->name }}</span>
                                            <br>
                                            <small class="text-muted">{{ $penjualan->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-success">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    @php
                                        $paymentBadges = [
                                            'cash' => 'bg-success',
                                            'transfer' => 'bg-info',
                                            'card' => 'bg-warning'
                                        ];
                                    @endphp
                                    <span class="badge {{ $paymentBadges[$penjualan->payment_method] ?? 'bg-secondary' }}">
                                        {{ ucfirst($penjualan->payment_method) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusBadges = [
                                            'pending' => 'bg-warning',
                                            'confirmed' => 'bg-info',
                                            'completed' => 'bg-success',
                                            'cancelled' => 'bg-danger'
                                        ];
                                    @endphp
                                    <span class="badge {{ $statusBadges[$penjualan->status] ?? 'bg-secondary' }}">
                                        {{ ucfirst($penjualan->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $penjualan->created_at->format('d M Y') }}</span>
                                    <br>
                                    <small class="text-muted">{{ $penjualan->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                            <i class="ri-more-2-line"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.sales.show', $penjualan->id_penjualan) }}">
                                                    <i class="ri-eye-line me-2"></i>
                                                    View Details
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" onclick="printInvoice({{ $penjualan->id_penjualan }})">
                                                    <i class="ri-printer-line me-2"></i>
                                                    Print Invoice
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $penjualans->firstItem() }} to {{ $penjualans->lastItem() }} of {{ $penjualans->total() }} results
                    </div>
                    {{ $penjualans->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="ri-shopping-cart-line" style="font-size: 4rem; color: #ddd;"></i>
                    </div>
                    <h5 class="text-muted">No Sales Found</h5>
                    <p class="text-muted mb-4">There are no sales transactions yet.</p>
                    <a href="{{ route('admin.sales.create') }}" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i>
                        Create First Sale
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('tbody tr');
    
    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Print invoice function
function printInvoice(saleId) {
    // This would typically open a print-friendly invoice page
    window.open(`/admin/sales/${saleId}/invoice`, '_blank');
}
</script>
@endpush
@endsection