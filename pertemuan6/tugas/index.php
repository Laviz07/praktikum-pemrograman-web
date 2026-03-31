<?php

//pajak
define("pajak", 0.10);

// daftar barang
$barang = [
    ["id" => 1, "nama" => "Beras", "harga" => 10000],
    ["id" => 2, "nama" => "Gula", "harga" => 5000],
    ["id" => 3, "nama" => "Telur", "harga" => 2000]
];

function rupiah($angka)
{
    return "Rp " . number_format($angka, 0, ',', '.');
}

$hasil = "";

if (isset($_POST['submit'])) {
    $id_barang = $_POST['id_barang'];
    $jumlah_beli = $_POST['jumlah_beli'];

    if ($id_barang != "" && $jumlah_beli > 0) {
        $harga_satuan = $barang[$id_barang - 1]['harga'];
        $total = $harga_satuan * $jumlah_beli;
        $harga_pajak = $total * pajak;
        $total_pajak = $total + $harga_pajak;

        $hasil  = "<div class='row'><span>Nama Barang</span><span>" . $barang[$id_barang - 1]['nama'] . "</span></div>";
        $hasil .= "<div class='row'><span>Harga Barang</span><span>" . rupiah($harga_satuan) . "</span></div>";
        $hasil .= "<div class='row'><span>Jumlah Beli</span><span>" . $jumlah_beli . "</span></div>";
        $hasil .= "<div class='row'><span>Total Belanja</span><span>" . rupiah($total) . "</span></div>";
        $hasil .= "<div class='row'><span>Pajak</span><span>" . rupiah($harga_pajak) . "</span></div>";
        $hasil .= "<div class='row total'><span>Total Setelah Pajak</span><span>" . rupiah($total_pajak) . "</span></div>";
       
        // simpan hasil ke session
        session_start();
        $_SESSION['hasil'] = $hasil;

        // redirect supaya refresh tidak mengulang POST
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
session_start();
if (isset($_SESSION['hasil'])) {
    $hasil = $_SESSION['hasil'];
    unset($_SESSION['hasil']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Aplikasi Kasir</title>
</head>

<body>
    <h1>Aplikasi Kasir</h1>

    <form action="" method="post">
        <div class="container-input">
            <label for="id_barang">Pilih Barang:</label>
            <select name="id_barang" id="id_barang" class="select-barang" required>
                <option value="" disabled selected>-- Pilih Barang --</option>
                <?php foreach ($barang as $brg): ?>
                    <option value="<?php echo $brg['id']; ?>">
                        <?php echo $brg['nama'] . " - " . rupiah($brg['harga']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="container-input">
            <label for="jumlah_beli">Jumlah Beli:</label>
            <input type="number" name="jumlah_beli" id="jumlah_beli" class="input-jml" required>
        </div>

        <input type="submit" name="submit" value="Beli">
    </form>

    <div class="hasil">
        <h2>Hasil Transaksi</h2>


        <?php
        if (!empty($hasil)) {
            echo $hasil;
        } else {
            echo "<h2 class='empty'> Belum ada transaksi </h2>";
        }
        ?>
    </div>

</body>

</html>