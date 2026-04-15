<?php

$no = 1;

$barang = [
    ["id" => 1, "nama" => "Pulpen", "harga" => 2000],
    ["id" => 2, "nama" => "Correction Tape", "harga" => 6000],
    ["id" => 3, "nama" => "Penggaris", "harga" => 1500],
    ["id" => 4, "nama" => "Buku Tulis", "harga" => 5000],
    ["id" => 5, "nama" => "Pensil", "harga" => 1500],
    ["id" => 6, "nama" => "Penghapus", "harga" => 1000],
]
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEM KOOPERASI MAHASISWA SEDERHANA</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="panel">
            <form action="proses.php" method="post">
                <div class="isi-data-diri">
                    <h2>Silahkan Masukkan Data Diri Anda</h2>
                    <div class="form-group">
                        <label for="nama">NAMA:</label>
                        <input type="text" name="nama" id="nama"
                            placeholder="Masukkan Nama Anda" required maxlength="16">
                    </div>

                    <div class="form-group">
                        <label for="npm">NPM:</label>
                        <input type="number" name="npm" id="npm"
                            placeholder="Masukkan NPM Anda" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email"
                            placeholder="Masukkan Email Anda" required>
                    </div>

                    <div class="radio-group">
                        <label for="">Pilih Jenis Layanan</label>

                        <span class="radio">
                            <input type="radio" name="layanan" id="reguler"
                                value="Reguler" required>
                            <label for="reguler">Reguler</label>
                        </span>

                        <span class="radio">
                            <input type="radio" name="layanan" id="prioritas"
                                value="Prioritas" required>
                            <label for="prioritas">Prioritas</label>
                        </span>
                    </div>
                </div>

                <div class="pilih-barang">
                    <h2>Silahkan Pilih Barang</h2>
                    <table class="table-pilih-barang">
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($barang as $brg): ?>
                                <tr>
                                    <td>
                                        <?= $no++ ?>
                                    </td>
                                    <td>
                                        <div>
                                            <input type="checkbox"
                                                name="barang[]"
                                                id="<?= $brg['id'] ?>"
                                                value="<?= $brg['id'] ?>">
                                            <label for="<?= $brg['id'] ?>">
                                                <?= $brg['nama'] ?>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <span><?= $brg['harga'] ?></span>
                                    </td>
                                    <td>
                                        <input type="number"
                                            name="qty[<?= $brg['id'] ?>]"
                                            id="qty[<?= $brg['id'] ?>]" min="1" value="1"
                                            placeholder="Masukkan Jumlah Barang" required>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div>
                        <button type="submit" name="submit">Submit</button>
                    </div>
                </div>
        </div>
        </form>
    </div>
</body>

</html>