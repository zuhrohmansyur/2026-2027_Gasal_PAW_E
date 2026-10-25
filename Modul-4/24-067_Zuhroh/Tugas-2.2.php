<?php
require 'validate.inc';

$errors = array();
$status = "";

if (isset($_POST['surname'])) {
    // Tambahkan variabel $errors sebagai parameter pertama (total 3 parameter)
    validateName($errors, $_POST, 'surname');
    
    if (!$errors) {
        $status = 'Data OK!';
    } else {
        $status = 'Data invalid!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tugas-2.2</title>
</head>
<body>
    <h3>Pengujian Validasi Server-side (Langkah #2)</h3>

    <?php if ($status != ""): ?>
        <p><b>Status: <?php echo $status; ?></b></p>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <label>Surname:</label>
        <input type="text" name="surname" value="<?php echo isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : ''; ?>">
        <input type="submit" value="Submit">
    </form>
</body>
</html>