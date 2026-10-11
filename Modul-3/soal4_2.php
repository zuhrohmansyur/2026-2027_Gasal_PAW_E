<?php
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

// Format cetak array[cite: 3]
$formatted = array();
foreach ($weight as $key => $val) {
    $formatted[] = '"' . $key . '"=>"' . $val . '"';
}
echo 'weight = (' . implode(', ', $formatted) . ')<br>';

// Mengakses array asosiatif menggunakan perulangan FOR[cite: 3]
$keys = array_keys($weight);
$arrlength = count($keys);

for ($i = 0; $i < $arrlength; $i++) {
    $key = $keys[$i];
    $val = $weight[$key];
    echo "$key is $val kg.<br>";
}
?>