<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

// Menambahkan 5 data baru menggunakan perulangan for[cite: 1]
for ($i = 1; $i <= 5; $i++) {
    $fruits[] = "Buah Tambahan " . $i;
}

// Menampilkan panjang array
$arrlength = count($fruits);
echo "Panjang array saat ini: " . $arrlength . "<br><br>";

// Menampilkan seluruh data[cite: 1]
for ($x = 0; $x < $arrlength; $x++) {
    echo $fruits[$x];
    echo "<br>";
}
?>