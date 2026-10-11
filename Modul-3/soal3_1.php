<?php
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");

// Tambahkan lima data baru
$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

// Helper fungsi untuk mencetak format array asosiatif[cite: 2]
function printArrayAssoc($arr) {
    $formatted = array();
    foreach ($arr as $key => $val) {
        $formatted[] = '"' . $key . '"=>"' . $val . '"';
    }
    return 'height = (' . implode(', ', $formatted) . ')';
}

// Menampilkan array[cite: 2]
echo printArrayAssoc($height) . "<br>";
echo "Nilai dengan indeks terakhir: " . end($height) . "<br><br>";

// Hapus satu data tertentu (misalnya Barry)[cite: 2]
unset($height["Barry"]);

// Menampilkan array dan indeks terakhir setelah dihapus[cite: 2]
echo printArrayAssoc($height) . "<br>";
echo "Nilai dengan indeks terakhir setelah dihapus: " . end($height);
?>