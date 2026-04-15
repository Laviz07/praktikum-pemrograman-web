<?php

$hasil = "";
$angka = "";
$error = "";

if (isset($_POST['submit'])) {
    $angka = $_POST['angka'];

    $hasil = $angka % 2 ? $angka . " adalah bilangan ganjil" : $angka . " adalah bilangan genap";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Menentukan Ganjil Genap</title>
</head>

<body>

    <?php include "menu.php" ?>
    <div class="container">
        <div class="glass-card">

            <!-- FORM -->
            <div class="panel-top">
                <div class="form-title">
                    <h2>Soal 4 - Menentukan Ganjil Genap</h2>
                </div>

                <form method="POST">
                    <div class="form-group">
                        <label>Masukkan Angka</label>
                        <input type="number" name="angka" required>
                    </div>

                    <button class="cek-btn" type="submit" name="submit" value="submit">
                        Submit
                    </button>

                </form>
            </div>
        </div>

        <!-- HASIL -->
        <div class="panel-bottom">
            <div class="result-header">
                <h3>Jenis Angka</h3>
            </div>

            <div class="resultBox">
                <?php if ($error != ""): ?>
                    <div class="error-message">
                        <?php echo $error; ?>
                    </div>

                <?php elseif (!empty($hasil)): ?>
                    <div class="result-content">
                        <div class="row">
                            <!-- <span>Jenis Kendaraan</span> -->
                            <span><?php echo $hasil; ?></span>
                        </div>
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