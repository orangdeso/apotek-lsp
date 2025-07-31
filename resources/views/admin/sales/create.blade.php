@extends('layouts.app')

@section('title', 'New Sale - Admin')

@section('content')
<div class="flex-grow-1">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Sales Management /</span> New Sale
            </h4>
            <p class="text-muted mb-0">Create a new sales transaction</p>
        </div>
        <div>
            <a href="{{ route('admin.sales.index') }}" class="btn btn-outline-secondary">
                <i class="ri-arrow-left-line me-1"></i>
                Back to Sales
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Sale Form -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-shopping-cart-line me-2"></i>
                        Sale Transaction
                    </h5>
                </div>
                <div class="card-body">
                    <form id="saleForm">
                        @csrf
                        
                        <!-- Customer Selection -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="customer" class="form-label">Customer *</label>
                                <select class="form-select" id="customer" name="id_user" required>
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="payment_method" class="form-label">Payment Method *</label>
                                <select class="form-select" id="payment_method" name="payment_method" required>
                                    <option value="">Select Payment Method</option>
                                    <option value="cash">Cash</option>
                                    <option value="transfer">Bank Transfer</option>
                                    <option value="card">Credit/Debit Card</option>
                                </select>
                            </div>
                        </div>

                        <!-- Add Products -->
                        <div class="card border mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Search & Add Products</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="product_search" class="form-label">Search Product (Code, Name, or ID)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ri-search-line"></i></span>
                                        <input type="text" class="form-control" id="product_search" 
                                               placeholder="Type product code, name, or ID to search..." 
                                               autocomplete="off">
                                    </div>
                                    <!-- Search Results Dropdown -->
                                    <div class="search-results" id="searchResults" style="display: none;">
                                        <div class="list-group mt-2 shadow-sm" style="max-height: 300px; overflow-y: auto;">
                                            <!-- Results will be populated here -->
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Selected Product</label>
                                    <div class="selected-product-info" id="selectedProductInfo">
                                        <div class="alert alert-light text-muted text-center py-3">
                                            <i class="ri-package-line me-2"></i>
                                            No product selected
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sale Items -->
                        <div class="card border mb-4">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Sale Items</h6>
                                <small class="text-muted">Click on selected product to add with quantity</small>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm" id="saleItemsTable">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th width="120px">Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Subtotal</th>
                                                <th width="80px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="saleItemsBody">
                                            <tr id="emptyRow">
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    <i class="ri-shopping-cart-line me-2"></i>
                                                    No items added yet
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label for="notes" class="form-label">Notes (Optional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Additional notes for this sale..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">Reset</button>
                            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                <i class="ri-save-line me-1"></i>
                                Complete Sale
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sale Summary -->
        <div class="col-lg-4">
            <div class="card sticky-top">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-calculator-line me-2"></i>
                        Sale Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Items:</span>
                        <span id="totalItems">0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Quantity:</span>
                        <span id="totalQuantity">0</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Total Amount:</span>
                        <span class="fw-bold text-success" id="totalAmount">Rp 0</span>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="ri-information-line me-2"></i>
                        <small>This transaction will be marked as completed immediately after creation.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product Search Modal -->
<div class="modal fade" id="productSearchModal" tabindex="-1" aria-labelledby="productSearchModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productSearchModalLabel">
                    <i class="ri-search-line me-2"></i>Search Products
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="modal_search_input" class="form-label">Search by Product Name or Code</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="modal_search_input" placeholder="Type product name or code...">
                            <button type="button" class="btn btn-primary" id="modalSearchBtn">
                                Search
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="productsTable">
                        <thead class="table-light">
                            <tr>
                                <th>Code</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="productsTableBody">
                            <!-- Products will be loaded here -->
                        </tbody>
                    </table>
                </div>
                <div id="noProductsMessage" class="text-center text-muted py-4" style="display: none;">
                    <i class="ri-inbox-line fs-1"></i>
                    <p class="mt-2">No products found</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
#productsTable tbody tr {
    cursor: pointer;
}

#productsTable tbody tr:hover {
    background-color: #f8f9fa;
}

.product-code {
    font-family: 'Courier New', monospace;
    font-weight: bold;
    color: #6c757d;
}

/* Fix for modal accessibility issues */
#productSearchModal.modal.fade:not(.show) {
    display: none !important;
}

#productSearchModal.modal.show {
    display: block !important;
}

.product-price {
    color: #28a745;
    font-weight: bold;
}

.product-stock {
    color: #17a2b8;
}

.stock-low {
    color: #dc3545 !important;
}
</style>
@endpush

