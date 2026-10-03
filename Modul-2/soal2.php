<?php

// Inisialisasi array $matkul
$matkul = ["PTI", "ALPRO", "DPW", "STRUKDAT", "JARKOM", "PAW", "PSBF", "RPL"];

// Perulangan foreach dengan parameter alias ($value)
foreach ($matkul as $value) {
    // Pengecekan kondisi menggunakan switch
    switch ($value) {
        case "PTI":
            echo "Saya suka PTI<br>";
            break;
        case "ALPRO":
            echo "Saya suka ALPRO<br>";
            break;
        case "DPW":
            echo "Saya suka DPW<br>";
            break;
        case "STRUKDAT":
            echo "Saya suka STRUKDAT<br>";
            break;
        case "JARKOM":
            echo "Saya suka JARKOM<br>";
            break;
        case "PAW":
            echo "Saya suka PAW<br>";
            break;
        default:
            // Menggunakan parameter alias $value untuk menampilkan nama matkul
            echo "Saya tidak mengambil matkul " . $value . "<br>";
            break;
    }
}

?>