<?php
  require_once('connection.php');
  
  if(empty($_GET)){
    $query = mysqli_query($connection, "SELECT * FROM tb_akun");
  
    $result = array();
    while($row = mysqli_fetch_assoc($query)){
      $result[] = array(
        'username' => $row['username'],
        'nama_lengkap' => $row['nama_lengkap'],
        'password' => $row['password'],
        'foto_profil' => $row['foto_profil'],
        'no_hp' => $row['no_hp'],
        'email' => $row['email'],
        'status' => $row['status'],
        'id_lvl' => $row['id_lvl']
      );
    }
    echo json_encode($result);
  } else {
    // Note: Always use prepared statements for security.
    $username = mysqli_real_escape_string($connection, $_GET['username']);
    $query = mysqli_query($connection, "SELECT * FROM tb_akun WHERE username='$username'");
    
    $result = array();
    while($row = mysqli_fetch_assoc($query)){
      $result[] = array(
        'username' => $row['username'],
        'nama_lengkap' => $row['nama_lengkap'],
        'password' => $row['password'],
        'foto_profil' => $row['foto_profil'],
        'no_hp' => $row['no_hp'],
        'email' => $row['email'],
        'status' => $row['status'],
        'id_lvl' => $row['id_lvl']
      );
    }
    echo json_encode($result);
  }
  
  mysqli_close($connection);

  
?>