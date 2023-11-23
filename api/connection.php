<?php

$billy = "local";

try {
    if ($billy === "local") {
      $host = 'localhost';
      $user = 'codingca_billy';
      $pass = '#Blly2003';
      $db   = 'codingca_camp';
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
