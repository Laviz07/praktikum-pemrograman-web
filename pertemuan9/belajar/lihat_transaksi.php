<?php

include "koneksi.php";
include "nav.php";

$sql = "
    SELECT pesanan.id as id, 
    pelanggan.nama as nama_pelanggan, 
    pesanan.tanggal_pesanan, 
    pesanan.total_harga,
    buku.judul,
    detail_pesanan.kuantitas,
    detail_pesanan.harga_per_satuan
    FROM pesanan
    JOIN pelanggan ON pesanan.pelanggan_id = pelanggan.id
    JOIN detail_pesanan ON pesanan.id = detail_pesanan.pesanan_id
    JOIN buku ON detail_pesanan.buku_id = buku.id
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Boostrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>Daftar Pesanan</title>
</head>

<body>
    <div class="container mt-4">
        <h2>Daftar Pesanan</h2>

        <!-- /* -------------------------- tabel daftar pesanan -------------------------- */ -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pesanan</th>
                    <th>Jumlah Pesanan</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td class="text-capitalize"><?= $row['nama_pelanggan'] ?></td>
                        <td class="text-capitalize"><?= $row['judul'] ?></td>
                        <td><?= date('d F Y', strtotime($row['tanggal_pesanan'])) ?></td>
                        <td><?= $row['kuantitas'] ?></td>
                        <td>Rp.<?= number_format($row['total_harga']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <!-- /* -------------------------- end of tabel daftar pesanan ---------------------- */ -->
    </div>
</body>

</html>