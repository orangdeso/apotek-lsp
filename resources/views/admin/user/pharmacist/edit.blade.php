@extends('layouts.app')

@section('title', 'Edit Pharmacist')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-6" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-sm-8">
                            <h4 class="card-title text-white mb-2">
                                <i class="ri ri-user-settings-line me-2"></i>Edit Pharmacist
                            </h4>
                            <p class="text-white-50 mb-0">Update informasi apoteker: {{ $user->name }}</p>
                        </div>
                        <div class="col-sm-4 text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.pharmacists.index') }}" class="btn btn-light btn-sm">
                                    <i class="ri ri-arrow-left-line me-1"></i>Back to All Pharmacists
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

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ri ri-error-warning-line me-2"></i>
            <strong>Validation Errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Edit Pharmacist Form -->
    @include('admin.user.pharmacist.partials.edit-pharmacist')
</div>
@endsection

@section('scripts')
<script>
    // Form validation and enhancement
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('#editPharmacistForm');
        const submitBtn = document.querySelector('#submitBtn');
        
        // Phone number formatting
        const phoneInput = document.querySelector('#telpon');
        phoneInput.addEventListener('input', function(e) {
            // Remove non-numeric characters except + and -
            let value = e.target.value.replace(/[^0-9+\-]/g, '');
            e.target.value = value;
        });
        
        // Email validation
        const emailInput = document.querySelector('#email');
        emailInput.addEventListener('blur', function(e) {
            const email = e.target.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                e.target.classList.add('is-invalid');
                let feedback = e.target.parentNode.querySelector('.invalid-feedback');
                if (!feedback) {
                    feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    e.target.parentNode.appendChild(feedback);
                }
                feedback.textContent = 'Format email tidak valid';
            } else {
                e.target.classList.remove('is-invalid');
            }
        });
        
        // Password confirmation validation
        const passwordInput = document.querySelector('#password');
        const confirmPasswordInput = document.querySelector('#password_confirmation');
        
        function validatePasswordConfirmation() {
            if (confirmPasswordInput.value && passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordInput.classList.add('is-invalid');
                let feedback = confirmPasswordInput.parentNode.querySelector('.invalid-feedback');
                if (!feedback) {
                    feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    confirmPasswordInput.parentNode.appendChild(feedback);
                }
                feedback.textContent = 'Konfirmasi password tidak cocok';
            } else {
                confirmPasswordInput.classList.remove('is-invalid');
            }
        }
        
        if (confirmPasswordInput) {
            confirmPasswordInput.addEventListener('input', validatePasswordConfirmation);
        }
        if (passwordInput) {
            passwordInput.addEventListener('input', validatePasswordConfirmation);
        }
        
        // Form submission handling
        form.addEventListener('submit', function(e) {
            // Disable submit button to prevent double submission
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="ri ri-loader-4-line me-1 spinner-border spinner-border-sm"></i>Updating...';
            
            // Re-enable button after 3 seconds (in case of error)
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="ri ri-save-line me-1"></i>Update Pharmacist';
            }, 3000);
        });
        
        // Auto-capitalize name
        const nameInput = document.querySelector('#name');
        nameInput.addEventListener('input', function(e) {
            // Capitalize first letter of each word
            let value = e.target.value;
            e.target.value = value.replace(/\b\w/g, l => l.toUpperCase());
        });
        
        // Auto-capitalize city
        const cityInput = document.querySelector('#kota');
        cityInput.addEventListener('input', function(e) {
            // Capitalize first letter of each word
            let value = e.target.value;
            e.target.value = value.replace(/\b\w/g, l => l.toUpperCase());
        });
        
        // Password toggle functionality
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        
        if (togglePassword && passwordField) {
            togglePassword.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                
                const icon = this.querySelector('i');
                icon.className = type === 'password' ? 'ri ri-eye-line' : 'ri ri-eye-off-line';
            });
        }
        
        // Toggle password confirmation visibility
        const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
        const passwordConfirmField = document.getElementById('password_confirmation');
        
        if (togglePasswordConfirm && passwordConfirmField) {
            togglePasswordConfirm.addEventListener('click', function() {
                const type = passwordConfirmField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmField.setAttribute('type', type);
                
                const icon = this.querySelector('i');
                icon.className = type === 'password' ? 'ri ri-eye-line' : 'ri ri-eye-off-line';
            });
        }
    });
</script>
@endsection