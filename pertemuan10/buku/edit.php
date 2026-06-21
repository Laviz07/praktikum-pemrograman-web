<?php
include "../koneksi.php";
include "../auth/auth_check.php";
include "../auth/admin_check.php";

$buku = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM buku WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $buku = $result->fetch_assoc();
    $stmt->close();
}

if (!$buku) {
    header("Location: ../index.php?status=error&message=" . urlencode("ID data buku tidak valid atau tidak ditemukan."));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Edit Buku - Laviz Book Store</title>
</head>

<body class="bg-light">
    <?php include "../include/nav.php" ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-sm-5">

                        <div class="d-flex align-items-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-warning text-dark rounded-3 me-3" style="width: 45px; height: 45px;">
                                <i class="bi bi-pencil-square fs-4"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold text-dark mb-0">Ubah Data Buku</h4>
                                <p class="text-muted small mb-0">Mengubah informasi buku: <strong><?= htmlspecialchars($buku['judul']) ?></strong></p>
                            </div>
                        </div>

                        <form method="POST" action="proses_edit.php">

                            <input type="hidden" name="id" value="<?= $buku['id'] ?>">

                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-semibold" for="judul">Judul Buku</label>
                                <input type="text" class="form-control" id="judul" name="judul" value="<?= htmlspecialchars($buku['judul']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-semibold" for="penulis">Nama Penulis</label>
                                <input type="text" class="form-control" id="penulis" name="penulis" value="<?= htmlspecialchars($buku['penulis']) ?>" required>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label text-secondary small fw-semibold" for="harga">Harga Buku (Rp)</label>
                                    <input type="number" class="form-control" id="harga" name="harga" value="<?= $buku['harga'] ?>" min="0" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-secondary small fw-semibold" for="tahun_terbit">Tahun</label>
                                    <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="<?= $buku['tahun_terbit'] ?>" min="1000" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-secondary small fw-semibold" for="stok">Stok</label>
                                    <input type="number" class="form-control" id="stok" name="stok" value="<?= $buku['stok'] ?>" min="0" required>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button class="btn btn-warning px-4 rounded-3 fw-medium text-dark" type="submit" name="submit" value="submit">
                                    <i class="bi bi-save me-1"></i> Perbarui Buku
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

    <?php if (isset($_GET['message'])): ?>
        <script>
            Swal.fire({
                title: "Oops...",
                text: "<?= htmlspecialchars($_GET['message']) ?>",
                icon: "error",
                confirmButtonColor: "#0d6efd"
            });
            window.history.replaceState({}, document.title, window.location.pathname);
        </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>

</html>