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

    <title>Tambah Buku</title>
</head>

<body>
    <?php include "nav.php" ?>
    <div class="container mt-4">
        <h1>Tambah Buku</h1>

        <form method="POST" action="proses_tambah.php">
            <div class="form-group mb-3">
                <label for="judul" class="form-label">Judul Buku</label>
                <input type="string" id="judul" class="form-control" name="judul" required>
            </div>

            <div class="form-group mb-3">
                <label for="penulis" class="form-label">Nama Penulis</label>
                <input type="string" id="penulis" class="form-control" name="penulis" required>
            </div>

            <div class="form-group mb-3">
                <label for="harga" class="form-label">Harga Buku</label>
                <input type="number" id="harga" class="form-control" name="harga" required>
            </div>

            <div class="form-group mb-3">
                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                <input type="number" id="tahun_terbit" class="form-control" name="tahun_terbit" required>
            </div>

            <div class="form-group mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" id="stok" class="form-control" name="stok" required>
            </div>
            <button class="btn btn-primary" type="submit" name="submit" value="submit">
                Submit
            </button>

        </form>
    </div>
</body>

</html>