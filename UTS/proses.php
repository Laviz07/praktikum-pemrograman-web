<?php
define("PAJAK", 0.15);

$no = 1;
$total = 0;
$subtotal = 0;
$biaya_layanan = 0;

$barang = [
    ["id" => 1, "nama" => "Pulpen", "harga" => 2000],
    ["id" => 2, "nama" => "Correction Tape", "harga" => 6000],
    ["id" => 3, "nama" => "Penggaris", "harga" => 1500],
    ["id" => 4, "nama" => "Buku Tulis", "harga" => 5000],
    ["id" => 5, "nama" => "Pensil", "harga" => 1500],
    ["id" => 6, "nama" => "Penghapus", "harga" => 1000],
];

function rupiah($angka)
{
    return "Rp " . number_format($angka, 0, ',', '.');
}

if (isset($_POST['submit'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $npm = htmlspecialchars($_POST['npm']);
    $email = htmlspecialchars($_POST['email']);
    $layanan = $_POST['layanan'];

    $barang_pilih = $_POST['barang'] ?? [];
    $qty = $_POST['qty'] ?? [];

    if ($layanan == "Prioritas") {
        $biaya_layanan = 5000;
    } elseif ($layanan == "Reguler") {
        $biaya_layanan = 0;
    }

    foreach ($barang as $brg) {
        if (in_array($brg['id'], $barang_pilih)):
            $jumlah = $qty[$brg['id']] ?? 1;
            $subtotal = $brg['harga'] * $jumlah;
            $total += $subtotal;
        endif;
    }

    $biaya_tambahan = $total + $biaya_layanan;

    $total_pajak = $total * PAJAK;
    $total_setelah_pajak = $total_pajak + $total;

    $total_akhir = $biaya_tambahan + $total_pajak;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RINGKASAN PEMBELIAN</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div>
        <h2>Data Pembeli</h2>
        <p>Nama: <?= $nama ?></p>
        <p>NPM: <?= $npm ?></p>
        <p>Email: <?= $email ?></p>
        <p>Langganan: <?= $layanan ?></p>
    </div>

    <div>
        <h2>Barang Yang Dibeli:</h2>
        <table class="table-pembelian">
            <thead>
                <tr>
                    <th>
                        No.
                    </th>
                    <th>
                        Nama Barang
                    </th>
                    <th>
                        Harga Barang
                    </th>
                    <th>
                        Jumlah Pembelian
                    </th>
                    <th>
                        Subtotal
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach ($barang as $brg):
                        if (in_array($brg['id'], $barang_pilih)):
                            $subtotal = $brg['harga'] * $qty[$brg['id']] ?? 1;
                    ?>
                <tr>
                    <td>
                        <?= $no++ ?>
                    </td>
                    <td>
                        <div>
                            <span><?= $brg['nama'] ?></span>
                        </div>
                    </td>
                    <td>
                        <span><?= rupiah($brg['harga']) ?></span>
                    </td>
                    <td>
                        <span><?= $qty[$brg['id']] ?? 1 ?></span>
                    </td>
                    <td>
                        <!-- <span><?= rupiah($brg['subtotal']) ?></span> -->
                        <span><?= rupiah($subtotal) ?></span>

                    </td>
                </tr>
        <?php endif;
                    endforeach; ?>
        </tr>
            </tbody>

            <tfoot>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <span>Total Awal</span>
                    </td>
                    <td class="right" colspan="2"><?= rupiah($total) ?></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <span>Biaya Layanan <?= $layanan ?></span>
                    </td>
                    <td class="right" colspan="2"><?= rupiah($biaya_layanan) ?></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <span>Pajak 15%</span>
                    </td>
                    <td class="right" colspan="2"><?= rupiah($total_pajak) ?></td>
                </tr>
                <tr class="total-akhir">
                    <td colspan="3">
                        <span>Total Akhir</span>
                    </td>
                    <td class="right" colspan="2"><?= rupiah($total_akhir) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>