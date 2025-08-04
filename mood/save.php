<?php
// mood/save.php

// 1. Memanggil file koneksi database
include_once '../includes/db.php';

// 2. Memastikan request adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 3. Mengambil data dari form dengan aman
    $mood = mysqli_real_escape_string($conn, $_POST['mood']);
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);
    $tanggal = date("Y-m-d"); // Mengambil tanggal hari ini format YYYY-MM-DD

    // 4. Membuat query SQL untuk memasukkan data
    // Menggunakan prepared statement untuk keamanan dari SQL Injection
    $sql = "INSERT INTO moods (tanggal, mood, catatan) VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Binding parameter ke statement
        mysqli_stmt_bind_param($stmt, "sss", $tanggal, $mood, $catatan);

        // Eksekusi statement
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, arahkan kembali ke dashboard
            header("Location: ../dashboard.php?status=sukses");
        } else {
            // Jika gagal, tampilkan error
            echo "Error: " . mysqli_stmt_error($stmt);
        }

        // Tutup statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Tutup koneksi
    mysqli_close($conn);
} else {
    // Jika halaman diakses langsung, arahkan ke halaman form
    header("Location: add.php");
    exit();
}
