<?php
require 'validate.inc';

$errors = array();

if (isset($_POST['surname'])) {
    validateName($errors, $_POST, 'surname');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengujian Akhir</title>
</head>
<body>

    <?php
    if (isset($_POST['surname'])) {
        if ($errors) {
            echo 'Errors: <br/>';
            foreach ($errors as $field => $error) {
                echo "$field $error<br/>";
            }
        } else {
            echo 'Data OK!';
        }
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <label>Surname:</label>
        <input type="text" name="surname" value="<?php echo isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : ''; ?>">
        <input type="submit" value="Submit">
    </form>
</body>
</html>