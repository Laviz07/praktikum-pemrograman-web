<?php

include "proses_index.php";

include "nav.php";

$limit = 10; // jumlah data per halaman
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

    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Perpustakaan Laviz</title>
</head>

<body>
    <!-- <h1>Selamat Datang</h1> -->
    <div class="container mt-4">

        <h2>Daftar Buku</h2>

        <!-- /* ----------------------------- form pencarian ----------------------------- */ -->
        <form method="GET" action="index.php" class="row g-3 mb-4">
            <div class="col-md-5">
                <label for="judul" class="form-label">Cari Judul Buku</label>
                <input type="text" class="form-control" name="judul"
                    id="judul" placeholder="Masukkan Judul Buku"
                    value="<?= htmlspecialchars($cari_judul) ?>">
            </div>

            <div class="col-md-3">
                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                <input type="number" class="form-control" name="tahun_terbit"
                    id="tahun_terbit" placeholder="Contoh: 2024"
                    value="<?= htmlspecialchars($cari_tahun) ?>">
            </div>

            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Cari
                </button>

                <a href="index.php" class="btn btn-secondary">
                    Reset
                </a>
            </div>
        </form>
        <!-- /* -------------------------- end of form pencarian ------------------------- */ -->

        <!-- /* ---------------------------- tabel daftar buku --------------------------- */ -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        Judul
                    </th>
                    <th>
                        Penulis
                    </th>
                    <th>
                        Tahun Terbit
                    </th>
                    <th>
                        Harga
                    </th>
                    <th>
                        Stok
                    </th>
                    <th>
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php
                    while ($row = $result->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?php echo $row["id"] ?></td>
                            <td class="text-capitalize"><?php echo $row["judul"] ?></td>
                            <td class="text-capitalize"><?php echo $row["penulis"] ?></td>
                            <td><?php echo $row["tahun_terbit"] ?></td>
                            <td>Rp.<?php echo number_format($row["harga"], 2) ?></td>
                            <td><?php echo $row["stok"] ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $row["id"] ?>"
                                    class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <a href="hapus.php?id=<?php echo $row["id"] ?>"
                                    class="btn btn-sm btn-danger">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center fw-bold">Tidak ada buku</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- /* -------------------------- end of tabel daftar buku ---------------------- */ -->

        <nav>
            <ul class="pagination justify-content-center">

                <!-- Previous -->
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link"
                        href="?page=<?= $page - 1 ?>&judul=<?= urlencode($cari_judul) ?>&tahun_terbit=<?= urlencode($cari_tahun) ?>">
                        Previous
                    </a>
                </li>

                <!-- Nomor halaman -->
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link"
                            href="?page=<?= $i ?>&judul=<?= urlencode($cari_judul) ?>&tahun_terbit=<?= urlencode($cari_tahun) ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Next -->
                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link"
                        href="?page=<?= $page + 1 ?>&judul=<?= urlencode($cari_judul) ?>&tahun_terbit=<?= urlencode($cari_tahun) ?>">
                        Next
                    </a>
                </li>

            </ul>
        </nav>

    </div>

    <?php if (isset($_GET['message'])): ?>
        <script>
            Swal.fire({
                title: "<?= (isset($_GET['status']) && $_GET['status'] == 'success') ? 'Berhasil!' : 'Oops...' ?>",
                text: "<?= htmlspecialchars($_GET['message']) ?>",
                icon: "<?= (isset($_GET['status']) && $_GET['status'] == 'success') ? 'success' : 'error' ?>",
                confirmButtonColor: "#0d6efd"
            });
            window.history.replaceState({}, document.title, window.location.pathname);
        </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>