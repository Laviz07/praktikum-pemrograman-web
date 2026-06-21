<?php
include "../koneksi.php";
// include "../auth/auth_check.php";

$page_active = 'transaksi';

// Ambil semua daftar buku untuk ditampilkan di catalog kiri
$buku_result = $conn->query("SELECT id, judul, penulis, tahun_terbit, harga, stok FROM buku WHERE stok > 0");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Pesan Buku - Laviz Book Store</title>
</head>

<body class="bg-light">
    <?php include "../include/nav.php" ?>
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Buat Pesanan Buku</h2>
                <p class="text-muted small mb-0">
                    Silakan pilih koleksi buku di bawah.</p>
            </div>
        </div>

        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-info alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-info-circle me-2"></i> <?php echo htmlspecialchars($_GET['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4">

            <div class="col-lg-7">
                <div class="card border-0 shadow-lg rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-secondary"><i class="bi bi-grid-3x3-gap me-2"></i>Katalog Buku</h5>

                        <div class="input-group mb-4 shadow-sm rounded-3 overflow-hidden">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                            <input type="text" id="searchBuku" class="form-control border-start-0 ps-1" placeholder="Cari judul buku atau penulis...">
                        </div>

                        <div class="row g-3" id="katalogBuku">
                            <?php while ($buku = $buku_result->fetch_assoc()): ?>
                                <div class="col-md-6 item-buku" data-judul="<?= strtolower($buku['judul']); ?>" data-penulis="<?= strtolower($buku['penulis']); ?>">
                                    <div class="card h-100 border border-light-subtle shadow-sm rounded-3">
                                        <div class="card-body d-flex flex-column p-3">
                                            <span class="badge bg-secondary-subtle text-secondary align-self-start mb-2 small"><?= $buku['tahun_terbit']; ?></span>
                                            <h6 class="fw-bold text-dark mb-1 judul-buku"><?= htmlspecialchars($buku['judul']); ?></h6>
                                            <p class="text-muted small mb-3">Oleh: <?= htmlspecialchars($buku['penulis']); ?></p>

                                            <div class="mt-auto d-flex justify-content-between align-items-center pt-2 border-top border-light">
                                                <div>
                                                    <span class="text-primary fw-bold d-block">Rp <?= number_format($buku['harga'], 0, ',', '.'); ?></span>
                                                    <small class="text-muted text-xs">Stok: <span class="fw-semibold text-dark"><?= $buku['stok']; ?></span></small>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-primary rounded-3 px-3 btn-tambah"
                                                    data-id="<?= $buku['id']; ?>"
                                                    data-judul="<?= htmlspecialchars($buku['judul']); ?>"
                                                    data-harga="<?= $buku['harga']; ?>"
                                                    data-stok="<?= $buku['stok']; ?>">
                                                    <i class="bi bi-plus-lg"></i> Tambah
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 sticky-top" style="top: 24px; z-index: 10;">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-cart3 me-2 text-primary"></i>Keranjang Belanja</h5>

                        <form action="proses_transaksi.php" method="POST" id="formTransaksi">

                            <?php
                            if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'):
                                // Ambil daftar pelanggan/pengguna dari DB untuk dipilih oleh admin
                                $user_query = $conn->query("SELECT id, username FROM pengguna WHERE role = 'pengguna' ORDER BY username ASC");
                            ?>
                                <div class="mb-4 p-3 bg-light rounded-3 border border-primary border-opacity-25">
                                    <label for="pilih_user" class="form-label text-dark small fw-bold mb-1">
                                        <i class="bi bi-person-badge text-primary me-1"></i> Transaksi Atas Nama Pelanggan:
                                    </label>
                                    <select name="user_id_pilihan" id="pilih_user" class="form-select shadow-sm" required>
                                        <option value="" disabled selected>-- Pilih Akun Pelanggan --</option>
                                        <?php while ($u = $user_query->fetch_assoc()): ?>
                                            <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['username']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    <small class="text-muted text-xs mt-1 d-block">*Sebagai admin, Anda dapat memilih akun pelanggan yang memesan.</small>
                                </div>
                            <?php endif; ?>

                            <div id="keranjangContainer" class="mb-4" style="max-height: 320px; overflow-y: auto;">
                                <div class="text-center text-muted py-5" id="keranjangKosong">
                                    <i class="bi bi-basket2 fs-1 d-block mb-2 text-secondary-subtle"></i>
                                    <span class="small">Keranjang masih kosong.<br>Pilih buku di katalog sebelah kiri.</span>
                                </div>
                            </div>

                            <div class="border-top pt-3 mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold text-secondary">Estimasi Total</span>
                                    <h4 class="fw-bold text-primary mb-0" id="grandTotal">Rp 0</h4>
                                </div>
                            </div>

                            <?php if (isset($_SESSION['login_Un51k4']) && $_SESSION['login_Un51k4'] === true): ?>
                                <button type="submit" class="btn btn-primary w-100 py-2.5 rounded-3 fw-medium" id="btnCheckout" disabled>
                                    <i class="bi bi-bag-check me-1"></i> Selesaikan Pesanan
                                </button>
                            <?php else: ?>
                                <a href="<?= BASE_URL ?>/auth/login.php?message=<?= urlencode('Silakan login terlebih dahulu untuk membuat pesanan.') ?>" class="btn btn-warning w-100 py-2 rounded-3 fw-medium">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Login untuk Memesan
                                </a>
                            <?php endif; ?>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // 1. Fitur Live Search Buku (Sisi Kiri)
        document.getElementById('searchBuku').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            document.querySelectorAll('.item-buku').forEach(item => {
                const judul = item.getAttribute('data-judul');
                const penulis = item.getAttribute('data-penulis');
                if (judul.includes(query) || penulis.includes(query)) {
                    item.classList.remove('d-none');
                } else {
                    item.classList.add('d-none');
                }
            });
        });

        // 2. Fitur Managemen Keranjang Belanja (Sisi Kanan)
        const keranjangContainer = document.getElementById('keranjangContainer');
        const keranjangKosong = document.getElementById('keranjangKosong');
        const grandTotalEl = document.getElementById('grandTotal');
        const btnCheckout = document.getElementById('btnCheckout');

        let itemIndex = 0;

        document.querySelectorAll('.btn-tambah').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const judul = this.getAttribute('data-judul');
                const harga = parseFloat(this.getAttribute('data-harga'));
                const maxStok = parseInt(this.getAttribute('data-stok'));

                // Cek jika buku ini sudah dimasukkan ke keranjang sebelumnya
                const itemEksis = document.querySelector(`.input-buku-id[value="${id}"]`);
                if (itemEksis) {
                    const rowEksis = itemEksis.closest('.row-keranjang');
                    const qtyInput = rowEksis.querySelector('.input-qty');
                    let currentQty = parseInt(qtyInput.value);
                    if (currentQty < maxStok) {
                        qtyInput.value = currentQty + 1;
                        hitungTotalHarga();
                    }
                    return;
                }

                // Sembunyikan pesan kosong jika ini barang pertama
                if (itemIndex === 0) keranjangKosong.style.setProperty('display', 'none', 'important');

                itemIndex++;

                // Template Item Element
                const itemHtml = `
                    <div class="row-keranjang p-3 border rounded-3 mb-2 bg-white position-relative border-light-subtle shadow-sm" data-harga="${harga}">
                        <input type="hidden" class="input-buku-id" name="buku[${itemIndex}][id]" value="${id}">
                        <div class="pe-4">
                            <h6 class="small fw-bold mb-1 text-truncate">${judul}</h6>
                            <span class="text-xs text-primary d-block mb-2">Rp ${harga.toLocaleString('id-ID')}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="input-group input-group-sm" style="width: 110px;">
                                <span class="input-group-text">Qty</span>
                                <input type="number" class="form-control text-center input-qty" name="buku[${itemIndex}][qty]" value="1" min="1" max="${maxStok}" required>
                            </div>
                            <button type="button" class="btn btn-sm btn-link text-danger text-decoration-none p-0 btn-hapus-item">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                `;

                keranjangContainer.insertAdjacentHTML('beforeend', itemHtml);
                hitungTotalHarga();
            });
        });

        // Event handler hapus item & perubahan quantity kuantitas
        keranjangContainer.addEventListener('click', function(e) {
            if (e.target.closest('.btn-hapus-item')) {
                e.target.closest('.row-keranjang').remove();
                if (keranjangContainer.querySelectorAll('.row-keranjang').length === 0) {
                    keranjangKosong.style.setProperty('display', 'block', 'important');
                    itemIndex = 0;
                }
                hitungTotalHarga();
            }
        });

        keranjangContainer.addEventListener('input', function(e) {
            if (e.target.classList.contains('input-qty')) {
                hitungTotalHarga();
            }
        });

        // Hitung total harga berjalan
        function hitungTotalHarga() {
            let total = 0;
            const rows = keranjangContainer.querySelectorAll('.row-keranjang');

            rows.forEach(row => {
                const harga = parseFloat(row.getAttribute('data-harga'));
                const qty = parseInt(row.querySelector('.input-qty').value) || 0;
                total += (harga * qty);
            });

            grandTotalEl.innerText = 'Rp ' + total.toLocaleString('id-ID');

            if (rows.length > 0) {
                btnCheckout.removeAttribute('disabled');
            } else {
                btnCheckout.setAttribute('disabled', 'true');
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>

</html>