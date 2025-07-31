@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-1">Edit Customer</h4>
            <p class="mb-0 text-muted">Perbarui informasi customer: {{ $customer->name }}</p>
        </div>
        <div>
            <a href="{{ route('admin.customers.index') }}" class="text-muted" data-bs-toggle="tooltip" title="Kembali">
                <i class="bx bx-arrow-back" style="font-size: 24px;"></i>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" class="form-modern">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <!-- Personal Information -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-gradient-primary text-white">
                                <h6 class="mb-0">
                                    <i class="ri ri-user-line me-2"></i>
                                    Personal Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ri ri-user-line"></i>
                                        </span>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $customer->name) }}" 
                                               placeholder="Masukkan nama lengkap" required>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ri ri-mail-line"></i>
                                        </span>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $customer->email) }}" 
                                               placeholder="customer@example.com" required>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Security Information -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-gradient-warning text-white">
                                <h6 class="mb-0">
                                    <i class="ri ri-lock-line me-2"></i>
                                    Security Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">
                                            <i class="ri ri-lock-line"></i>
                                        </span>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password" 
                                               placeholder="Kosongkan jika tidak ingin mengubah">
                                        <span class="input-group-text cursor-pointer" id="togglePassword">
                                            <i class="bx bx-hide"></i>
                                        </span>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password. Minimal 8 karakter jika diisi.</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">
                                            <i class="ri ri-lock-line"></i>
                                        </span>
                                        <input type="password" class="form-control" 
                                               id="password_confirmation" name="password_confirmation" 
                                               placeholder="Ulangi password baru">
                                        <span class="input-group-text cursor-pointer" id="togglePasswordConfirm">
                                            <i class="bx bx-hide"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="col-md-6">
                        <!-- Contact Information -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-gradient-info text-white">
                                <h6 class="mb-0">
                                    <i class="ri ri-phone-line me-2"></i>
                                    Contact Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="telpon" class="form-label">Nomor Telepon</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ri ri-phone-line"></i>
                                        </span>
                                        <input type="text" class="form-control @error('telpon') is-invalid @enderror" 
                                               id="telpon" name="telpon" value="{{ old('telpon', $customer->telpon) }}" 
                                               placeholder="08xxxxxxxxxx">
                                    </div>
                                    @error('telpon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="kota" class="form-label">Kota *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ri ri-map-pin-line"></i>
                                        </span>
                                        <input type="text" class="form-control @error('kota') is-invalid @enderror" 
                                               id="kota" name="kota" value="{{ old('kota', $customer->kota) }}" 
                                               placeholder="Masukkan nama kota" required>
                                    </div>
                                    @error('kota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Address Information -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-gradient-success text-white">
                                <h6 class="mb-0">
                                    <i class="ri ri-map-line me-2"></i>
                                    Address Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ri ri-map-line"></i>
                                        </span>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                                  id="alamat" name="alamat" rows="3" 
                                                  placeholder="Masukkan alamat lengkap">{{ old('alamat', $customer->alamat) }}</textarea>
                                    </div>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Status -->
                                <div class="mb-3">
                                    <label class="form-label">Status Akun</label>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-label-success me-2">
                                            <i class="bx bx-check-circle me-1"></i>Aktif
                                        </span>
                                        <small class="text-muted">Terdaftar sejak {{ $customer->created_at->format('d M Y') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        
                
                <!-- Info Box -->
                <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
                    <i class="bx bx-info-circle me-2"></i>
                    <div>
                        <strong>Perhatian:</strong>
                        <small>Perubahan email akan mempengaruhi login customer. Pastikan email yang dimasukkan valid dan dapat diakses.</small>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                        <i class="bx bx-x me-2"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bx bx-save me-2"></i>
                        Save Changes
                    </button>
                </div>
             </form>
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
    
    // Password confirmation validation
    $('#password, #password_confirmation').on('keyup', function() {
        const password = $('#password').val();
        const confirmPassword = $('#password_confirmation').val();
        
        if (password !== '' && confirmPassword !== '') {
            if (password !== confirmPassword) {
                $('#password_confirmation').addClass('is-invalid');
                if (!$('#password_confirmation').next('.invalid-feedback').length) {
                    $('#password_confirmation').after('<div class="invalid-feedback">Password tidak cocok</div>');
                }
            } else {
                $('#password_confirmation').removeClass('is-invalid');
                $('#password_confirmation').next('.invalid-feedback').remove();
            }
        }
    });
});
</script>
@endpush