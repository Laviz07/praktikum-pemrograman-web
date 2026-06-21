<?php
include "../config.php";
session_start();

if (isset($_SESSION["login_Un51k4"])) {
    header("Location: " . BASE_URL . "/index.php");
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

    <title>Login - Laviz Book Store</title>

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body class="bg-light">

    <div class="d-flex align-items-center justify-content-center min-vh-100 w-100">

        <div class="px-3 py-4" style="width: 100%; max-width: 420px;">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-4 p-sm-5">

                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-book fs-3"></i>
                        </div>
                        <h4 class="fw-bold mb-1 text-dark">Laviz Book Store</h4>
                        <p class="text-muted small">Silakan masuk menggunakan akun Anda</p>
                    </div>

                    <form action="proses_login.php" method="POST">

                        <div class="mb-3">
                            <label for="username" class="form-label text-secondary small fw-semibold">Nama Pengguna</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-secondary">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" id="username" class="form-control border-start-0 ps-2" name="username" placeholder="Masukkan username" required autocomplete="username">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label text-secondary small fw-semibold">Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-secondary">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" id="password" class="form-control border-x-0 ps-2" name="password" placeholder="Masukkan password" required>
                                <button class="btn btn-outline-secondary bg-white border-start-0 text-secondary" type="button" id="togglePassword" style="border-color: #dee2e6;">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-medium mb-3">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <p class="text-muted small mb-2">Belum punya akun?
                            <a href="<?= BASE_URL ?>/auth/register.php"
                                class="text-primary fw-semibold text-decoration-none">
                                Daftar Sekarang
                            </a>
                        </p>

                        <p class="text-muted small mb-0">Kembali ke
                            <a href="<?= BASE_URL ?>/"
                                class="text-primary fw-semibold text-decoration-none">
                                Beranda
                            </a>
                        </p>
                    </div>

                </div>
            </div>

            <p class="text-center text-muted small mt-4">&copy; 2026 Laviz Book Store. All rights reserved.</p>

        </div>

    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'text') {
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        });
    </script>

    <?php if (isset($_GET['message'])): ?>
        <script>
            Swal.fire({
                title: "Informasi",
                text: "<?= htmlspecialchars($_GET['message']); ?>",
                icon: "info",
                confirmButtonColor: "#0d6efd"
            });
            window.history.replaceState({}, document.title, window.location.pathname);
        </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>