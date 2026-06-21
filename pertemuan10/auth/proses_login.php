<?php
session_start();

include "../koneksi.php";
include "../config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 1. Ambil data pengguna berdasarkan username (skema baru menggunakan kolom username)
    $stmt = $conn->prepare("SELECT id, username, password, role FROM pengguna WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    // 2. Validasi apakah username ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // 3. Verifikasi password bawaan database (Bcrypt/Laravel Hash kompatibel dengan password_verify)
        if (password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['login_Un51k4'] = true;
            $_SESSION['role'] = $row['role'];

            header("Location: " . BASE_URL . "/index.php");
            exit;
        } else {
            // Password salah
            header("Location: login.php?message=" . urlencode("Username atau password salah"));
            exit;
        }
    } else {
        // Username tidak ditemukan
        header("Location: login.php?message=" . urlencode("Username atau password salah"));
        exit;
    }

    $stmt->close();
}
