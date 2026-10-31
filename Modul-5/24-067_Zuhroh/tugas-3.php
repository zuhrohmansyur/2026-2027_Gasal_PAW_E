<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $sql = "INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)";
    $stmt = $DBH->prepare($sql);
    $stmt->execute([$nama, $telp, $alamat]);

    header("Location: tugas-2.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Master Supplier Baru</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; margin: 30px; color: #333; }
        h3 { color: #5b9bd5; font-weight: normal; font-size: 24px; margin-bottom: 5px; }
        hr { border: 0; border-top: 1px solid #eee; margin-bottom: 25px; }
        table { border-collapse: collapse; }
        td { padding: 8px 10px; font-size: 14px; }
        td.label { font-weight: bold; text-align: right; width: 100px; color: #444; }
        input[type="text"] { width: 300px; padding: 6px 8px; border: 1px solid #ccc; border-radius: 3px; font-size: 14px; color: #555; }
        input[type="text"]::placeholder { color: #aaa; }
        .btn-simpan { background-color: #5cb85c; color: white; border: 1px solid #4cae4c; padding: 6px 16px; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .btn-batal { background-color: #d9534f; color: white; border: 1px solid #d43f3a; padding: 6px 16px; text-decoration: none; border-radius: 4px; font-size: 14px; display: inline-block; }
    </style>
</head>
<body>

    <h3>Tambah Data Master Supplier Baru</h3>
    <hr>
    
    <form method="POST">
        <table>
            <tr>
                <td class="label">Nama</td>
                <td><input type="text" name="nama" placeholder="Nama" required></td>
            </tr>
            <tr>
                <td class="label">Telp</td>
                <td><input type="text" name="telp" placeholder="telp" required></td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td><input type="text" name="alamat" placeholder="alamat" required></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-top: 15px;">
                    <button type="submit" name="simpan" class="btn-simpan">Simpan</button>
                    <a href="tugas-2.php" class="btn-batal">Batal</a>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>