<?php
include "../koneksi.php";
include "../auth/auth_check.php";

$pengguna_id = $_SESSION['id'];
$user_role = $_SESSION['role'] ?? 'pengguna';
$page_active = 'riwayat';

// =============================================
// 1. TANGKAP INPUT SEARCH & FILTER TANGGAL
// =============================================
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filter_tgl = isset($_GET['tanggal']) ? trim($_GET['tanggal']) : '';

// Pembatasan data (Admin melihat semua, Pengguna melihat miliknya sendiri)
$where_clause = "WHERE 1=1";
if ($user_role !== 'admin') {
    $where_clause .= " AND pg.id = " . (int)$pengguna_id;
}

// Tambahan filter tanggal jika diisi
if (!empty($filter_tgl)) {
    $where_clause .= " AND DATE(p.tanggal_pesanan) = '" . $conn->real_escape_string($filter_tgl) . "'";
}

// Tambahan filter pencarian (Mencari ID, Judul Buku, atau Nama Pelanggan jika Admin)
if (!empty($search)) {
    $search_esc = $conn->real_escape_string($search);
    if ($user_role === 'admin') {
        $where_clause .= " AND (p.id LIKE '%$search_esc%' OR b.judul LIKE '%$search_esc%' OR pl.nama LIKE '%$search_esc%')";
    } else {
        $where_clause .= " AND (p.id LIKE '%$search_esc%' OR b.judul LIKE '%$search_esc%')";
    }
}

// =============================================
// 2. CONFIGURATION PAGINATION
// =============================================
$limit = 5;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;
$offset = ($current_page - 1) * $limit;

// Hitung total data transaksi yang memenuhi kriteria filter (menggunakan DISTINCT p.id karena ada JOIN ke tabel detail)
$count_query = "
    SELECT COUNT(DISTINCT p.id) as total 
    FROM pesanan p
    JOIN pelanggan pl ON p.pelanggan_id = pl.id
    JOIN detail_pesanan dp ON p.id = dp.pesanan_id
    JOIN buku b ON dp.buku_id = b.id
    JOIN pengguna pg ON pg.pelanggan_id = pl.id
    $where_clause
";
$count_result = $conn->query($count_query);
$total_data = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_data / $limit);

if ($current_page > $total_pages && $total_pages > 0) {
    $current_page = $total_pages;
    $offset = ($current_page - 1) * $limit;
}

// =============================================
// 3. QUERY UTAMA DENGAN LIMIT & OFFSET
// =============================================
$sql = "
    SELECT 
        p.id AS id_pesanan, 
        pl.nama AS nama_pelanggan, 
        p.tanggal_pesanan, 
        p.total_harga,
        op.username AS nama_operator,
        GROUP_CONCAT(CONCAT('- ', b.judul, ' (', dp.kuantitas, 'x)') SEPARATOR '<br>') AS detail_buku
    FROM pesanan p
    JOIN pelanggan pl ON p.pelanggan_id = pl.id
    JOIN detail_pesanan dp ON p.id = dp.pesanan_id
    JOIN buku b ON dp.buku_id = b.id
    JOIN pengguna pg ON pg.pelanggan_id = pl.id
    LEFT JOIN pengguna op ON p.dibuat_oleh = op.id
    $where_clause
    GROUP BY p.id 
    ORDER BY p.tanggal_pesanan DESC, p.id DESC
    LIMIT $limit OFFSET $offset
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Riwayat Pesanan - Laviz Book Store</title>
</head>

