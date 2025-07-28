<form action="{{ route('pharmacist.obat.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <!-- Form fields lainnya -->
    
    <div class="mb-3">
        <label for="image" class="form-label">Gambar Obat</label>
        <input type="file" class="form-control @error('image') is-invalid @enderror" 
               id="image" name="image" accept="image/*">
        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB.</div>
    </div>
    
    <!-- Preview gambar -->
    <div class="mb-3">
        <img id="imagePreview" src="#" alt="Preview" 
             style="display: none; max-width: 200px; height: auto;" class="img-thumbnail">
    </div>
    
    <button type="submit" class="btn btn-primary">Simpan Obat</button>
</form>

<script>
// Preview gambar sebelum upload
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script>