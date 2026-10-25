<?php
echo "<h2>Hasil Pemrosesan Form (Tugas 1.3)</h2>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr><th>Field Name</th><th>Field Value</th></tr>";

// Menampilkan seluruh data POST yang dikirim dari Tugas-1.3.html
foreach ($_POST as $key => $value) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($key) . "</td>";
    echo "<td>" . htmlspecialchars($value) . "</td>";
    echo "</tr>";
}

echo "</table>";
?>