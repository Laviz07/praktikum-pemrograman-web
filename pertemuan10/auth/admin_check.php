<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pastikan sudah melewati auth_check.php terlebih dahulu sebelum memanggil file ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Tendang pengguna biasa ke index jika nekat mengakses halaman admin
    header("Location: " . BASE_URL . "/index.php?status=error&message=" . urlencode("Akses Ditolak!"));
    exit;
}
