<?php

include "koneksi.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id = $_GET['id'];

    $stmt = $conn->prepare(
        "DELETE FROM buku 
        WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        // echo "<script>
        //     alert('Buku berhasil dihapus!');
        //     window.location.href='index.php';
        //   </script>";
        header("Location: index.php?status=success&message=" . urlencode("Buku berhasil dihapus!"));
        exit();
    } else {
        // echo "<script>
        //     alert('Gagal menghapus buku: " . addslashes($stmt->error) . "');
        //     window.location.href='index.php';
        //   </script>";
        header("Location: index.php?status=error&message=" . urlencode("Gagal menghapus buku: " . addslashes($stmt->error)));
        exit();
    }

    $stmt->close();
} else {
    echo "ID buku tidak valid";
}

$conn->close();
