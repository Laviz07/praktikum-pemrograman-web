<?php
include "../koneksi.php";
include "../auth/auth_check.php";

$pengguna_id = $_SESSION['id'];
$page_active = 'profil';

// =============================================
// 1. AMBIL DATA PROFIL PENGGUNA & PELANGGAN
// =============================================
$sql_profil = "
    SELECT pg.username, pg.role, pl.id AS pelanggan_id, pl.nama, pl.email, pl.telepon, pl.alamat 
    FROM pengguna pg
    LEFT JOIN pelanggan pl ON pg.pelanggan_id = pl.id
    WHERE pg.id = ?
";
$stmt = $conn->prepare($sql_profil);
$stmt->bind_param("i", $pengguna_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die("Data pengguna tidak ditemukan.");
}

// =============================================
// 2. PROSES UPDATE DATA (JIKA FORM DISUBMIT)
// =============================================
$error_msg = "";
$success_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama']);
    $email    = trim($_POST['email']);
    $telepon  = trim($_POST['telepon']);
    $alamat   = trim($_POST['alamat']);
    $password = $_POST['password'];

    if (empty($nama) || empty($email) || empty($telepon) || empty($alamat)) {
        $error_msg = "Semua kolom biodata wajib diisi!";
    } else {
        $conn->begin_transaction();
        try {
            // Update tabel pelanggan
            $sql_update_pelanggan = "UPDATE pelanggan SET nama = ?, email = ?, telepon = ?, alamat = ? WHERE id = ?";
            $stmt_pel = $conn->prepare($sql_update_pelanggan);
            $stmt_pel->bind_param("ssssi", $nama, $email, $telepon, $alamat, $user['pelanggan_id']);
            $stmt_pel->execute();

            // Jika user berniat mengganti password (kolom password diisi)
            if (!empty($password)) {
                $password_hashed = password_hash($password, PASSWORD_BCRYPT);
                $sql_update_pass = "UPDATE pengguna SET password = ? WHERE id = ?";
                $stmt_pass = $conn->prepare($sql_update_pass);
                $stmt_pass->bind_param("si", $password_hashed, $pengguna_id);
                $stmt_pass->execute();
            }

            $conn->commit();
            $success_msg = "Profil Anda berhasil diperbarui!";

            // Perbarui data variabel lokal agar tampilan langsung berubah setelah submit
            $user['nama'] = $nama;
            $user['email'] = $email;
            $user['telepon'] = $telepon;
            $user['alamat'] = $alamat;
        } catch (Exception $e) {
            $conn->rollback();
            $error_msg = "Gagal memperbarui profil: " . $e->getMessage();
        }
    }
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
    <title>Profil Saya - Laviz Book Store</title>
</head>

<body class="bg-light">
    <?php include "../include/nav.php" ?>

    <div class="container py-4">
        <div class="mb-4">
            <h2 class="fw-bold text-dark mb-1">Pengaturan Profil</h2>
            <p class="text-muted small mb-0">Kelola informasi data diri, alamat pengiriman, dan keamanan akun Anda.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-lg rounded-4 text-center p-4">
                    <div class="card-body">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                            <i class="bi bi-person-circle" style="font-size: 3.5rem;"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-1 text-capitalize"><?= htmlspecialchars($user['nama'] ?? 'User') ?></h4>
                        <p class="text-muted small mb-3">@<?= htmlspecialchars($user['username']) ?></p>

                        <span class="badge px-3 py-2 rounded-pill <?= ($user['role'] === 'admin') ? 'bg-danger-subtle text-danger border border-danger border-opacity-25' : 'bg-success-subtle text-success border border-success border-opacity-25' ?>">
                            <i class="bi <?= ($user['role'] === 'admin') ? 'bi-shield-lock' : 'bi-person' ?> me-1"></i>
                            <?= strtoupper(htmlspecialchars($user['role'] ?? 'Pengguna')) ?>
                        </span>

                        <hr class="my-4 text-muted opacity-25">

                        <div class="text-start small">
                            <div class="mb-2 text-secondary">
                                <i class="bi bi-envelope me-2 text-primary"></i><?= htmlspecialchars($user['email']) ?>
                            </div>
                            <div class="mb-2 text-secondary">
                                <i class="bi bi-telephone me-2 text-primary"></i><?= htmlspecialchars($user['telepon']) ?>
                            </div>
                            <div class="text-secondary text-truncate">
                                <i class="bi bi-geo-alt me-2 text-primary"></i><?= htmlspecialchars($user['alamat']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-lg rounded-4 p-4 p-sm-5">
                    <div class="card-body p-0">
                        <h5 class="fw-bold text-dark mb-4"><i class="bi bi-pencil-square me-2 text-primary"></i>Perbarui Informasi Akun</h5>

                        <form method="POST" action="" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-secondary small fw-semibold">Username Akun</label>
                                <div class="input-group rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-secondary-subtle border-end-0 text-muted"><i class="bi bi-at"></i></span>
                                    <input type="text" class="form-control bg-secondary-subtle border-start-0" value="<?= htmlspecialchars($user['username']) ?>" disabled>
                                </div>
                                <div class="form-text text-muted small">Username tidak dapat diubah.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-secondary small fw-semibold">Nama Lengkap</label>
                                <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                    <input type="text" name="nama" class="form-control border-start-0 ps-1" value="<?= htmlspecialchars($user['nama']) ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-secondary small fw-semibold">Alamat Email</label>
                                <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0 ps-1" value="<?= htmlspecialchars($user['email']) ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-secondary small fw-semibold">Nomor Telepon / WA</label>
                                <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-telephone"></i></span>
                                    <input type="text" name="telepon" class="form-control border-start-0 ps-1" value="<?= htmlspecialchars($user['telepon']) ?>" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label text-secondary small fw-semibold">Alamat Lengkap Rumah</label>
                                <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-geo-alt"></i></span>
                                    <textarea name="alamat" class="form-control border-start-0 ps-1" rows="2" required><?= htmlspecialchars($user['alamat']) ?></textarea>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="p-3 bg-warning-subtle text-warning-emphasis rounded-3 border border-warning border-opacity-25">
                                    <h6 class="fw-bold mb-1 small"><i class="bi bi-lock me-1"></i>Ubah Password Akun (Opsional)</h6>
                                    <p class="mb-2 text-muted" style="font-size: 0.8rem;">Kosongkan form input di bawah ini jika Anda tidak ingin mengubah password lama.</p>
                                    <div class="input-group shadow-sm rounded-3 overflow-hidden bg-white">
                                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-key"></i></span>
                                        <input type="password" name="password" class="form-control border-start-0 ps-1" placeholder="Masukkan password baru jika ingin diganti...">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="btn btn-primary rounded-3 px-4 shadow-sm">
                                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <p class="text-center text-muted small mt-4">&copy; 2026 Laviz Book Store. All rights reserved.</p>
    </div>

    <?php if (!empty($success_msg)): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= $success_msg ?>',
                confirmButtonColor: '#0d6efd'
            });
        </script>
    <?php endif; ?>

    <?php if (!empty($error_msg)): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal...',
                text: '<?= $error_msg ?>',
                confirmButtonColor: '#dc3545'
            });
        </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>