<?php

include "koneksi.php";

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
        // echo "<script>
        //     alert('Buku berhasil ditambahkan!');
        //     window.location.href='index.php';
        //   </script>";
        header("Location: index.php?status=success&message=" . urlencode("Buku berhasil ditambahkan!"));
        exit();
    } else {
        // echo "<script>
        //     alert('Gagal menambahkan buku: " . addslashes($stmt->error) . "');
        //     window.location.href='index.php';
        //   </script>";
        header("Location: index.php?status=error&message=" . urlencode("Gagal menambahkan buku: " . addslashes($stmt->error)));
        exit();
    }

}
