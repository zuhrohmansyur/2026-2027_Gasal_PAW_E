<?php
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");

// Tambah 5 data baru
$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

// Format tampilan awal array
$formatted = array();
foreach ($height as $key => $val) {
    $formatted[] = '"' . $key . '"=>"' . $val . '"';
}
echo 'height = (' . implode(', ', $formatted) . ')<br>';

// Perulangan foreach
foreach ($height as $name => $h) {
    echo "$name is $h cm tall.<br>";
}
?>