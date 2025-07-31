@extends('layouts.app')

@section('title', 'Sale Details - Admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Sales Management /</span> Sale Details
            </h4>
            <p class="text-muted mb-0">View detailed information about sale #{{ str_pad($penjualan->id_penjualan, 4, '0', STR_PAD_LEFT) }}</p>
        </div>
        <div>
            <a href="{{ route('admin.sales.index') }}" class="btn btn-outline-secondary">
                <i class="ri-arrow-left-line me-1"></i>
                Back to Sales
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Sale Information -->
        <div class="col-lg-8">
            <!-- Sale Header -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">
                            <i class="ri-shopping-cart-line me-2"></i>
                            Sale #{{ str_pad($penjualan->id_penjualan, 4, '0', STR_PAD_LEFT) }}
                        </h5>
                        <small class="text-muted">{{ $penjualan->created_at->format('d M Y, H:i') }}</small>
                    </div>
                    <div>
                        @php
                            $statusBadges = [
                                'pending' => 'bg-warning',
                                'confirmed' => 'bg-info',
                                'completed' => 'bg-success',
                                'cancelled' => 'bg-danger'
                            ];
                        @endphp
                        <span class="badge {{ $statusBadges[$penjualan->status] ?? 'bg-secondary' }} fs-6">
                            {{ ucfirst($penjualan->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Customer Information</h6>
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg me-3">
                                    <span class="avatar-initial rounded-circle bg-label-primary fs-4">
                                        {{ strtoupper(substr($penjualan->user->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <h6 class="mb-1">{{ $penjualan->user->name }}</h6>
                                    <p class="text-muted mb-1">{{ $penjualan->user->email }}</p>
                                    @if($penjualan->user->phone)
                                        <p class="text-muted mb-0">{{ $penjualan->user->phone }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Transaction Details</h6>
                            <div class="mb-2">
                                <strong>Payment Method:</strong>
                                @php
                                    $paymentBadges = [
                                        'cash' => 'bg-success',
                                        'transfer' => 'bg-info',
                                        'card' => 'bg-warning'
                                    ];
                                @endphp
                                <span class="badge {{ $paymentBadges[$penjualan->payment_method] ?? 'bg-secondary' }} ms-2">
                                    {{ ucfirst($penjualan->payment_method) }}
                                </span>
                            </div>
                            <div class="mb-2">
                                <strong>Total Amount:</strong>
                                <span class="text-success fw-bold ms-2">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</span>
                            </div>
                            @if($penjualan->notes)
                                <div class="mb-2">
                                    <strong>Notes:</strong>
                                    <p class="text-muted mb-0 mt-1">{{ $penjualan->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sale Items -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-list-check me-2"></i>
                        Sale Items ({{ $penjualan->penjualanDetails->count() }} items)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($penjualan->penjualanDetails as $detail)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <span class="avatar-initial rounded-circle bg-label-info">
                                                    <i class="ri-capsule-line"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="fw-medium">{{ $detail->obat->name_obat }}</span>
                                                @if($detail->obat->kategori)
                                                    <br><small class="text-muted">{{ $detail->obat->kategori }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary">{{ $detail->quantity }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-medium">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th>
                                        <span class="text-success fw-bold">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</span>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sale Summary & Actions -->
        <div class="col-lg-4">
            <!-- Quick Stats -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-bar-chart-line me-2"></i>
                        Quick Stats
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Items:</span>
                        <span class="fw-bold">{{ $penjualan->penjualanDetails->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Quantity:</span>
                        <span class="fw-bold">{{ $penjualan->penjualanDetails->sum('quantity') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Average Item Price:</span>
                        <span class="fw-bold">Rp {{ number_format($penjualan->penjualanDetails->avg('unit_price'), 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Total Amount:</span>
                        <span class="fw-bold text-success">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-settings-line me-2"></i>
                        Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" onclick="printInvoice()">
                            <i class="ri-printer-line me-2"></i>
                            Print Invoice
                        </button>
                        <button class="btn btn-outline-info" onclick="downloadPDF()">
                            <i class="ri-download-line me-2"></i>
                            Download PDF
                        </button>
                        @if($penjualan->status === 'pending')
                            <button class="btn btn-outline-success" onclick="confirmSale()">
                                <i class="ri-check-line me-2"></i>
                                Confirm Sale
                            </button>
                            <button class="btn btn-outline-danger" onclick="cancelSale()">
                                <i class="ri-close-line me-2"></i>
                                Cancel Sale
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-time-line me-2"></i>
                        Timeline
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-indicator bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Sale Created</h6>
                                <small class="text-muted">{{ $penjualan->created_at->format('d M Y, H:i') }}</small>
                            </div>
                        </div>
                        @if($penjualan->status === 'completed')
                            <div class="timeline-item">
                                <div class="timeline-indicator bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Sale Completed</h6>
                                    <small class="text-muted">{{ $penjualan->updated_at->format('d M Y, H:i') }}</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 20px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -15px;
    top: 20px;
    width: 2px;
    height: calc(100% + 10px);
    background-color: #e9ecef;
}

.timeline-indicator {
    position: absolute;
    left: -20px;
    top: 5px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}
</style>
@endpush

@push('scripts')
<script>
function printInvoice() {
    window.print();
}

function downloadPDF() {
    // This would typically generate and download a PDF
    alert('PDF download functionality would be implemented here');
}

function confirmSale() {
    if (confirm('Are you sure you want to confirm this sale?')) {
        // Implementation for confirming sale
        alert('Sale confirmation functionality would be implemented here');
    }
}

function cancelSale() {
    if (confirm('Are you sure you want to cancel this sale? This action cannot be undone.')) {
        // Implementation for canceling sale
        alert('Sale cancellation functionality would be implemented here');
    }
}
</script>
@endpush
@endsection