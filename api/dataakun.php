<?php
  require_once('connection.php');
  header ('Content-Type: application/json;charset=utf8');
  if(empty($_GET)){
    $query = mysqli_query($connection, "SELECT * FROM tb_user");
  
    $result = array();
    while($row = mysqli_fetch_assoc($query)){
      $result[] = array(
        'username' => $row['username'],
        'password' => $row['password'],
        'nama_lengkap' => $row['nama_lengkap'],
        'foto_profil' => $row['foto_profil'],
        'no_hp' => $row['no_hp'],
        'email' => $row['email'],
        'jenis_kelamin' => $row['jenis_kelamin'],
        'id_lvl' => $row['id_lvl'],
        'waktu ditambahkan' => $row['timestamp']
      );
    }
    echo json_encode($result);
  } else {
    // Note: Always use prepared statements for security.
    $username = mysqli_real_escape_string($connection, $_GET['username']);
    $query = mysqli_query($connection, "SELECT * FROM tb_user WHERE username='$username'");
    
    $result = array();
    while($row = mysqli_fetch_assoc($query)){
      $result[] = array(
        'username' => $row['username'],
        'password' => $row['password'],
        'nama_lengkap' => $row['nama_lengkap'],
        'foto_profil' => $row['foto_profil'],
        'no_hp' => $row['no_hp'],
        'email' => $row['email'],
        'jenis_kelamin' => $row['jenis_kelamin'],
        'id_lvl' => $row['id_lvl'],
        'waktu ditambahkan' => $row['timestamp']
      );
    }
    echo json_encode($result);
  }
  
  mysqli_close($connection);

  
?>