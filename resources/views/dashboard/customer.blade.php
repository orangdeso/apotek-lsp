@extends('layouts.customer')

@section('title', 'LSP Apotek - Online Pharmacy')

@section('content')
<!-- Welcome Section -->
<div class="row mb-6">
    <div class="col-12">
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-center py-5">
                <h2 class="text-white mb-3">Welcome to LSP Apotek</h2>
                <p class="text-white mb-0 fs-5">Your trusted online pharmacy for quality medicines and healthcare products</p>
            </div>
        </div>
    </div>
</div>

<!-- Advanced Search Filter -->
<div class="row mb-6">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Find Your Medicine</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('customer.obat.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Medicine Name</label>
                            <input type="text" class="form-control" name="search" placeholder="Search medicine name..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category">
                                <option value="">All Categories</option>
                                <option value="prescription" {{ request('category') == 'prescription' ? 'selected' : '' }}>Prescription</option>
                                <option value="otc" {{ request('category') == 'otc' ? 'selected' : '' }}>Over-the-Counter</option>
                                <option value="supplement" {{ request('category') == 'supplement' ? 'selected' : '' }}>Supplements</option>
                                <option value="herbal" {{ request('category') == 'herbal' ? 'selected' : '' }}>Herbal</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Price Range</label>
                            <select class="form-select" name="price_range">
                                <option value="">All Prices</option>
                                <option value="0-50000" {{ request('price_range') == '0-50000' ? 'selected' : '' }}>Under Rp 50,000</option>
                                <option value="50000-100000" {{ request('price_range') == '50000-100000' ? 'selected' : '' }}>Rp 50,000 - 100,000</option>
                                <option value="100000-200000" {{ request('price_range') == '100000-200000' ? 'selected' : '' }}>Rp 100,000 - 200,000</option>
                                <option value="200000+" {{ request('price_range') == '200000+' ? 'selected' : '' }}>Above Rp 200,000</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri ri-search-line me-1"></i>Search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Medicine Catalog -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Medicine Catalog</h5>
                <a href="{{ route('customer.obat.index') }}" class="btn btn-outline-primary btn-sm">View All Products</a>
            </div>
            <div class="card-body">
                @if(isset($obatTerbaru) && $obatTerbaru->count() > 0)
                    <div class="row">
                        @foreach($obatTerbaru as $obat)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100 product-card">
                                <div class="card-img-top position-relative">
                                    @if($obat->gambar)
                                        <img src="{{ asset('storage/' . $obat->gambar) }}" class="img-fluid" alt="{{ $obat->nama_obat }}" style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="bx bx-capsule text-muted" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                    @if($obat->stok < 10)
                                        <span class="badge bg-warning position-absolute top-0 end-0 m-2">Low Stock</span>
                                    @endif
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title">{{ $obat->nama_obat }}</h6>
                                    <p class="text-muted small mb-2">{{ Str::limit($obat->deskripsi, 60) }}</p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-primary fw-bold">Rp {{ number_format($obat->harga, 0, ',', '.') }}</span>
                                            <small class="text-muted">Stock: {{ $obat->stok }}</small>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('customer.obat.show', $obat->id) }}" class="btn btn-outline-primary btn-sm">View Details</a>
                                            @if($obat->stok > 0)
                                                <button type="button" class="btn btn-primary btn-sm" onclick="addToCart({{ $obat->id }})">
                                                    <i class="bx bx-cart-add me-1"></i>Add to Cart
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                    Out of Stock
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bx bx-package text-muted" style="font-size: 4rem;"></i>
                        <h5 class="text-muted mt-3">No products available</h5>
                        <p class="text-muted">Please check back later for new products.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.product-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.card-img-top img {
    transition: transform 0.3s ease;
}

.product-card:hover .card-img-top img {
    transform: scale(1.05);
}
</style>
@endsection

@section('scripts')
<script>
function addToCart(obatId) {
    @auth
        // Add to cart logic here
        fetch(`/customer/cart/add/${obatId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                quantity: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                alert('Product added to cart successfully!');
            } else {
                alert('Failed to add product to cart.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding to cart.');
        });
    @else
        alert('Please sign in to add products to cart.');
        window.location.href = '{{ route("login") }}';
    @endauth
}
</script>
@endsection