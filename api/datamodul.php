<?php
  require_once('connection.php');
header ('Content-Type: application/json;charset=utf8');
  if(empty($_GET)){
    $query = mysqli_query($connection, "SELECT * FROM tb_modul");
  
    $result = array();
    while($row = mysqli_fetch_assoc($query)){
      $result[] = array(
        'id_modul' => $row['id_modul'],
        'judul' => $row['judul'],
        'keterangan' => $row['keterangan'],
        'gambar' => $row['gambar'],
        'tujuan' => $row['tujuan'],
        'harga' => $row['harga'],
        'id_jenismodul' => $row['id_jenismodul']
      );
    }
    echo json_encode($result);
  } else {
    // Note: Always use prepared statements for security.
    $idmodul = mysqli_real_escape_string($connection, $_GET['id_modul']);
    $idjenismodul = mysqli_real_escape_string($connection, $_GET['id_jenismodul']);
    $query = mysqli_query($connection, "SELECT * FROM tb_modul WHERE id_modul='$idmodul' OR id_jenismodul= '$idjenismodul'");
    
    $result = array();
    while($row = mysqli_fetch_assoc($query)){
      $result[] = array(
        'id_modul' => $row['id_modul'],
        'judul' => $row['judul'],
        'keterangan' => $row['keterangan'],
        'gambar' => $row['gambar'],
        'tujuan' => $row['tujuan'],
        'harga' => $row['harga'],
        'id_jenismodul' => $row['id_jenismodul']
      );
    }
    header ('Content-Type: application/json;charset=utf8');
    echo json_encode($result);
  }
  
  mysqli_close($connection);

  
?>