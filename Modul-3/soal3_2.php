<?php
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

// Tampilkan format array[cite: 2]
$formatted = array();
foreach ($weight as $key => $val) {
    $formatted[] = '"' . $key . '"=>"' . $val . '"';
}
echo 'weight = (' . implode(', ', $formatted) . ')<br>';

// Mengambil data kedua menggunakan array_values[cite: 2]
$values = array_values($weight);
echo "Data kedua: " . $values[1];
?>