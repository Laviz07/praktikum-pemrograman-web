<?php

$hasil = "";
$hewan = [];
$error = "";

if (isset($_POST['submit'])) {
    $input_hewan = $_POST['daftar_hewan'];

    if (!empty(trim($input_hewan))) {
        // Memecah string berdasarkan koma
        // array_map('trim', ...) berfungsi menghapus spasi yang tidak sengaja terketik
        $hewan = array_map('trim', explode(',', $input_hewan));

        // Menghapus elemen kosong jika ada double koma (,,)
        $hewan = array_filter($hewan);
    } else {
        $error = "Silakan masukkan nama hewan terlebih dahulu.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Menampilkan Daftar Hewan</title>
</head>

<body>

    <?php include "menu.php" ?>
    <div class="container">
        <div class="glass-card">

            <!-- FORM -->
            <div class="panel-top">
                <div class="header">
                    <h2>Soal 3 - Menampilkan Daftar Hewan</h2>
                </div>

                <form method="POST">

                    <div class="form-group">
                        <label>Masukkan Nama-nama Hewan</label>
                        <input type="text" name="daftar_hewan" required
                            placeholder="Contoh: Kucing, Anjing, Kelinci, Harimau">
                    </div>

                    <!-- <div class="form-group">
                        <label>Hewan Pertama</label>
                        <input type="text" name="hewan1" required placeholder="Masukkan Nama Hewan Pertama">
                    </div>

                    <div class="form-group">
                        <label>Hewan Kedua</label>
                        <input type="text" name="hewan2" required placeholder="Masukkan Nama Hewan Kedua">
                    </div>

                    <div class="form-group">
                        <label>Hewan Ketiga</label>
                        <input type="text" name="hewan3" required placeholder="Masukkan Nama Hewan Ketiga">
                    </div>

                    <div class="form-group">
                        <label>Hewan Keempat</label>
                        <input type="text" name="hewan4" required placeholder="Masukkan Nama Hewan Keempat">
                    </div>

                    <div class="form-group">
                        <label>Hewan Kelima</label>
                        <input type="text" name="hewan5" required placeholder="Masukkan Nama Hewan Kelima">
                    </div> -->

                    <button class="cek-btn" type="submit" name="submit" value="submit">
                        Submit
                    </button>

                </form>
            </div>
        </div>

        <!-- HASIL -->
        <div class="panel-bottom">
            <div class="header">
                <h3>Nama-nama Hewan</h3>
            </div>

            <div class="resultBox">
                <?php if ($error != ""): ?>
                    <div class="error-message">
                        <?php echo $error; ?>
                    </div>

                <?php elseif (!empty($hewan)): ?>
                    <div class="result-content">
                        <?php $no = 1; ?>
                        <?php foreach ($hewan as $h): ?>
                            <div class="row">
                                <span>Hewan ke-<?php echo $no; ?></span>
                                <span><?php echo $h; ?></span>
                            </div>
                        <?php $no++;
                        endforeach; ?>
                    </div>

                <?php else: ?>
                    <div class="blank-state">
                        <p>Belum ada hasil</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</body>

</html>