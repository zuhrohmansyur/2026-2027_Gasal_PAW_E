<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

// Menambahkan 5 data baru
array_push($fruits, "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

// Menampilkan isi array
echo 'fruits = ("' . implode('", "', $fruits) . '")<br>';

// Menampilkan nilai dengan indeks tertinggi
$highestIndex = max(array_keys($fruits));
echo "Nilai dengan indeks tertinggi: " . $fruits[$highestIndex];
?>