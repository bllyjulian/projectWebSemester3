<?php
require_once('connection.php');
header('Content-Type: application/json;charset=utf8');

if (empty($_GET)) {
    $query = mysqli_query($connection, "SELECT * FROM tb_tugasakhir");

    $result = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = array(
          'id_tugasAkhir' => $row['id_tugasAkhir'],
          'keterangan' => $row['keterangan'],
          'id_modul' => $row['id_modul']
        );
    }
    echo json_encode($result);
} else {
  $id = mysqli_real_escape_string($connection, $_GET['id_modul']);
  $query = mysqli_query($connection, "SELECT * FROM tb_tugasakhir WHERE id_modul='$id'");

  $result = array();
  while ($row = mysqli_fetch_assoc($query)) {
    $result[] = array(
      'id_tugasAkhir' => $row['id_tugasAkhir'],
      'keterangan' => $row['keterangan'],
      'id_modul' => $row['id_modul']
    );
  }
  header('Content-Type: application/json;charset=utf8');
  echo json_encode($result);
}

mysqli_close($connection);
?>
