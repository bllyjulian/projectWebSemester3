<?php

  $billy = "local";

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
  
  $connection = mysqli_connect(HOST, USER, PASS, DB) or die('Unable connect');
?>