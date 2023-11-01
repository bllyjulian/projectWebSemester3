<?php
  require_once('connection.php');
  
  if(empty($_GET)){
    $query = mysqli_query($connection, "SELECT * FROM tb_jenismodul");
    
    $result = array();
    while($row = mysqli_fetch_assoc($query)){
      $result[] = array(
        'id_jenismodul' => $row['id_jenismodul'],
        'nama_jenis' => $row['nama_jenis'],
        'gambar' => $row['gambar']
      );
    }
    header ('Content-Type: application/json;charset=utf8');
    echo json_encode($result);
  } else {
    // Note: Always use prepared statements for security.
    $id = mysqli_real_escape_string($connection, $_GET['id_jenismodul']);
    $query = mysqli_query($connection, "SELECT * FROM tb_jenismodul WHERE id_jenismodul='$id'");
    
    $result = array();
    while($row = mysqli_fetch_assoc($query)){
      $result[] = array(
        'id_jenismodul' => $row['id_jenismodul'],
        'nama_jenis' => $row['nama_jenis'],
        'gambar' => $row['gambar']
      );
    }
    header ('Content-Type: application/json;charset=utf8');
    echo json_encode($result);
  }
  
  mysqli_close($connection);

  
?>