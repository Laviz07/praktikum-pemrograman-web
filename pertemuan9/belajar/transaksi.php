<?php
include "koneksi.php";
include "nav.php";

$buku_result = $conn->query("SELECT id, judul FROM buku");
$pelanggan_result = $conn->query("SELECT id, nama FROM pelanggan");

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

    <title>Pesan Buku</title>
</head>

<body>
    <div class="container mt-4">

        <h2>Buat Pesanan Buku</h2>

        <?php if (isset($_get['message'])): ?>
            <div class="alert alert-info">
                <?php echo htmlspecialchars($_get['message']); ?>
            </div>
        <?php endif; ?>

        <form action="proses_transaksi.php" method="POST">

            <!-- pilih pelanggan -->
            <div class="mb-3">
                <label for="pelanggan_id" class="form-label">
                    Pilih Pelanggan
                </label>
                <select name="pelanggan_id" id="pelanggan_id"
                    class="form-select" required>
                    <option value="">Pilih Pelanggan</option>

                    <?php while ($pelanggan = $pelanggan_result->fetch_assoc()): ?>
                        <option value="<?= $pelanggan['id'] ?>">
                            <?= $pelanggan['nama'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- <h3>Daftar Buku</h3> -->

            <!-- pilih buku -->
            <div class="mb-3">
                <label for="buku_id" class="form-label">
                    Pilih Buku
                </label>
                <select name="buku[1][id]" id="buku_id"
                    class="form-select" required>
                    <option value="">Pilih buku</option>

                    <?php while ($buku = $buku_result->fetch_assoc()): ?>
                        <option value="<?= $buku['id'] ?>">
                            <?= $buku['judul'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="qty" class="form-label">
                    Jumlah Buku
                </label>
                <input type="number" class="form-control" id="qty" name="buku[1][qty]" required>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-bag-plus"></i> Pesan
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