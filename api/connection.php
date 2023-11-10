<?php

$billy = "local"; // Ganti dengan "hosting" jika Anda ingin menggunakan koneksi hosting

try {
    if ($billy === "local") {
      $host = 'localhost';
      $user = 'codingc1_bllly';
      $pass = 'Soekamti@08';
      $db   = 'codingc1_camp';
    } else {
      $host = 'localhost';
      $user = 'root';
      $pass = '';
      $db   = 'codingcamp';
    }

    $connection = mysqli_connect($host, $user, $pass, $db);

    if (!$connection) {
        throw new Exception("Unable to connect to the database: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    // Jika koneksi pertama gagal, coba koneksi kedua
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db   = 'codingcamp';

    $connection = mysqli_connect($host, $user, $pass, $db);

    if (!$connection) {
        die('Unable to connect to the database: ' . mysqli_connect_error());
    }
}

?>
