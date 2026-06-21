<?php
include "../auth/auth_check.php";
include "../auth/admin_check.php";

$page_active = 'tambah';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Tambah Buku - Laviz Book Store</title>
</head>

<body class="bg-light">
    <?php include "../include/nav.php" ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-sm-5">

                        <div class="d-flex align-items-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-3 me-3" style="width: 45px; height: 45px;">
                                <i class="bi bi-journal-plus fs-4"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold text-dark mb-0">Tambah Buku Baru</h4>
                                <p class="text-muted small mb-0">Isi kelengkapan data di bawah untuk menambah stok buku baru.</p>
                            </div>
                        </div>

                        <form method="POST" action="proses_tambah.php">

                            <div class="mb-3">
                                <label for="judul" class="form-label text-secondary small fw-semibold">Judul Buku</label>
                                <input type="text" id="judul" class="form-control" name="judul" placeholder="Masukkan judul buku" required>
                            </div>

                            <div class="mb-3">
                                <label for="penulis" class="form-label text-secondary small fw-semibold">Nama Penulis</label>
                                <input type="text" id="penulis" class="form-control" name="penulis" placeholder="Masukkan nama penulis" required>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="harga" class="form-label text-secondary small fw-semibold">Harga Buku (Rp)</label>
                                    <input type="number" id="harga" class="form-control" name="harga" placeholder="Contoh: 50000" min="0" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="tahun_terbit" class="form-label text-secondary small fw-semibold">Tahun</label>
                                    <input type="number" id="tahun_terbit" class="form-control" name="tahun_terbit" placeholder="2026" min="1000" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="stok" class="form-label text-secondary small fw-semibold">Stok</label>
                                    <input type="number" id="stok" class="form-control" name="stok" placeholder="0" min="0" required>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button class="btn btn-primary px-4 rounded-3 fw-medium" type="submit" name="submit" value="submit">
                                    <i class="bi bi-check-circle me-1"></i> Simpan Buku
                                </button>
                                <a href="../index.php" class="btn btn-outline-secondary px-4 rounded-3 fw-medium">
                                    Batal
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>

</html>