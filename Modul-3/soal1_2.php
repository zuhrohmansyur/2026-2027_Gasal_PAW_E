<?php
$fruits = array("Avocado", "Blueberry", "Cherry", "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

// Hapus data 'Blueberry'
$key = array_search("Blueberry", $fruits);
if ($key !== false) {
    unset($fruits[$key]);
    echo "Data Blueberry dihapus.<br>";
}

// Menampilkan isi array
echo 'fruits = ("' . implode('", "', $fruits) . '")<br>';

// Menampilkan nilai dengan indeks tertinggi
$highestIndex = max(array_keys($fruits));
echo "Nilai dengan indeks tertinggi: " . $fruits[$highestIndex];
?>