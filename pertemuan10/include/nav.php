<?php
require_once __DIR__ . '/../config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// PROTEKSI: Cek apakah session role ada, jika tidak ada (belum login) set sebagai 'tamu'
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : 'tamu';
?>

<style>
    .user-dropdown-btn {
        background: transparent;
        border: none;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 4px 8px;
        border-radius: 50px;
        transition: all 0.2s ease;
        text-align: left;
    }

    .user-dropdown-btn:hover,
    .user-dropdown-btn:focus {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .user-avatar-initial {
        width: 38px;
        height: 38px;
        background-color: #0d6efd;
        color: #ffffff;
        font-weight: 700;
        font-size: 14pt;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.2);
    }

    .user-info-block {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }

    .user-name-text {
        color: #ffffff;
        font-weight: 600;
        font-size: 10.5pt;
    }

    .user-role-text {
        color: #adb5bd;
        font-size: 8.5pt;
        text-transform: capitalize;
    }

    .chevron-icon {
        color: #adb5bd;
        font-size: 9pt;
        margin-left: 2px;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm border-bottom border-secondary border-opacity-25 py-3">
    <div class="container">
        <a href="<?= BASE_URL ?>/index.php" class="navbar-brand fw-bold fs-4 text-white font-monospace">
            <i class="bi bi-book-half text-primary me-2"></i>Laviz <span class="text-primary">Book</span>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>/index.php" 
                    class="nav-link px-3 rounded-3 <?= ($page_active === 'home') ? 'active bg-secondary bg-opacity-25 fw-semibold text-white' : '' ?>">
                        Katalog Buku
                    </a>
                </li>

                <?php if ($user_role === 'admin'): ?>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/buku/tambah.php" 
                        class="nav-link px-3 rounded-3 <?= ($page_active === 'tambah') ? 'active bg-primary fw-semibold text-white' : '' ?>">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Buku
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>/transaksi/transaksi.php" 
                    class="nav-link px-3 rounded-3 <?= ($page_active === 'transaksi') ? 'active bg-secondary bg-opacity-25 fw-semibold text-white' : '' ?>">
                        Buat Pesanan
                    </a>
                </li>


                <?php if (isset($_SESSION['login_Un51k4']) && $_SESSION['login_Un51k4'] === true): ?>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/transaksi/lihat_transaksi.php" 
                        class="nav-link px-3 rounded-3 <?= ($page_active === 'riwayat') ? 'active bg-secondary bg-opacity-25 fw-semibold text-white' : '' ?>">
                            Riwayat Pesanan
                        </a>
                    </li>

                    <li class="nav-item dropdown ms-lg-2">
                        <button class="user-dropdown-btn dropdown-toggle shadow-none custom-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar-initial">
                                <?= strtoupper(substr($_SESSION['username'] ?? 'U', 0, 1)); ?>
                            </div>
                            <div class="user-info-block d-none d-md-flex">
                                <span class="user-name-text"><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
                                <span class="user-role-text"><?= htmlspecialchars($user_role) ?></span>
                            </div>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3">
                            <li>
                                <a class="dropdown-item py-2" href="<?= BASE_URL; ?>/profile/index.php">
                                    <i class="bi bi-person-circle me-2 text-primary"></i> Profil
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider my-1">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger py-2" href="<?= BASE_URL; ?>/auth/logout.php" onclick="return confirm('Yakin ingin logout?')">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-lg-2">
                        <a href="<?= BASE_URL ?>/auth/login.php" class="btn btn-primary btn-sm px-4 rounded-pill fw-medium shadow-sm">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>