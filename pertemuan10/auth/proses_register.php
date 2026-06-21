<?php
session_start();
include "../koneksi.php";
include "../config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil input dari form data diri
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $telepon = trim($_POST['telepon']);
    $alamat = trim($_POST['alamat']);

    // Ambil input dari data akun
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // 1. Cek apakah username sudah terpakai
    $check_stmt = $conn->prepare("SELECT id FROM pengguna WHERE username = ?");
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $check_stmt->close();
        header("Location: register.php?message=" . urlencode("Nama Pengguna sudah digunakan, silakan pilih yang lain!"));
        exit;
    }
    $check_stmt->close();

    // 2. Gunakan DB Transaction agar jika query kedua gagal, query pertama dibatalkan otomatis
    $conn->begin_transaction();

    try {
        // A. Masukkan ke dalam tabel pelanggan
        $stmt_pelanggan = $conn->prepare("INSERT INTO pelanggan (nama, alamat, email, telepon) VALUES (?, ?, ?, ?)");
        $stmt_pelanggan->bind_param("ssss", $nama, $alamat, $email, $telepon);
        $stmt_pelanggan->execute();

        // Ambil ID Pelanggan yang baru saja digenerate
        $pelanggan_id = $conn->insert_id;
        $stmt_pelanggan->close();

        // B. Amankan password menggunakan password_hash() (Bcrypt)
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // C. Masukkan ke dalam tabel pengguna
        $stmt_pengguna = $conn->prepare("INSERT INTO pengguna (pelanggan_id, username, password) VALUES (?, ?, ?)");
        $stmt_pengguna->bind_param("iss", $pelanggan_id, $username, $hashed_password);
        $stmt_pengguna->execute();
        $stmt_pengguna->close();

        // Jika kedua langkah berhasil, simpan permanen ke database
        $conn->commit();

        // Redirect ke halaman login dengan info sukses
        header("Location: login.php?message=" . urlencode("Registrasi berhasil! Silakan masuk menggunakan akun baru Anda."));
        exit;
    } catch (Exception $e) {
        // Jika ada kegagalan query, batalkan semua perubahan data (rollback)
        $conn->rollback();
        header("Location: register.php?message=" . urlencode("Terjadi kegagalan sistem. Gagal mendaftarkan akun baru."));
        exit;
    }
} else {
    // Jika diakses langsung tanpa POST, tendang balik ke halaman registrasi
    header("Location: register.php");
    exit;
}
