<?php

include "../koneksi.php";
include "../auth/auth_check.php";
include "../auth/admin_check.php";
include "../config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = htmlspecialchars($_POST['judul']);
    $penulis = htmlspecialchars($_POST['penulis']);
    $harga = $_POST['harga'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $stok = $_POST['stok'];

    $stmt = $conn->prepare(
        "INSERT INTO buku (judul, penulis, harga, tahun_terbit, stok) 
        VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("ssiii", $judul, $penulis, $harga, $tahun_terbit, $stok);

    if ($stmt->execute()) {
        header("Location: " . BASE_URL . "/index.php?status=success&message=" . urlencode("Buku berhasil ditambahkan!"));
        exit();
    } else {
        header("Location: " . BASE_URL . "/index.php?status=error&message=" . urlencode("Gagal menambahkan buku: " . addslashes($stmt->error)));
        exit();
    }
}