@push('scripts')
<script>
let saleItems = [];
let itemCounter = 0;
let selectedProduct = null;

const productSelect = document.getElementById('product_select');
const selectedProductId = document.getElementById('selected_product_id');
const priceInput = document.getElementById('price_input');
const quantityInput = document.getElementById('quantity_input');
const modalSearchInput = document.getElementById('modal_search_input');
const productsTableBody = document.getElementById('productsTableBody');
const noProductsMessage = document.getElementById('noProductsMessage');

// Debug: Check if elements are found
console.log('DOM Elements Check:');
console.log('modalSearchInput:', modalSearchInput);
console.log('productsTableBody:', productsTableBody);
console.log('noProductsMessage:', noProductsMessage);
console.log('productSearchModal:', document.getElementById('productSearchModal'));

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Initially disable quantity and price inputs
    quantityInput.disabled = true;
    priceInput.disabled = true;
    
    // Load all products in modal when it opens
    document.getElementById('productSearchModal').addEventListener('shown.bs.modal', function() {
        console.log('Modal opened, loading all products...');
        loadAllProducts();
        // Focus on search input when modal opens
        setTimeout(() => {
            modalSearchInput.focus();
        }, 150);
    });
    
    // Handle modal hide event
    document.getElementById('productSearchModal').addEventListener('hidden.bs.modal', function() {
        console.log('Modal closed');
        // Clear search input when modal closes
        modalSearchInput.value = '';
        // Clear products table
        productsTableBody.innerHTML = '';
        noProductsMessage.style.display = 'none';
    });
    
    // Handle modal show event (before shown)
    document.getElementById('productSearchModal').addEventListener('show.bs.modal', function() {
        console.log('Modal is about to show');
        // Ensure modal is properly visible for screen readers
        this.removeAttribute('aria-hidden');
    });
    
    // Handle modal hide event (before hidden)
    document.getElementById('productSearchModal').addEventListener('hide.bs.modal', function() {
        console.log('Modal is about to hide');
        // Don't set aria-hidden to avoid accessibility issues
    });
    
    // Search functionality in modal
    modalSearchInput.addEventListener('input', function() {
        console.log('Modal search input changed');
        const query = this.value.trim();
        console.log('Input query:', query);
        if (query.length >= 2) {
            searchProductsInModal(query);
        } else {
            loadAllProducts();
        }
    });
    
    // Search button functionality in modal
    document.getElementById('modalSearchBtn').addEventListener('click', function() {
        console.log('Modal search button clicked');
        const query = modalSearchInput.value.trim();
        console.log('Search query:', query);
        if (query.length > 0) {
            searchProductsInModal(query);
        } else {
            loadAllProducts();
        }
    });
    
    // Enter key functionality in modal search
    modalSearchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const query = this.value.trim();
            if (query.length > 0) {
                searchProductsInModal(query);
            } else {
                loadAllProducts();
            }
        }
    });
    
    // Product selection from dropdown
    productSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            selectProductFromDropdown(selectedOption);
        } else {
            clearProductSelection();
        }
    });
});

// Load all products in modal
function loadAllProducts() {
    console.log('Loading all products...');
    
    fetch('{{ route("admin.sales.search.products") }}?q=', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Products loaded:', data);
        displayProductsInModal(data);
    })
    .catch(error => {
        console.error('Error loading products:', error);
        // Tampilkan pesan error ke user
        productsTableBody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Error loading products: ' + error.message + '</td></tr>';
    });
}

