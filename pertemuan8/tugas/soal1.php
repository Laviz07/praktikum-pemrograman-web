<?php

$hasil = "";
$kendaraan = "";
$error = "";

if (isset($_POST['submit'])) {
    $roda = $_POST['roda'];

    switch ($roda) {
        case 2:
            $kendaraan = "Motor";
            break;
        case 3:
            $kendaraan = "Bajaj";
            break;
        case 4:
            $kendaraan = "Mobil";
            break;
        default:
            $kendaraan = "Kendaaran Tidak Diketahui";
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Menentukan Jenis Kendaraan</title>
</head>

<body>

    <?php include "menu.php" ?>
    <div class="container">
        <div class="glass-card">

            <!-- FORM -->
            <div class="panel-top">
                <div class="header">
                    <h2>Soal 1- Menentukan Jenis Kendaraan</h2>
                </div>

                <form method="POST">
                    <div class="form-group">
                        <label>Jumlah Roda</label>
                        <input type="number" name="roda" required>
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
                <h3>Jenis Kendaraan</h3>
            </div>

            <div class="resultBox">
                <?php if ($error != ""): ?>
                    <div class="error-message">
                        <?php echo $error; ?>
                    </div>

                <?php elseif (!empty($kendaraan)): ?>
                    <div class="result-content">
                        <div class="row">
                            <span>Jenis Kendaraan</span>
                            <span><?php echo $kendaraan; ?></span>
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