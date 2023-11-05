<?php
$billy = "local";

try {
    if ($billy === "local") {
        define('HOST', 'localhost');
        define('USER', 'root');
        define('PASS', '');
        define('DB', 'codingcamp1');
    } else {
        define('HOST', 'localhost');
        define('USER', 'codingc1_bllly');
        define('PASS', 'Soekamti@08');
        define('DB', 'codingc1_camp');
    }

    $connection = mysqli_connect(HOST, USER, PASS, DB);

    if (!$connection) {
        throw new Exception("Unable to connect to the database: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    // Jika koneksi pertama gagal, coba koneksi kedua
    define('HOST', 'localhost');
    define('USER', 'codingc1_bllly');
    define('PASS', 'Soekamti@08');
    define('DB', 'codingc1_camp');

    $connection = mysqli_connect(HOST, USER, PASS, DB);

    if (!$connection) {
        die('Unable to connect to the database: ' . mysqli_connect_error());
    }
}

?>