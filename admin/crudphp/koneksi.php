<?php
$billy = "hosting";

try {
    if ($billy === "hosting") {
        $host = 'localhost';
        $user = 'id21327863_blly';
        $pass = 'Blly@2003';
        $db   = 'id21327863_codingcamp';
    } else {
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $db   = 'codingcamp';
    }

    $koneksi = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Jika koneksi pertama gagal, coba koneksi kedua
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db   = 'codingcamp';

    $koneksi = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

?>