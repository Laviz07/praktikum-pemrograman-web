<?php

include "koneksi.php";

// deklarasi variabel pencarian
$cari_judul = isset($_GET['judul']) ? $_GET['judul'] : '';
$cari_tahun = isset($_GET['tahun_terbit']) ? $_GET['tahun_terbit'] : '';

$sql = "SELECT * FROM buku WHERE 1=1";
if (!empty($cari_judul)) {
    $sql .= " AND judul LIKE '%" . $conn->real_escape_string($cari_judul) . "%'";
}
if (!empty($cari_tahun)) {
    $sql .= " AND tahun_terbit = '" . $conn->real_escape_string($cari_tahun) . "'";
}
$result = $conn->query($sql);
