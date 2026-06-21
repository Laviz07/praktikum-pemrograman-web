<?php
include "proses_index.php";
$page_active = 'home';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Katalog Buku - Laviz Book Store</title>
</head>

<body class="bg-light">
    <?php include "include/nav.php" ?>
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Daftar Koleksi Buku</h2>
                <p class="text-muted small mb-0">Kelola informasi data buku, penulis, harga, serta ketersediaan stok.</p>
            </div>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="buku/tambah.php" class="btn btn-primary rounded-3 shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Buku Baru
                </a>
            <?php endif; ?>
        </div>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-4 p-sm-5">

                <form method="GET" action="index.php" id="bukuFilterForm" class="row g-3 mb-4">
                    <input type="hidden" name="page" value="1">

                    <div class="col-md-8">
                        <label class="form-label text-secondary small fw-semibold">Cari Buku</label>
                        <div class="input-group shadow-sm rounded-3 overflow-hidden">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                            <input type="text" name="judul" id="inputCariJudul" class="form-control border-start-0 ps-1" placeholder="Masukkan judul buku atau nama penulis..." value="<?= htmlspecialchars($cari_judul) ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-semibold">Filter Tahun Terbit</label>
                        <div class="input-group shadow-sm rounded-3 overflow-hidden">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-calendar-event"></i></span>
                            <input type="number" name="tahun_terbit" id="inputCariTahun" class="form-control border-start-0 ps-1" placeholder="Contoh: 2024" value="<?= htmlspecialchars($cari_tahun) ?>" onchange="document.getElementById('bukuFilterForm').submit()">
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary small fw-semibold">
                            <tr>
                                <th style="width: 8%">ID</th>
                                <th style="width: 30%">Judul Buku</th>
                                <th style="width: 22%">Penulis</th>
                                <th style="width: 12%">Tahun</th>
                                <th style="width: 13%">Harga</th>
                                <th style="width: 5%">Stok</th>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                    <th style="width: 10%" class="text-center">Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>

                        <tbody class="text-dark small">
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td class="fw-bold text-muted">#<?= $row["id"] ?></td>
                                        <td class="text-capitalize fw-semibold text-dark"><?= htmlspecialchars($row["judul"]) ?></td>
                                        <td class="text-capitalize text-secondary"><?= htmlspecialchars($row["penulis"]) ?></td>
                                        <td><span class="badge bg-secondary-subtle text-secondary px-2.5 py-1.5 rounded-3"><?= $row["tahun_terbit"] ?></span></td>
                                        <td class="fw-medium text-primary">Rp <?= number_format($row["harga"], 0, ',', '.') ?></td>
                                        <td>
                                            <span class="<?= ($row["stok"] <= 5) ? 'fw-bold text-danger' : 'fw-medium' ?>"><?= $row["stok"] ?></span>
                                        </td>
                                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="buku/edit.php?id=<?= $row["id"] ?>" class="btn btn-sm btn-outline-warning rounded-3 px-2.5 py-1">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <a href="buku/hapus.php?id=<?= $row["id"] ?>" class="btn btn-sm btn-outline-danger rounded-3 px-2.5 py-1" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="bi bi-search fs-2 d-block mb-2 text-secondary-subtle"></i>
                                        Buku yang Anda cari tidak dapat ditemukan.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($totalPages > 1): ?>
                    <nav class="mt-4">
                        <ul class="pagination justify-content-center mb-0">
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page - 1 ?>&judul=<?= urlencode($cari_judul) ?>&tahun_terbit=<?= urlencode($cari_tahun) ?>">Previous</a>
                            </li>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>&judul=<?= urlencode($cari_judul) ?>&tahun_terbit=<?= urlencode($cari_tahun) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page + 1 ?>&judul=<?= urlencode($cari_judul) ?>&tahun_terbit=<?= urlencode($cari_tahun) ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>

            </div>
        </div>

        <p class="text-center text-muted small mt-4">&copy; 2026 Laviz Book Store. All rights reserved.</p>
    </div>

    <script>
        const form = document.getElementById("bukuFilterForm");
        const inputJudul = document.getElementById("inputJudul");
        let timerPencarian;

        inputCariJudul.addEventListener("input", () => {
            clearTimeout(timerPencarian);
            // Submit form ke server otomatis setelah user berhenti mengetik selama 500ms
            timerPencarian = setTimeout(() => form.submit(), 500);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>

</html>