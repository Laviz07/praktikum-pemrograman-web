<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="action.php" method="post">
        <div>
            <label for="nama">Nama:</label><br>
            <input type="text" name="nama" id="nama" required placeholder="Masukkan Nama Anda"><br><br>
        </div>

        <div>
            <label for="umur">Umur:</label><br>
            <input type="number" name="umur" id="umur" required placeholder="Masukkan Umur Anda"><br><br>
        </div>

        <div>
            <label for="">Apakah Anda Punya KTP?</label><br>
            <input
                type="radio"
                name="ktp"
                value="true"
                id="punya-ktp"
                required />
            <label for="punya-ktp">Sudah</label><br>

            <input
                type="radio"
                name="ktp"
                value="false"
                required
                id="belum-ktp"/>
            <label for="belum-ktp">Belum</label><br><br>
        </div>
        <button type="submit" name="submit">Kirim</button>
    </form>
</body>

</html>