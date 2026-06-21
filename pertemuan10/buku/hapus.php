<?php

include "../koneksi.php";
include "../auth/auth_check.php";
include "../auth/admin_check.php";
include "../config.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id = $_GET['id'];

    $stmt = $conn->prepare(
        "DELETE FROM buku 
        WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: " . BASE_URL . "/index.php?status=success&message=" . urlencode("Buku berhasil dihapus!"));
        exit();
    } else {
        header("Location: " . BASE_URL . "/index.php?status=error&message=" . urlencode("Gagal menghapus buku: " . addslashes($stmt->error)));
        exit();
    }

    $stmt->close();
} else {
    echo "ID buku tidak valid";
}

$conn->close();
