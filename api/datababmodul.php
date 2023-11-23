<?php
require_once('connection.php');
header('Content-Type: application/json;charset=utf8');
if (empty($_GET)) {
  $query = mysqli_query($connection, "SELECT * FROM tb_bab");

  $result = array();
  while ($row = mysqli_fetch_assoc($query)) {
    $result[] = array(
      'id_bab' => $row['id_bab'],
      'nama_bab' => $row['nama_bab'],
      'id_modul' => $row['id_modul']
    );
  }
  echo json_encode($result);
} else {
  // Note: Always use prepared statements for security.
  $idmodul = mysqli_real_escape_string($connection, $_GET['id_modul']);
  $query = mysqli_query($connection, "SELECT * FROM tb_bab WHERE id_modul='$idmodul'");

  $result = array();
  while ($row = mysqli_fetch_assoc($query)) {
    $result[] = array(
      'id_bab' => $row['id_bab'],
      'nama_bab' => $row['nama_bab'],
      'id_modul' => $row['id_modul']
    );
  }
  header('Content-Type: application/json;charset=utf8');
  echo json_encode($result);
}

mysqli_close($connection);


?>