// Search products in modal
function searchProductsInModal(query) {
    console.log('Searching products with query:', query);
    
    fetch(`{{ route("admin.sales.search.products") }}?q=${encodeURIComponent(query)}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Search response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Search results:', data);
        displayProductsInModal(data);
    })
    .catch(error => {
        console.error('Error searching products:', error);
        productsTableBody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Error searching products: ' + error.message + '</td></tr>';
    });
}

// Display products in modal table
function displayProductsInModal(products) {
    console.log('Displaying products in modal:', products);
    productsTableBody.innerHTML = '';
    
    if (products.length === 0) {
        console.log('No products found, showing no products message');
        document.getElementById('productsTable').style.display = 'none';
        noProductsMessage.style.display = 'block';
        return;
    }
    
    console.log('Found', products.length, 'products, displaying table');
    document.getElementById('productsTable').style.display = 'table';
    noProductsMessage.style.display = 'none';
    
    products.forEach(product => {
        const row = document.createElement('tr');
        const stockClass = product.stok <= 10 ? 'stock-low' : 'product-stock';
        
        row.innerHTML = `
            <td><span class="product-code">${product.kode_obat}</span></td>
            <td>${product.name_obat}</td>
            <td><span class="product-price">Rp ${parseFloat(product.harga_jual).toLocaleString('id-ID')}</span></td>
            <td><span class="${stockClass}">${product.stok}</span></td>
            <td>
                <button type="button" class="btn btn-sm btn-primary" onclick="selectProductFromModal(${product.id}, '${product.kode_obat}', '${product.name_obat}', ${product.harga_jual}, ${product.stok})">
                    <i class="ri-check-line"></i> Select
                </button>
            </td>
        `;
        
        productsTableBody.appendChild(row);
    });
}

// Select product from modal
function selectProductFromModal(id, code, name, price, stock) {
    // Set dropdown value
    productSelect.value = id;
    
    // Set selected product data
    selectedProduct = {
        id: id,
        kode_obat: code,
        name_obat: name,
        harga_jual: price,
        stok: stock
    };
    
    // Fill form fields
    selectedProductId.value = id;
    priceInput.value = price;
    
    // Enable inputs
    quantityInput.disabled = false;
    priceInput.disabled = false;
    
    // Set max quantity
    quantityInput.max = stock;
    
    // Close modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('productSearchModal'));
    modal.hide();
    
    // Focus on quantity input
    setTimeout(() => {
        quantityInput.focus();
    }, 300);
}

// Select product from dropdown
function selectProductFromDropdown(option) {
    selectedProduct = {
        id: option.value,
        kode_obat: option.dataset.code,
        name_obat: option.dataset.name,
        harga_jual: parseFloat(option.dataset.price),
        stok: parseInt(option.dataset.stock)
    };
    
    selectedProductId.value = option.value;
    priceInput.value = option.dataset.price;
    
    // Enable inputs
    quantityInput.disabled = false;
    priceInput.disabled = false;
    
    // Set max quantity
    quantityInput.max = option.dataset.stock;
}

// Clear product selection
function clearProductSelection() {
    selectedProduct = null;
    selectedProductId.value = '';
    priceInput.value = '';
    quantityInput.value = '';
    
    // Disable inputs
    quantityInput.disabled = true;
    priceInput.disabled = true;
    
    // Remove max quantity
    quantityInput.removeAttribute('max');
}

// Add product to sale
document.getElementById('addProductBtn').addEventListener('click', function() {
    const quantity = parseInt(quantityInput.value);
    const price = parseFloat(priceInput.value);
    
    if (!selectedProduct || !quantity || !price) {
        alert('Please select a product and fill all fields');
        return;
    }
    
    if (quantity > selectedProduct.stok) {
        alert(`Insufficient stock. Available: ${selectedProduct.stok}`);
        return;
    }
    
    // Check if product already exists
    const existingIndex = saleItems.findIndex(item => item.id_obat === selectedProduct.id);
    if (existingIndex !== -1) {
        alert('Product already added. Please remove it first if you want to change quantity.');
        return;
    }
    
    const subtotal = quantity * price;
    const item = {
        id_obat: selectedProduct.id,
        name: selectedProduct.name_obat,
        quantity: quantity,
        unit_price: price,
        subtotal: subtotal
    };
    
    saleItems.push(item);
    updateSaleItemsTable();
    updateSummary();
    
    // Reset form
    productSelect.value = '';
    selectedProductId.value = '';
    selectedProduct = null;
    quantityInput.value = '';
    priceInput.value = '';
    quantityInput.max = '';
    
    // Disable inputs
    quantityInput.disabled = true;
    priceInput.disabled = true;
});

// Update sale items table with editable quantity
function updateSaleItemsTable() {
    const tbody = document.getElementById('saleItemsBody');
    const emptyRow = document.getElementById('emptyRow');
    
    if (saleItems.length === 0) {
        emptyRow.style.display = '';
        return;
    }
    
    emptyRow.style.display = 'none';
    
    const itemsHtml = saleItems.map((item, index) => `
        <tr>
            <td>
                <div>
                    <strong>${item.name}</strong><br>
                    <small class="text-muted">Stock: ${item.max_stock}</small>
                </div>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm" 
                       value="${item.quantity}" 
                       min="1" 
                       max="${item.max_stock}"
                       onchange="updateItemQuantity(${index}, this.value)">
            </td>
            <td>Rp ${formatNumber(item.unit_price)}</td>
             <td>Rp ${formatNumber(item.subtotal)}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" 
                        onclick="removeItem(${index})">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </td>
        </tr>
    `).join('');
    
    tbody.innerHTML = itemsHtml + emptyRow.outerHTML;
}

// Remove item (moved to avoid duplication)
// function removeItem(index) {
//     saleItems.splice(index, 1);
//     updateSaleItemsTable();
//     updateSummary();
// }

// Update summary
function updateSummary() {
    const totalItems = saleItems.length;
    const totalQuantity = saleItems.reduce((sum, item) => sum + item.quantity, 0);
    const totalAmount = saleItems.reduce((sum, item) => sum + item.subtotal, 0);
    
    document.getElementById('totalItems').textContent = totalItems;
    document.getElementById('totalQuantity').textContent = totalQuantity;
    document.getElementById('totalAmount').textContent = 'Rp ' + formatNumber(totalAmount);
    
    // Enable/disable submit button
    const submitBtn = document.getElementById('submitBtn');
    const customer = document.getElementById('customer').value;
    const paymentMethod = document.getElementById('payment_method').value;
    
    submitBtn.disabled = !(totalItems > 0 && customer && paymentMethod);
}

// Form validation
document.getElementById('customer').addEventListener('change', updateSummary);
document.getElementById('payment_method').addEventListener('change', updateSummary);

// Submit form
document.getElementById('saleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (saleItems.length === 0) {
        alert('Please add at least one item to the sale');
        return;
    }
    
    // Validate all items have valid quantities
    for (let i = 0; i < saleItems.length; i++) {
        const item = saleItems[i];
        if (!item.quantity || item.quantity < 1) {
            alert(`Invalid quantity for ${item.name}`);
            return;
        }
        if (item.quantity > item.max_stock) {
            alert(`Quantity for ${item.name} exceeds available stock (${item.max_stock})`);
            return;
        }
    }
    
    // Validate form data
    const customerId = document.getElementById('customer').value;
    const paymentMethod = document.getElementById('payment_method').value;
    
    if (!customerId) {
        alert('Please select a customer');
        return;
    }
    
    if (!paymentMethod) {
        alert('Please select a payment method');
        return;
    }
    
    // Prepare form data with proper structure for backend
    const formData = {
        id_user: parseInt(customerId),
        payment_method: paymentMethod,
        notes: document.getElementById('notes').value || '',
        items: saleItems.map(item => ({
            id_obat: item.id_obat,
            quantity: parseInt(item.quantity),
            unit_price: parseFloat(item.unit_price)
        }))
    };
    
    console.log('Submitting form data:', formData);
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="ri-loader-4-line me-1 spinner-border spinner-border-sm"></i> Processing...';
    
    fetch('{{ route("admin.sales.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(formData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Sale created successfully!');
            window.location.href = data.redirect;
        } else {
            // Handle validation errors
            if (data.errors) {
                let errorMessage = 'Validation errors:\n';
                Object.keys(data.errors).forEach(key => {
                    errorMessage += `- ${data.errors[key].join(', ')}\n`;
                });
                alert(errorMessage);
            } else {
                alert(data.message || 'An error occurred');
            }
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="ri-save-line me-1"></i> Complete Sale';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while processing the sale: ' + error.message);
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="ri-save-line me-1"></i> Complete Sale';
    });
});

// Reset form
function resetForm() {
    if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
        saleItems = [];
        document.getElementById('saleForm').reset();
        updateSaleItemsTable();
        updateSummary();
    }
}

// Number formatting helper
function numberFormat(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

// Global format number function
function formatNumber(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}
</script>
@endpush

<style>
.search-results {
    position: relative;
    z-index: 1000;
}

.product-item:hover {
    background-color: #f8f9fa;
}

.selected-product-info .alert {
    margin-bottom: 0;
}

#saleItemsTable input[type="number"] {
    width: 80px;
}
</style>

<script>
let searchTimeout;

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', function() {
    const productSearchInput = document.getElementById('product_search');
    const searchResults = document.getElementById('searchResults');
    const selectedProductInfo = document.getElementById('selectedProductInfo');
    
    if (!productSearchInput || !searchResults || !selectedProductInfo) {
        console.error('Required elements not found');
        return;
    }



    // Hide search results when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#product_search') && !e.target.closest('#searchResults')) {
            hideSearchResults();
        }
    });
    
    // Real-time search
    productSearchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        clearTimeout(searchTimeout);
        
        if (query.length < 2) {
            hideSearchResults();
            return;
        }
        
        searchTimeout = setTimeout(() => {
            searchProducts(query);
        }, 300);
    });
    
    // Search products function
    function searchProducts(query) {
        fetch(`{{ route('admin.sales.search.products') }}?q=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                displaySearchResults(data);
            })
            .catch(error => {
                console.error('Search error:', error);
                const resultsContainer = searchResults.querySelector('.list-group');
                resultsContainer.innerHTML = `
                    <div class="list-group-item text-center text-danger py-3">
                        <i class="ri-error-warning-line me-2"></i>
                        Error searching products
                    </div>
                `;
                searchResults.style.display = 'block';
            });
    }
    
    // Display search results
    function displaySearchResults(products) {
        const resultsContainer = searchResults.querySelector('.list-group');
        
        if (products.length === 0) {
            resultsContainer.innerHTML = `
                <div class="list-group-item text-center text-muted py-3">
                    <i class="ri-search-line me-2"></i>
                    No products found
                </div>
            `;
        } else {
            resultsContainer.innerHTML = products.map(product => `
                <div class="list-group-item list-group-item-action product-item" 
                     data-product='${JSON.stringify(product)}'
                     style="cursor: pointer;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">${product.name_obat}</h6>
                            <small class="text-muted">Code: ${product.kode_obat} | Stock: ${product.stok}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary">Rp ${formatNumber(product.harga_jual)}</span>
                        </div>
                    </div>
                </div>
            `).join('');
            
            // Add click handlers
            resultsContainer.querySelectorAll('.product-item').forEach(item => {
                item.addEventListener('click', function() {
                    const product = JSON.parse(this.dataset.product);
                    selectProduct(product);
                });
            });
        }
        
        searchResults.style.display = 'block';
    }
    
    // Select product
    function selectProduct(product) {
        selectedProduct = product;
        
        // Update selected product info
        selectedProductInfo.innerHTML = `
            <div class="alert alert-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">${product.name_obat}</h6>
                        <small>Code: ${product.kode_obat} | Stock: ${product.stok} | Price: Rp ${formatNumber(product.harga_jual)}</small>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" onclick="addToSaleItems()">
                        <i class="ri-add-line"></i> Add to Sale
                    </button>
                </div>
            </div>
        `;
        
        hideSearchResults();
        productSearchInput.value = `${product.kode_obat} - ${product.name_obat}`;
    }
    
    // Helper functions
    function hideSearchResults() {
        searchResults.style.display = 'none';
    }
    
    function resetProductSelection() {
        selectedProduct = null;
        productSearchInput.value = '';
        selectedProductInfo.innerHTML = `
            <div class="alert alert-light text-muted text-center py-3">
                <i class="ri-package-line me-2"></i>
                No product selected
            </div>
        `;
    }
    
    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }
    
    // Add to sale items with quantity input
    function addToSaleItems() {
        if (!selectedProduct) {
            alert('Please select a product first.');
            return;
        }
        
        // Check if product already exists
        const existingIndex = saleItems.findIndex(item => item.id_obat === selectedProduct.id);
        if (existingIndex !== -1) {
            alert('Product already added. You can modify quantity in the sale items table.');
            return;
        }
        
        // Add item with default quantity 1
        const item = {
            id_obat: selectedProduct.id,
            name: selectedProduct.name_obat,
            quantity: 1,
            unit_price: selectedProduct.harga_jual,
            subtotal: selectedProduct.harga_jual,
            max_stock: selectedProduct.stok
        };
        
        saleItems.push(item);
        updateSaleItemsTable();
        updateSummary();
        
        // Reset selection
        resetProductSelection();
    }
    
    // Remove item from sale
    function removeItem(index) {
        if (confirm('Are you sure you want to remove this item?')) {
            saleItems.splice(index, 1);
            updateSaleItemsTable();
            updateSummary();
        }
    }
    
    // Update item quantity
    function updateItemQuantity(index, newQuantity) {
        const quantity = parseInt(newQuantity);
        const item = saleItems[index];
        
        if (quantity > item.max_stock) {
            alert(`Maximum quantity is ${item.max_stock}`);
            updateSaleItemsTable();
            return;
        }
        
        if (quantity < 1) {
            alert('Minimum quantity is 1');
            updateSaleItemsTable();
            return;
        }
        
        item.quantity = quantity;
        item.subtotal = quantity * item.unit_price;
        
        
        updateSaleItemsTable();
        updateSummary();
    }
    
    // Make functions globally available
    window.addToSaleItems = addToSaleItems;
    window.removeItem = removeItem;
    window.updateItemQuantity = updateItemQuantity;
    window.resetProductSelection = resetProductSelection;
    window.hideSearchResults = hideSearchResults;
});


</script>
@endsection