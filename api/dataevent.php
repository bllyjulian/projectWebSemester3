<?php
require_once('connection.php');

if (empty($_GET)) {
  $query = mysqli_query($connection, "SELECT * FROM tb_event");

  $result = array();
  while ($row = mysqli_fetch_assoc($query)) {
    $result[] = array(
      'id_event' => $row['id_event'],
      'judul_event' => $row['judul_event'],
      'kuota' => $row['kuota'],
      'pelaksanaan' => $row['pelaksanaan'],
      'keterangan' => $row['keterangan'],
      'lokasi' => $row['lokasi'],
      'link_pendaftaran' => $row['link_pendaftaran'],
      'gambar' => $row['gambar'],
      'tanggal' => $row['tanggal']
    );
  }
  header('Content-Type: application/json;charset=utf8');
  echo json_encode($result);
} else {
  // Note: Always use prepared statements for security.
  $id = mysqli_real_escape_string($connection, $_GET['id_event']);
  $query = mysqli_query($connection, "SELECT * FROM tb_event WHERE id_event='$id'");

  $result = array();
  while ($row = mysqli_fetch_assoc($query)) {
    $result[] = array(
      'id_event' => $row['id_event'],
      'judul_event' => $row['judul_event'],
      'kuota' => $row['kuota'],
      'pelaksanaan' => $row['pelaksanaan'],
      'keterangan' => $row['keterangan'],
      'lokasi' => $row['lokasi'],
      'link_pendaftaran' => $row['link_pendaftaran'],
      'gambar' => $row['gambar'],
      'tanggal' => $row['tanggal']
    );
  }
  header('Content-Type: application/json;charset=utf8');
  echo json_encode($result);
}

mysqli_close($connection);


?>