<?php
$billy = "hosting";

try {
    if ($billy === "hosting") {

        $host = 'localhost';
        $user = 'codingca_codingca';
        $pass = 'Soekamti@08';
        $db   = 'codingca_camp';
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
