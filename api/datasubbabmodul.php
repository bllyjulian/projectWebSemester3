<?php
  require_once('connection.php');
header ('Content-Type: application/json;charset=utf8');
  if(empty($_GET)){
    $query = mysqli_query($connection, "SELECT * FROM tb_subbab");
  
    $result = array();
    while($row = mysqli_fetch_assoc($query)){
      $result[] = array(
        'id_subbab' => $row['id_subbab'],
        'nama_subbab' => $row['nama_subbab'],
        'pengantar' => $row['pengantar'],
        'id_ bab' => $row['id_bab']
      );
    }
    echo json_encode($result);
  } else {
    // Note: Always use prepared statements for security.
    $idbabmodul = mysqli_real_escape_string($connection, $_GET['id_bab']);
    $query = mysqli_query($connection, "SELECT * FROM tb_materi WHERE id_bab='$idbabmodul'");
    
    $result = array();
    while($row = mysqli_fetch_assoc($query)){
      $result[] = array(
        'id_subbab' => $row['id_subbab'],
        'nama_subbab' => $row['nama_subbab'],
        'pengantar' => $row['pengantar'],
        'id_ bab' => $row['id_bab']
      );
    }
    header ('Content-Type: application/json;charset=utf8');
    echo json_encode($result);
  }
  
  mysqli_close($connection);

  
?>