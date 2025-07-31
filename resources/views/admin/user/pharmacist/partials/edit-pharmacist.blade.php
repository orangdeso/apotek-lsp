<form action="{{ route('admin.pharmacists.update', $user->id) }}" method="POST" id="editPharmacistForm" class="form-modern">
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
                        <label for="name" class="form-label">Full Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $user->name) }}" 
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
                                   id="email" name="email" value="{{ old('email', $user->email) }}" 
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
                               id="kota" name="kota" value="{{ old('kota', $user->kota) }}" 
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
                                   id="telpon" name="telpon" value="{{ old('telpon', $user->telpon) }}" 
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
            <!-- Address Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-info text-white">
                    <h6 class="mb-0">
                        <i class="ri ri-map-pin-line me-2"></i>
                        Address Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Complete Address *</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="4" 
                                  placeholder="Masukkan alamat lengkap" required>{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="ri ri-information-line me-1"></i>
                            Alamat lengkap termasuk jalan, nomor, RT/RW, kelurahan
                        </div>
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
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="ri ri-information-line me-2"></i>
                        <div>
                            <small>Kosongkan field password jika tidak ingin mengubah password saat ini.</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="ri ri-lock-line"></i>
                            </span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" 
                                   placeholder="Masukkan password baru (opsional)">
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
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="ri ri-lock-line"></i>
                            </span>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   id="password_confirmation" name="password_confirmation" 
                                   placeholder="Konfirmasi password baru">
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
        </div>
    </div>
    
    <!-- Account Information -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-success text-white">
                    <h6 class="mb-0">
                        <i class="ri ri-user-heart-line me-2"></i>
                        Account Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="avatar avatar-sm me-3">
                                    <div class="avatar-initial bg-label-primary rounded-circle">
                                        <i class="ri ri-user-heart-line"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1">Role: Apoteker</h6>
                                    <small class="text-muted">Professional pharmacist account</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="avatar avatar-sm me-3">
                                    <div class="avatar-initial bg-label-success rounded-circle">
                                        <i class="ri ri-calendar-line"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1">Member Since</h6>
                                    <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <h6 class="mb-2">Permissions:</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled mb-0 small">
                                    <li class="mb-1"><i class="ri ri-check-line text-success me-1"></i> Manage Drug Inventory</li>
                                    <li class="mb-1"><i class="ri ri-check-line text-success me-1"></i> Process Prescriptions</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled mb-0 small">
                                    <li class="mb-1"><i class="ri ri-check-line text-success me-1"></i> View Sales Reports</li>
                                    <li class="mb-1"><i class="ri ri-check-line text-success me-1"></i> Stock Management</li>
                                </ul>
                            </div>
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
                            <h6 class="mb-1">Ready to Update Pharmacist Account?</h6>
                            <small class="text-muted">Make sure all information is correct before submitting</small>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.pharmacists.index') }}" class="btn btn-secondary">
                                <i class="ri ri-arrow-left-line me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="ri ri-save-line me-1"></i>Update Pharmacist
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>