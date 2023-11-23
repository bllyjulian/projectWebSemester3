<?php
require_once('connection.php');
header('Content-Type: application/json;charset=utf8');
if (empty($_GET)) {
  $query = mysqli_query($connection, "SELECT * FROM tb_metodepembayaran");

  $result = array();
  while ($row = mysqli_fetch_assoc($query)) {
    $result[] = array(
      'id_pembayaran' => $row['id_pembayaran'],
      'nama_pembayaran' => $row['nama_pembayaran'],
      'icon' => $row['icon'],
      'no_rekening' => $row['no_rekening']
    );
  }
  echo json_encode($result);
} else {
  // Note: Always use prepared statements for security.
  $idpembayaran = mysqli_real_escape_string($connection, $_GET['id_pembayaran']);
  $query = mysqli_query($connection, "SELECT * FROM tb_metodepembayaran WHERE id_pembayaran='$idpembayaran'");

  $result = array();
  while ($row = mysqli_fetch_assoc($query)) {
    $result[] = array(
      'id_pembayaran' => $row['id_pembayaran'],
      'nama_pembayaran' => $row['nama_pembayaran'],
      'icon' => $row['icon'],
      'no_rekening' => $row['no_rekening']
    );
  }
  echo json_encode($result);
}

mysqli_close($connection);


?>