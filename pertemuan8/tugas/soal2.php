<?php

$hasil = "";
$bilAwal = "";
$bilAkhir = "";
$error = "";

if (isset($_POST['submit'])) {
    $bilAwal = $_POST['bil-awal'];
    $bilAkhir = $_POST['bil-akhir'];

    for ($i = $bilAwal; $i <= $bilAkhir; $i++) {
        if ($i % 2 == 0) {
            $hasil .= $i . " ";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Mencetak Bilangan Genap</title>
</head>

<body>

    <?php include "menu.php" ?>
    <div class="container">
        <div class="glass-card">

            <!-- FORM -->
            <div class="panel-top">
                <div class="header">
                    <h2>Soal 2 - Mencetak Bilangan Genap</h2>
                </div>

                <form method="POST">
                    <div class="form-group">
                        <label>Bilangan Awal</label>
                        <input type="number" name="bil-awal" required min="0">
                    </div>

                    <div class="form-group">
                        <label>Bilangan Akhir</label>
                        <input type="number" name="bil-akhir" required min="0">
                    </div>

                    <button class="cek-btn" type="submit" name="submit" value="submit">
                        Submit
                    </button>

                </form>
            </div>
        </div>

        <!-- HASIL -->
        <div class="panel-bottom">
            <div class="header">
                <h3>Bilangan <?= $bilAwal ?> sampai <?= $bilAkhir ?></h3>
            </div>

            <div class="resultBox">
                <?php if ($error != ""): ?>
                    <div class="error-message">
                        <?php echo $error; ?>
                    </div>

                <?php elseif (!empty($hasil)): ?>
                    <div class="result-content">
                        <span>
                            <?php echo $hasil; ?>
                        </span>
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