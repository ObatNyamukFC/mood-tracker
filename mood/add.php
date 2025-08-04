<?php
// mood/add.php

// Memanggil header
include_once '../includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h4 class="mb-0">Bagaimana perasaanmu hari ini?</h4>
            </div>
            <div class="card-body">
                <!-- Form akan dikirim ke save.php menggunakan metode POST -->
                <form action="save.php" method="POST">
                    <div class="mb-3">
                        <label for="mood" class="form-label">Pilih Mood:</label>
                        <select class="form-select" id="mood" name="mood" required>
                            <option value="" disabled selected>-- Pilih perasaanmu --</option>
                            <option value="Senang">😊 Senang</option>
                            <option value="Biasa">😐 Biasa</option>
                            <option value="Sedih">😢 Sedih</option>
                            <option value="Marah">😠 Marah</option>
                            <option value="Produktif">🚀 Produktif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan (Opsional):</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3" placeholder="Tulis sedikit tentang harimu..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan Mood</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Memanggil footer
include_once '../includes/footer.php';
?>