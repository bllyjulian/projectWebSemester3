<?php
    $billy = "local";

    if ($billy === "local") {
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $db   = 'codingcamp1';
    } else {
        $host = 'localhost';
        $user = 'codingc1_bllly';
        $pass = 'Soekamti@08';
        $db   = 'codingc1_camp';
    }
    
    try {
        $koneksi = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    


?>