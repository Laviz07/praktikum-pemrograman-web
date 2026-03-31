<?php

$hurufMutu = "";
$gradeClass = "";
$nim = "";
$nama = "";
$nilai = "";
$error = "";

if (isset($_POST["submit"])) {
    $nim = $_POST["nim"];
    $nama = $_POST["nama"];
    $nilai = $_POST["nilai"];

    if ($nilai > 74) {
        $status = "Lulus";
    } else {
        $status = "Tidak Lulus";
    }

    if ($nilai < 0 || $nilai > 100) {
        $error = "Nilai tidak valid!";
    } else {
        if ($nilai >= 85) {
            $hurufMutu = "A";
            $gradeClass = "gradeA";
        } elseif ($nilai >= 75) {
            $hurufMutu = "B";
            $gradeClass = "gradeB";
        } elseif ($nilai >= 65) {
            $hurufMutu = "C";
            $gradeClass = "gradeC";
        } elseif ($nilai >= 50) {
            $hurufMutu = "D";
            $gradeClass = "gradeD";
        } else {
            $hurufMutu = "E";
            $gradeClass = "gradeE";
        }
    }
}
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cek Nilai Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="glass-card">

            <!-- FORM -->
            <div class="panel-top">
                <div class="image-wrapper">
                    <img src="mahasigma.png">
                    <div class="image-title">Cek Nilai Mahasiswa</div>
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
                        <label>Nilai Mata Kuliah</label>
                        <input type="number" name="nilai" required>
                    </div>

                    <button class="cek-btn" type="submit" name="submit">
                        Cek Nilai
                    </button>

                    <a href="../soal2/index.php">Periksa Pembayaran UKT</a>
                </form>
            </div>
        </div>

        <!-- HASIL -->
        <div class="panel-bottom">
            <div class="result-header">
                <h3>Hasil Konversi</h3>
            </div>

            <div class="resultBox">
                <?php if ($error != ""): ?>
                    <div class="error-message">
                        <?php echo $error; ?>
                    </div>

                <?php elseif ($hurufMutu != ""): ?>
                    <div class="result-content">
                        <span class="grade <?php echo $gradeClass; ?>">
                            <?php echo $hurufMutu; ?>
                        </span>
                        <?php
                        if ($status == "Lulus") {
                            echo "<span class='status-lulus'>" . $status . "</span>";
                        } else {
                            echo "<span class='status-gagal'>" . $status . "</span>";
                        }
                        ?>
                        <div class="container-data-mhs">
                            <p class="nama-display"><?php echo $nama; ?></p>
                            <p class="nim-display"><?php echo $nim; ?></p>
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