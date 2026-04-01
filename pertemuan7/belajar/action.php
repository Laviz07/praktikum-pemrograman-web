<?php
$umur = htmlspecialchars($_POST['umur']);
$nama = htmlspecialchars($_POST['nama']);
$ktp = $_POST['ktp'];

if (isset($_POST['submit'])) {

    if (empty($_POST['nama'])) {
        echo "Nama tidak boleh kosong";
    } else if (empty($_POST['umur'])) {
        echo "umur tidak boleh kosong";
    } else if (empty($_POST['ktp'])) {
        echo "Pilih Status Kepemilikan KTP terlebih dahulu";
    } else {
        echo "Nama: " . $nama . "<br>";
        echo "Umur: " . $umur . "<br>";

        if ($umur >= 18 && $ktp == "true") {
            echo "KTP: Sudah Punya KTP<br><br>";
            echo "Anda boleh memilih";
        } else {
            echo "KTP: Belum Punya KTP<br><br>";
            echo "Anda belum boleh memilih";
        }
    }
}
