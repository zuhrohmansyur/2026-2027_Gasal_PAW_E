<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $DBH->prepare("DELETE FROM supplier WHERE supplier_id = ?");
    $stmt->execute([$id]);
}

header("Location: tugas-2.php");
exit;
?>