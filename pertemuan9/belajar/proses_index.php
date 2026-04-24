<?php

include "koneksi.php";

$limit = 5;

// halaman aktif
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// hitung offset
$offset = ($page - 1) * $limit;

// deklarasi variabel pencarian
$cari_judul = isset($_GET['judul']) ? $_GET['judul'] : '';
$cari_tahun = isset($_GET['tahun_terbit']) ? $_GET['tahun_terbit'] : '';

// filter
$filter = "";

if (!empty($cari_judul)) {
    $filter .= " AND judul LIKE '%" . $conn->real_escape_string($cari_judul) . "%'";
}
if (!empty($cari_tahun)) {
    $filter .= " AND tahun_terbit = '" . $conn->real_escape_string($cari_tahun) . "'";
}

// hitung total data
$countSql = "SELECT COUNT(*) as total FROM buku WHERE 1=1 $filter";
$countResult = $conn->query($countSql);
$totalData = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalData / $limit);

// ambil data
$sql = "SELECT * FROM buku WHERE 1=1 $filter LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
