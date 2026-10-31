<?php
include 'koneksi.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: tugas-2.php");
    exit;
}

$id = $_GET['id'];


$stmt = $DBH->prepare("SELECT * FROM supplier WHERE supplier_id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();

if (!$row) {
    header("Location: tugas-2.php");
    exit;
}

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $sql = "UPDATE supplier SET nama = ?, telp = ?, alamat = ? WHERE supplier_id = ?";
    $stmtUpdate = $DBH->prepare($sql);
    $stmtUpdate->execute([$nama, $telp, $alamat, $id]);

    header("Location: tugas-2.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Master Supplier</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; margin: 30px; color: #333; }
        h3 { color: #5b9bd5; font-weight: normal; font-size: 24px; margin-bottom: 5px; }
        hr { border: 0; border-top: 1px solid #eee; margin-bottom: 25px; }
        table { border-collapse: collapse; }
        td { padding: 8px 10px; font-size: 14px; }
        td.label { font-weight: bold; text-align: right; width: 100px; color: #444; }
        input[type="text"] { width: 300px; padding: 6px 8px; border: 1px solid #ccc; border-radius: 3px; font-size: 14px; color: #555; }
        .btn-update { background-color: #5cb85c; color: white; border: 1px solid #4cae4c; padding: 6px 16px; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .btn-batal { background-color: #d9534f; color: white; border: 1px solid #d43f3a; padding: 6px 16px; text-decoration: none; border-radius: 4px; font-size: 14px; display: inline-block; }
    </style>
</head>
<body>

    <h3>Edit Data Master Supplier</h3>
    <hr>
    
    <form method="POST">
        <table>
            <tr>
                <td class="label">Nama</td>
                <td><input type="text" name="nama" value="<?= htmlspecialchars($row['nama']); ?>" required></td>
            </tr>
            <tr>
                <td class="label">Telp</td>
                <td><input type="text" name="telp" value="<?= htmlspecialchars($row['telp']); ?>" required></td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td><input type="text" name="alamat" value="<?= htmlspecialchars($row['alamat']); ?>" required></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-top: 15px;">
                    <button type="submit" name="update" class="btn-update">Update</button>
                    <a href="tugas-2.php" class="btn-batal">Batal</a>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>