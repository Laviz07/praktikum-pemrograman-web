<?php

include "koneksi.php";

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $judul = htmlspecialchars($_POST['judul']);
    $penulis = htmlspecialchars($_POST['penulis']);
    $harga = $_POST['harga'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $stok = $_POST['stok'];

    $stmt = $conn->prepare(
        "UPDATE buku 
        SET judul = ?, 
        penulis = ?, 
        harga = ?, 
        tahun_terbit = ?, 
        stok = ?
        WHERE id = ?"
    );
    $stmt->bind_param("ssiiii", $judul, $penulis, $harga, $tahun_terbit, $stok, $id);
    if ($stmt->execute()) {
        // echo "<script>
        //     alert('Buku berhasil diperbarui!');
        //     window.location.href='index.php';
        //   </script>"; 
        header("Location: index.php?status=success&message=" . urlencode("Buku berhasil diperbarui!"));
        exit();
    } else {
        // echo "<script>
        //     alert('Gagal memperbarui buku: " . addslashes($stmt->error) . "');
        //     window.location.href='index.php';
        //   </script>";
        header("Location: index.php?status=error&message=" . urlencode("Gagal memperbarui buku: " . $stmt->error));
        exit();
    }
}
