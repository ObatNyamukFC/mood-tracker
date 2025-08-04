<?php
// dashboard.php

// Memanggil file-file yang dibutuhkan
include_once 'includes/db.php';
include_once 'includes/header.php';

// --- BAGIAN 1: Mengambil data untuk Chart ---
$sql_chart = "SELECT mood, COUNT(id) as jumlah FROM moods GROUP BY mood";
$result_chart = mysqli_query($conn, $sql_chart);

$labels = [];
$data = [];

if (mysqli_num_rows($result_chart) > 0) {
    while ($row = mysqli_fetch_assoc($result_chart)) {
        $labels[] = $row['mood'];
        $data[] = $row['jumlah'];
    }
}

// --- BAGIAN 2: Mengambil data untuk Tabel Riwayat ---
$sql_history = "SELECT id, tanggal, mood, catatan FROM moods ORDER BY tanggal DESC, id DESC";
$result_history = mysqli_query($conn, $sql_history);

?>

<!-- Tampilkan notifikasi jika ada -->
<?php if (isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> Mood harianmu sudah tersimpan.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>


<div class="row">
    <!-- Kolom untuk Grafik -->
    <div class="col-lg-5 mb-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Rekapitulasi Mood</h5>
            </div>
            <div class="card-body">
                <div style="height: 300px;">
                    <canvas id="moodChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom untuk Tabel Riwayat -->
    <div class="col-lg-7">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Riwayat Mood</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Mood</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result_history) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($result_history)): ?>
                                    <tr>
                                        <td><?php echo date("d M Y", strtotime($row['tanggal'])); ?></td>
                                        <td><?php echo htmlspecialchars($row['mood']); ?></td>
                                        <td><?php echo htmlspecialchars($row['catatan']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada data mood. <a href="mood/add.php">Tambah sekarang!</a></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk menginisialisasi Chart -->
<script>
    const ctx = document.getElementById('moodChart');

    // Mengambil data dari PHP dan mengubahnya menjadi format JavaScript
    const chartLabels = <?php echo json_encode($labels); ?>;
    const chartData = <?php echo json_encode($data); ?>;

    new Chart(ctx, {
        type: 'pie', // Tipe chart: pie, bar, line, doughnut
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Jumlah Hari',
                data: chartData,
                backgroundColor: [ // Warna untuk setiap bagian pie chart
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
</script>

<?php
// Menutup koneksi database
mysqli_close($conn);

// Memanggil footer
include_once 'includes/footer.php';
?>