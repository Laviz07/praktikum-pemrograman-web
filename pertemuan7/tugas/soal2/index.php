<?php

$nim = "";
$nama = "";
$prodi = "";
$smt = "";
$ukt = "";
$error = "";
$diskon = 0;

function rupiah($angka)
{
    return "Rp " . number_format($angka, 0, ',', '.');
}

if (isset($_POST["submit"])) {
    $nim = $_POST["nim"];
    $nama = $_POST["nama"];
    $prodi = $_POST["prodi"];
    $smt = $_POST["smt"];
    $ukt = $_POST["ukt"];

    // VALIDASI
    if ($nim == "" || $nama == "" || $prodi == "" || $smt == "" || $ukt == "") {
        $error = "Semua field harus diisi!";
    } elseif ($nim < 0 || $nim > 1000000000) {
        $error = "NIM tidak valid!";
    } elseif ($ukt < 0 || $ukt > 1000000000) {
        $error = "Biaya UKT tidak valid!";
    } elseif ($smt < 1 || $smt > 14) {
        $error = "Semester tidak valid!";
    }

    // HITUNG DISKON
    if ($error == "") {
        if ($ukt >= 5000000 && $smt > 8) {
            $diskon = 0.15;
        } elseif ($ukt >= 5000000) {
            $diskon = 0.10;
        } else {
            $diskon = 0;
        }

        $total = $ukt - ($ukt * $diskon);
    }
}
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Diskon Pembayaran UKT</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="glass-card">

            <!-- FORM -->
            <div class="panel-top">
                <div class="image-wrapper">
                    <img src="bayar.png">
                    <div class="image-title">Diskon Pembayaran UKT</div>
                </div>

                <form method="POST">
                    <div class="form-group">
                        <label>NIM</label>
                        <input type="number" name="nim" required>
                    </div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" required>
                    </div>

                    <div class="form-group">
                        <label>Program Studi</label>
                        <input type="text" name="prodi" required>
                    </div>

                    <div class="form-group">
                        <label>Semester</label>
                        <input type="number" name="smt" required>
                    </div>

                    <div class="form-group">
                        <label>Biaya UKT</label>
                        <input type="number" name="ukt" required placeholder="Rp. 100000">
                    </div>

                    <button class="cek-btn" type="submit" name="submit">
                        Cek Diskon UKT
                    </button>

                    <a href="../soal1/index.php">Periksa Nilai</a>
                </form>
            </div>
        </div>

        <!-- HASIL -->
        <div class="panel-bottom">
            <div class="result-header">
                <h3>UKT Yang Harus Dibayar</h3>
            </div>

            <div class="resultBox">
                <?php if ($error != ""): ?>
                    <div class="error-message">
                        <?php echo $error; ?>
                    </div>

                <?php elseif ($error == "" && isset($total)): ?>
                    <div class="result-content">
                        <div class="row">
                            <span>Nama</span>
                            <span><?php echo $nama; ?></span>
                        </div>

                        <div class="row">
                            <span>NIM</span>
                            <span><?php echo $nim; ?></span>
                        </div>

                        <div class="row">
                            <span>Program Studi</span>
                            <span><?php echo $prodi; ?></span>
                        </div>

                        <div class="row">
                            <span>Semester</span>
                            <span><?php echo $smt; ?></span>
                        </div>

                        <div class="row">
                            <span>Biaya UKT</span>
                            <span><?php echo rupiah($ukt); ?></span>
                        </div>

                        <div class="row">
                            <span>Diskon</span>
                            <span><?php echo $diskon * 100; ?>%</span>
                        </div>

                        <div class="row total">
                            <span>Total Bayar</span>
                            <span><?php echo rupiah($total); ?></span>
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