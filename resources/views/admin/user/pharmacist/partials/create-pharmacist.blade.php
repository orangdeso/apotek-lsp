<form action="{{ route('admin.pharmacists.store') }}" method="POST" id="createPharmacistForm" class="form-modern">
    @csrf
    
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
                        <label for="name" class="form-label">Full Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" 
                               placeholder="Masukkan nama lengkap" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="ri ri-information-line me-1"></i>
                            Contoh: Dr. Ahmad Susanto, Apt.
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address *</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="ri ri-mail-line"></i>
                            </span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="Masukkan alamat email" required>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="ri ri-information-line me-1"></i>
                            Email akan digunakan untuk login ke sistem
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="kota" class="form-label">City *</label>
                        <input type="text" class="form-control @error('kota') is-invalid @enderror" 
                               id="kota" name="kota" value="{{ old('kota') }}" 
                               placeholder="Masukkan nama kota" required>
                        @error('kota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="ri ri-map-pin-line me-1"></i>
                            Contoh: Jakarta, Surabaya, Bandung
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="telpon" class="form-label">Phone Number *</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="ri ri-phone-line"></i>
                            </span>
                            <input type="text" class="form-control @error('telpon') is-invalid @enderror" 
                                   id="telpon" name="telpon" value="{{ old('telpon') }}" 
                                   placeholder="Masukkan nomor telepon" required>
                        </div>
                        @error('telpon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="ri ri-information-line me-1"></i>
                            Contoh: 021-1234567, +62-21-1234567
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="col-md-6">
            <!-- Address & Security Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-info text-white">
                    <h6 class="mb-0">
                        <i class="ri ri-map-pin-line me-2"></i>
                        Address & Security
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Complete Address *</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="4" 
                                  placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="ri ri-information-line me-1"></i>
                            Alamat lengkap termasuk jalan, nomor, RT/RW, kelurahan
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password *</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="ri ri-lock-line"></i>
                            </span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" 
                                   placeholder="Masukkan password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="ri ri-eye-line"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="ri ri-information-line me-1"></i>
                            Minimum 8 karakter, kombinasi huruf dan angka
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password *</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="ri ri-lock-line"></i>
                            </span>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   id="password_confirmation" name="password_confirmation" 
                                   placeholder="Konfirmasi password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                <i class="ri ri-eye-line"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="ri ri-information-line me-1"></i>
                            Ulangi password yang sama dengan di atas
                        </div>
                    </div>
                    
                    <!-- Hidden role field -->
                    <input type="hidden" name="role" value="apoteker">
                </div>
            </div>
            
            <!-- Professional Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-success text-white">
                    <h6 class="mb-0">
                        <i class="ri ri-user-heart-line me-2"></i>
                        Professional Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="ri ri-information-line me-2"></i>
                        <div>
                            <strong>Role:</strong> Apoteker<br>
                            <small>Akun ini akan memiliki akses untuk mengelola obat, stok, dan melayani resep pelanggan.</small>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded">
                        <div>
                            <h6 class="mb-1">Permissions Included:</h6>
                            <ul class="list-unstyled mb-0 small text-muted">
                                <li><i class="ri ri-check-line text-success me-1"></i> Manage Drug Inventory</li>
                                <li><i class="ri ri-check-line text-success me-1"></i> Process Prescriptions</li>
                                <li><i class="ri ri-check-line text-success me-1"></i> View Sales Reports</li>
                                <li><i class="ri ri-check-line text-success me-1"></i> Stock Management</li>
                            </ul>
                        </div>
                        <div class="text-center">
                            <i class="ri ri-user-heart-line text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Submit Button -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Ready to Create Pharmacist Account?</h6>
                            <small class="text-muted">Make sure all information is correct before submitting</small>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.pharmacists.index') }}" class="btn btn-secondary">
                                <i class="ri ri-arrow-left-line me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="ri ri-save-line me-1"></i>Create Pharmacist
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    // Password toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            icon.className = type === 'password' ? 'ri ri-eye-line' : 'ri ri-eye-off-line';
        });
        
        // Toggle password confirmation visibility
        const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
        const passwordConfirmInput = document.getElementById('password_confirmation');
        
        togglePasswordConfirm.addEventListener('click', function() {
            const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmInput.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            icon.className = type === 'password' ? 'ri ri-eye-line' : 'ri ri-eye-off-line';
        });
    });
</script>