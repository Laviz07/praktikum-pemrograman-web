<?php
include "koneksi.php";

$limit = 5;

// Tangkap halaman aktif dari URL parameter 'page'
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Hitung offset data
$offset = ($page - 1) * $limit;

// Deklarasi variabel pencarian dari input HTML Form (bisa berisi Judul atau Penulis)
$cari_judul = isset($_GET['judul']) ? trim($_GET['judul']) : '';
$cari_tahun = isset($_GET['tahun_terbit']) ? trim($_GET['tahun_terbit']) : '';

// Bangun klausa kondisi filter SQL
$filter = "";
if (!empty($cari_judul)) {
    $search_esc = $conn->real_escape_string($cari_judul);
    // MODIFIKASI DISINI: Ditambahkan kondisi OR untuk memeriksa kolom penulis
    $filter .= " AND (judul LIKE '%$search_esc%' OR penulis LIKE '%$search_esc%')";
}
if (!empty($cari_tahun)) {
    $filter .= " AND tahun_terbit = '" . $conn->real_escape_string($cari_tahun) . "'";
}

// 1. Hitung total data berdasarkan filter yang sedang dicari (Agar nominal pagination akurat)
$countSql = "SELECT COUNT(*) as total FROM buku WHERE 1=1 $filter";
$countResult = $conn->query($countSql);
$totalData = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalData / $limit);

// Jika halaman aktif yang diminta melebihi total halaman hasil filter, reset ke halaman terakhir
if ($page > $totalPages && $totalPages > 0) {
    $page = $totalPages;
    $offset = ($page - 1) * $limit;
}

// 2. Ambil data dengan batasan filter pencarian dan limit pagination pasar
$sql = "SELECT * FROM buku WHERE 1=1 $filter ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
