@extends('layouts.app')

@section('title', 'Tambah Customer')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-1">Tambah Customer Baru</h4>
            <p class="mb-0 text-muted">Tambahkan pelanggan baru ke sistem</p>
        </div>
        <div>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Customer</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.customers.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <!-- Nama Lengkap -->
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" 
                                       placeholder="Masukkan nama lengkap" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Email -->
                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" 
                                       placeholder="customer@example.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- Password -->
                            <div class="col-md-6 mb-4">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" 
                                           placeholder="Masukkan password" required>
                                    <span class="input-group-text cursor-pointer" id="togglePassword">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Minimal 8 karakter</small>
                            </div>
                            
                            <!-- Konfirmasi Password -->
                            <div class="col-md-6 mb-4">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" 
                                           placeholder="Ulangi password" required>
                                    <span class="input-group-text cursor-pointer" id="togglePasswordConfirm">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- Nomor Telepon -->
                            <div class="col-md-6 mb-4">
                                <label for="telpon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('telpon') is-invalid @enderror" 
                                       id="telpon" name="telpon" value="{{ old('telpon') }}" 
                                       placeholder="08xxxxxxxxxx" required>
                                @error('telpon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Kota -->
                            <div class="col-md-6 mb-4">
                                <label for="kota" class="form-label">Kota <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kota') is-invalid @enderror" 
                                       id="kota" name="kota" value="{{ old('kota') }}" 
                                       placeholder="Masukkan nama kota" required>
                                @error('kota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Alamat -->
                        <div class="mb-4">
                            <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="3" 
                                      placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Info Box -->
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="bx bx-info-circle me-2"></i>
                            <div>
                                <strong>Informasi:</strong>
                                <small>Customer yang dibuat akan memiliki akses untuk berbelanja obat melalui sistem online.</small>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-x me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-2"></i>Simpan Customer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Toggle password visibility
    $('#togglePassword').on('click', function() {
        const passwordField = $('#password');
        const icon = $(this).find('i');
        
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('bx-hide').addClass('bx-show');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('bx-show').addClass('bx-hide');
        }
    });
    
    $('#togglePasswordConfirm').on('click', function() {
        const passwordField = $('#password_confirmation');
        const icon = $(this).find('i');
        
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('bx-hide').addClass('bx-show');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('bx-show').addClass('bx-hide');
        }
    });
    
    // Phone number formatting
    $('#telpon').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 0 && !value.startsWith('0')) {
            value = '0' + value;
        }
        $(this).val(value);
    });
    
    // Real-time validation
    function validateField(field, rules) {
        const value = field.val().trim();
        const fieldName = field.attr('name');
        let isValid = true;
        let errorMessage = '';
        
        // Check if required
        if (rules.required && value === '') {
            isValid = false;
            errorMessage = 'Field ini wajib diisi';
        }
        
        // Check email format
        if (fieldName === 'email' && value !== '') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Format email tidak valid';
            }
        }
        
        // Check password length
        if (fieldName === 'password' && value !== '' && value.length < 8) {
            isValid = false;
            errorMessage = 'Password minimal 8 karakter';
        }
        
        // Check password confirmation
        if (fieldName === 'password_confirmation' && value !== '') {
            const password = $('#password').val();
            if (value !== password) {
                isValid = false;
                errorMessage = 'Konfirmasi password tidak cocok';
            }
        }
        
        // Check phone number format
        if (fieldName === 'telpon' && value !== '') {
            const phoneRegex = /^0[0-9]{9,13}$/;
            if (!phoneRegex.test(value)) {
                isValid = false;
                errorMessage = 'Nomor telepon harus dimulai dengan 0 dan terdiri dari 10-14 digit';
            }
        }
        
        // Check address length
        if (fieldName === 'alamat' && value !== '') {
            if (value.length < 10) {
                isValid = false;
                errorMessage = 'Alamat minimal 10 karakter';
            } else if (value.length > 255) {
                isValid = false;
                errorMessage = 'Alamat maksimal 255 karakter';
            }
        }
        
        // Update field appearance
        if (isValid) {
            field.removeClass('is-invalid').addClass('is-valid');
            field.siblings('.invalid-feedback').hide();
        } else {
            field.removeClass('is-valid').addClass('is-invalid');
            let feedback = field.siblings('.invalid-feedback');
            if (feedback.length === 0) {
                feedback = $('<div class="invalid-feedback"></div>');
                field.after(feedback);
            }
            feedback.text(errorMessage).show();
        }
        
        return isValid;
    }
    
    // Validate required fields on blur
    $('#name').on('blur', function() {
        validateField($(this), {required: true});
    });
    
    $('#email').on('blur', function() {
        validateField($(this), {required: true});
    });
    
    $('#password').on('blur', function() {
        validateField($(this), {required: true});
        // Also validate confirmation if it has value
        const confirmField = $('#password_confirmation');
        if (confirmField.val() !== '') {
            validateField(confirmField, {required: true});
        }
    });
    
    $('#password_confirmation').on('blur', function() {
        validateField($(this), {required: true});
    });
    
    $('#kota').on('blur', function() {
        validateField($(this), {required: true});
    });
    
    // Validate phone number on blur
    $('#telpon').on('blur', function() {
        validateField($(this), {required: true});
    });
    
    // Validate address on blur
    $('#alamat').on('blur', function() {
        validateField($(this), {required: true});
    });
    
    // Form submission validation
    $('form').on('submit', function(e) {
        let isFormValid = true;
        
        // Validate all required fields
        const requiredFields = ['name', 'email', 'password', 'password_confirmation', 'kota', 'telpon', 'alamat'];
        
        requiredFields.forEach(function(fieldName) {
            const field = $('#' + fieldName);
            const isValid = validateField(field, {required: true});
            if (!isValid) {
                isFormValid = false;
            }
        });
        
        // Check if passwords match
        const password = $('#password').val();
        const passwordConfirm = $('#password_confirmation').val();
        if (password !== passwordConfirm) {
            isFormValid = false;
            const confirmField = $('#password_confirmation');
            confirmField.removeClass('is-valid').addClass('is-invalid');
            let feedback = confirmField.siblings('.invalid-feedback');
            if (feedback.length === 0) {
                feedback = $('<div class="invalid-feedback"></div>');
                confirmField.after(feedback);
            }
            feedback.text('Konfirmasi password tidak cocok').show();
        }
        
        if (!isFormValid) {
            e.preventDefault();
            
            // Show alert
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: 'Mohon lengkapi semua field yang wajib diisi dengan benar',
                confirmButtonText: 'OK'
            });
            
            // Focus on first invalid field
            $('.is-invalid').first().focus();
        }
    });
    
    // Remove validation classes on input
    $('input, textarea').on('input', function() {
        $(this).removeClass('is-invalid is-valid');
        $(this).siblings('.invalid-feedback').hide();
    });
});
</script>
@endpush