<body class="bg-light">
    <?php include "../include/nav.php" ?>
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Riwayat Transaksi</h2>
                <p class="text-muted small mb-0">Berikut adalah daftar pesanan buku yang pernah dilakukan.</p>
            </div>
            <a href="transaksi.php" class="btn btn-primary rounded-3 shadow-sm">
                <i class="bi bi-cart-plus me-1"></i> Pesan Buku Baru
            </a>
        </div>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
            <div class="card-body p-4 p-sm-5">

                <form method="GET" action="" id="filterTrxForm" class="row g-3 mb-4">
                    <input type="hidden" name="page" value="1">
                    <div class="col-md-7">
                        <label class="form-label text-secondary small fw-semibold">Cari Pesanan</label>
                        <div class="input-group shadow-sm rounded-3 overflow-hidden">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" id="searchTransaksi" class="form-control border-start-0 ps-1"
                                placeholder="<?= ($user_role === 'admin') ? 'Cari ID, judul buku, atau nama user...' : 'Cari ID atau judul buku...' ?>"
                                value="<?= htmlspecialchars($search) ?>">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label for="filterTanggal" class="form-label text-secondary small fw-semibold">Filter Tanggal Pesanan</label>
                        <div class="input-group shadow-sm rounded-3 overflow-hidden">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-calendar3"></i></span>
                            <input type="date" name="tanggal" id="filterTanggal" class="form-control border-start-0 ps-1"
                                value="<?= htmlspecialchars($filter_tgl) ?>" onchange="document.getElementById('filterTrxForm').submit()">
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="tabelTransaksi">
                        <thead class="table-light text-secondary small fw-semibold">
                            <tr>
                                <th style="width: 10%;">ID Pesanan</th>
                                <th style="width: 18%;">Nama Pelanggan</th>
                                <th style="width: 32%;">Daftar Buku (Qty)</th>
                                <th style="width: 15%;">Tanggal Pesanan</th>
                                <th style="width: 13%;">Total Harga</th>
                                <th style="width: 12%;">Metode / Operator</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark small">
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td class="fw-bold text-primary">#TRX-<?= $row['id_pesanan'] ?></td>
                                        <td class="text-capitalize text-secondary font-monospace"><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                                        <td>
                                            <div class="p-2 bg-light rounded-3 text-secondary border border-light-subtle">
                                                <?= $row['detail_buku'] ?>
                                            </div>
                                        </td>
                                        <td class="text-muted">
                                            <i class="bi bi-clock me-1"></i> <?= date('d M Y', strtotime($row['tanggal_pesanan'])) ?>
                                        </td>
                                        <td class="fw-bold text-success">
                                            Rp <?= number_format($row['total_harga'], 0, ',', '.') ?>
                                        </td>
                                        <td>
                                            <?php if ($row['nama_operator']): ?>
                                                <span class="badge bg-info-subtle text-info border border-info border-opacity-25 py-1.5 px-2 rounded">
                                                    <i class="bi bi-person-workspace me-1"></i> Kasir: <?= htmlspecialchars($row['nama_operator']) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-success-subtle text-success border border-success border-opacity-25 py-1.5 px-2 rounded">
                                                    <i class="bi bi-globe me-1"></i> Mandiri (Online)
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        <i class="bi bi-search fs-2 d-block mb-2 text-secondary-subtle"></i>
                                        Data transaksi yang Anda cari tidak ditemukan.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($total_pages > 1): ?>
                    <nav class="mt-4">
                        <ul class="pagination justify-content-center mb-0">
                            <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $current_page - 1 ?>&search=<?= urlencode($search) ?>&tanggal=<?= urlencode($filter_tgl) ?>">Previous</a>
                            </li>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= ($i == $current_page) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&tanggal=<?= urlencode($filter_tgl) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $current_page + 1 ?>&search=<?= urlencode($search) ?>&tanggal=<?= urlencode($filter_tgl) ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>

            </div>
        </div>

        <p class="text-center text-muted small mt-4">&copy; 2026 Laviz Book Store. All rights reserved.</p>
    </div>

    <script>
        const filterForm = document.getElementById("filterTrxForm");
        const searchInput = document.getElementById("searchTransaksi");
        let searchTimer;

        searchInput.addEventListener("input", () => {
            clearTimeout(searchTimer);
            // Submit form otomatis setelah jeda ketik 500ms
            searchTimer = setTimeout(() => filterForm.submit(), 500);
        });
    </script>

    <?php if (isset($_GET['message'])): ?>
        <script>
            <?php
            $status = (isset($_GET['status']) && $_GET['status'] == 'success') ? 'success' : 'error';
            $title = ($status == 'success') ? 'Berhasil!' : 'Oops...';
            $btnColor = ($status == 'success') ? '#0d6efd' : '#dc3545';
            ?>

            Swal.fire({
                title: "<?= $title ?>",
                text: "<?= htmlspecialchars($_GET['message']) ?>",
                icon: "<?= $status ?>",
                confirmButtonColor: "<?= $btnColor ?>"
            });
            window.history.replaceState({}, document.title, window.location.pathname);
        </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>