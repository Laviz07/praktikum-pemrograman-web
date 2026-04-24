<?php
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn->begin_transaction();

    try {
        $pelanggan_id = $_POST['pelanggan_id'];
        $tanggal_pesanan = date('Y-m-d');
        $total_harga = 0;

        // 1. Insert ke tabel pesanan (induk)
        $stmt = $conn->prepare("INSERT INTO pesanan (pelanggan_id, tanggal_pesanan, total_harga) VALUES (?, ?, ?)");
        $stmt->bind_param("isd", $pelanggan_id, $tanggal_pesanan, $total_harga);
        $stmt->execute();
        $pesanan_id = $conn->insert_id;
        $stmt->close(); // Tutup stmt setelah digunakan

        // 2. Loop buku yang dibeli
        foreach ($_POST['buku'] as $buku) {
            $buku_id = $buku['id'];
            $buku_qty = $buku['qty'];

            // Ambil harga dan stok terbaru
            $stmt = $conn->prepare("SELECT harga, stok FROM buku WHERE id = ?");
            $stmt->bind_param("i", $buku_id);
            $stmt->execute();
            $stmt->bind_result($harga_per_satuan, $stok);
            $stmt->fetch();
            $stmt->close(); // Tutup agar bisa panggil prepare lagi

            // Cek stok
            if ($stok < $buku_qty) {
                throw new Exception("Stok buku tidak mencukupi untuk ID: " . $buku_id);
            }

            // 3. Insert ke pesanan_detail
            $stmt = $conn->prepare("INSERT INTO detail_pesanan (pesanan_id, buku_id, kuantitas, harga_per_satuan) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $pesanan_id, $buku_id, $buku_qty, $harga_per_satuan);
            $stmt->execute();
            $stmt->close();

            // 4. Update stok buku
            $stmt = $conn->prepare("UPDATE buku SET stok = stok - ? WHERE id = ?");
            $stmt->bind_param("ii", $buku_qty, $buku_id);
            $stmt->execute();
            $stmt->close();

            // Hitung akumulasi total harga
            $total_harga += ($harga_per_satuan * $buku_qty);
        }

        // 5. Update TOTAL HARGA akhir di tabel pesanan (Hanya sekali saja di luar loop)
        $stmt = $conn->prepare("UPDATE pesanan SET total_harga = ? WHERE id = ?");
        $stmt->bind_param("di", $total_harga, $pesanan_id);
        $stmt->execute();
        $stmt->close();

        // JIKA SEMUA BERHASIL, BARU COMMIT
        $conn->commit();
        header("Location: transaksi.php?status=success&message=" . urlencode("Transaksi Berhasil!"));
        exit;
    } catch (Exception $e) {
        // JIKA ADA SATU SAJA YANG GAGAL, BATALKAN SEMUA
        $conn->rollback();
        header("Location: transaksi.php?status=error&message=" . urlencode($e->getMessage()));
        exit;
    }
}
