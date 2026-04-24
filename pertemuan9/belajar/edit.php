<?php

include "koneksi.php";
include "nav.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare(
        "SELECT * FROM buku 
        WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $buku = $result->fetch_assoc();
} else {
    echo "ID buku tidak valid";
}
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

    <title>Edit Buku</title>
</head>

<body>
    <div class="container mt-4">
        <h2>Edit Buku <?= $buku['judul'] ?></h2>

        <form method="POST" action="proses_edit.php">

            <input type="hidden" name="id" value="<?= $buku['id'] ?>">

            <div class="form-group mb-3">
                <label class="form-label" for="judul">Judul Buku</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?= $buku['judul'] ?>" required>
            </div>

            <div class="form-group mb-3">
                <label class="form-label" for="penulis">Nama Penulis</label>
                <input type="text" class="form-control" id="penulis" name="penulis" value="<?= $buku['penulis'] ?>" required>
            </div>

            <div class="form-group mb-3">
                <label class="form-label" for="harga">Harga Buku</label>
                <input type="number" class="form-control" id="harga" name="harga" value="<?= $buku['harga'] ?>" required>
            </div>

            <div class="form-group mb-3">
                <label class="form-label" for="tahun_terbit">Tahun Terbit</label>
                <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="<?= $buku['tahun_terbit'] ?>" required>
            </div>

            <div class="form-group mb-3">
                <label class="form-label" for="stok">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" value="<?= $buku['stok'] ?>" required>
            </div>

            <button class="btn btn-primary" type="submit" name="submit" value="submit">
                Submit
            </button>

        </form>
    </div>

    <?php if (isset($_GET['message'])): ?>
        <script>
            <?php
            // Tentukan icon berdasarkan status (success atau error)
            $status = (isset($_GET['status']) && $_GET['status'] == 'success') ? 'success' : 'error';
            $title = ($status == 'success') ? 'Berhasil!' : 'Oops...';
            ?>

            Swal.fire({
                title: "<?= $title ?>",
                text: "<?= htmlspecialchars($_GET['message']) ?>",
                icon: "<?= $status ?>",
                confirmButtonColor: "#0d6efd" // Warna biru Bootstrap
            });

            // Opsional: Hapus parameter URL setelah muncul pesan agar pop-up tidak muncul lagi saat refresh
            window.history.replaceState({}, document.title, window.location.pathname);
        </script>
    <?php endif; ?>
</body>

</html>