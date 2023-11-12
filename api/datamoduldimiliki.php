<?php
  require_once('connection.php');
  header ('Content-Type: application/json;charset=utf8');
  if(empty($_GET)){
    $query = mysqli_query($connection, "SELECT tb_moduldimiliki.username, tb_modul.id_modul, tb_modul.judul, tb_modul.gambar FROM tb_moduldimiliki JOIN tb_modul ON tb_moduldimiliki.id_modul = tb_modul.id_modul");
  
    $result = array();
    while($row = mysqli_fetch_assoc($query)){
      $result[] = array(
        'username' => $row['username'],
        'id_modul' => $row['id_modul'],
        'judul' => $row['judul'],
        'gambar' => $row['gambar']
      );
    }
    echo json_encode($result);
  } else {
    // Note: Always use prepared statements for security.
    $username = mysqli_real_escape_string($connection, $_GET['username']);
    $query = mysqli_query($connection, "SELECT tb_moduldimiliki.username, tb_modul.id_modul, tb_modul.judul, tb_modul.gambar FROM tb_moduldimiliki JOIN tb_modul ON tb_moduldimiliki.id_modul = tb_modul.id_modul WHERE tb_moduldimiliki.username='$username'");
    
    $result = array();
    while($row = mysqli_fetch_assoc($query)){
      $result[] = array(
        'username' => $row['username'],
        'id_modul' => $row['id_modul'],
        'judul' => $row['judul'],
        'gambar' => $row['gambar']
      );
    }
    echo json_encode($result);
  }
  
  mysqli_close($connection);

  
?>