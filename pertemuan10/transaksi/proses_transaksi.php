<?php
session_start();
include "../koneksi.php";
include "../auth/auth_check.php";
include "../config.php";

// Proteksi awal: Wajib login untuk memproses checkout
if (!isset($_SESSION['login_Un51k4']) || $_SESSION['login_Un51k4'] !== true) {
    header("Location: " . BASE_URL . "/auth/login.php?message=" . urlencode("Akses ditolak, silakan login!"));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan session user dan data pesanan buku tersedia
    if (!isset($_SESSION['id']) || empty($_POST['buku'])) {
        header("Location: transaksi.php?status=error&message=" . urlencode("Data kiriman tidak valid atau sesi berakhir."));
        exit;
    }

    $conn->begin_transaction();

    try {
        $current_user_id = $_SESSION['id'];
        $current_user_role = $_SESSION['role'] ?? 'pengguna';

        // 1. Tentukan siapa pembelinya & siapa operator kasirnya (dibuat_oleh)
        if ($current_user_role === 'admin' && !empty($_POST['user_id_pilihan'])) {
            // Jika yang memesan adalah admin atas nama orang lain
            $pengguna_id = $_POST['user_id_pilihan'];
            $dibuat_oleh = $current_user_id; // Log ID admin yang bertindak sebagai kasir
        } else {
            // Jika pengguna/pelanggan memesan mandiri dari akun mereka sendiri
            $pengguna_id = $current_user_id;
            $dibuat_oleh = null; // NULL berarti pesanan mandiri lewat online shop
        }

        // Ambil pelanggan_id yang berelasi dengan pengguna_id pembeli
        $stmt_user = $conn->prepare("SELECT pelanggan_id FROM pengguna WHERE id = ?");
        $stmt_user->bind_param("i", $pengguna_id);
        $stmt_user->execute();
        $stmt_user->bind_result($pelanggan_id);

        if (!$stmt_user->fetch()) {
            $stmt_user->close();
            throw new Exception("Profil pelanggan tidak ditemukan untuk akun ini.");
        }
        $stmt_user->close();

        // 2. Set parameter awal untuk tabel induk pesanan
        $tanggal_pesanan = date('Y-m-d');
        $total_harga = 0;

        // Insert ke tabel induk pesanan (termasuk kolom dibuat_oleh)
        $stmt = $conn->prepare("INSERT INTO pesanan (pelanggan_id, tanggal_pesanan, total_harga, dibuat_oleh) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isdi", $pelanggan_id, $tanggal_pesanan, $total_harga, $dibuat_oleh);
        $stmt->execute();
        $pesanan_id = $conn->insert_id;
        $stmt->close();

        // 3. Loop koleksi buku yang ada di dalam keranjang belanja
        foreach ($_POST['buku'] as $buku) {
            $buku_id = (int)$buku['id'];
            $buku_qty = (int)$buku['qty'];

            if ($buku_qty <= 0) continue; // Lewati jika ada kuantitas tidak valid

            // Ambil harga asli & stok aktual terupdate
            $stmt = $conn->prepare("SELECT harga, stok FROM buku WHERE id = ?");
            $stmt->bind_param("i", $buku_id);
            $stmt->execute();
            $stmt->bind_result($harga_per_satuan, $stok);

            if (!$stmt->fetch()) {
                $stmt->close();
                throw new Exception("Buku dengan ID " . $buku_id . " tidak valid/ditemukan.");
            }
            $stmt->close();

            // Proteksi pengecekan ketersediaan stok produk
            if ($stok < $buku_qty) {
                throw new Exception("Gagal! Stok buku yang dipilih tidak mencukupi.");
            }

            // Simpan rincian item ke detail_pesanan
            $stmt = $conn->prepare("INSERT INTO detail_pesanan (pesanan_id, buku_id, kuantitas, harga_per_satuan) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $pesanan_id, $buku_id, $buku_qty, $harga_per_satuan);
            $stmt->execute();
            $stmt->close();

            // Potong jumlah stok produk di database
            $stmt = $conn->prepare("UPDATE buku SET stok = stok - ? WHERE id = ?");
            $stmt->bind_param("ii", $buku_qty, $buku_id);
            $stmt->execute();
            $stmt->close();

            // Hitung akumulasi total harga keseluruhan secara realtime di backend
            $total_harga += ($harga_per_satuan * $buku_qty);
        }

        // 4. Update total_harga akumulatif final ke data induk pesanan
        $stmt = $conn->prepare("UPDATE pesanan SET total_harga = ? WHERE id = ?");
        $stmt->bind_param("di", $total_harga, $pesanan_id);
        $stmt->execute();
        $stmt->close();

        // Jika semua langkah aman tanpa error, kunci perubahan ke database
        $conn->commit();
        header("Location: lihat_transaksi.php?status=success&message=" . urlencode("Transaksi Berhasil Disimpan!"));
        exit;
    } catch (Exception $e) {
        // Jika ada kegagalan di tengah jalan, batalkan semua query di atas (Rollback)
        $conn->rollback();
        header("Location: transaksi.php?status=error&message=" . urlencode($e->getMessage()));
        exit;
    }
} else {
    header("Location: transaksi.php");
    exit;
}