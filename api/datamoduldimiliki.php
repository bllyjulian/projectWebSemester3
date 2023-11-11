<?php
  require_once('connection.php');
  header ('Content-Type: application/json;charset=utf8');
  if(empty($_GET)){
    $query = mysqli_query($connection, "SELECT * FROM tb_moduldimiliki");
  
    $result = array();
    while($row = mysqli_fetch_assoc($query)){
      $result[] = array(
        'username' => $row['username'],
        'id_modul' => $row['id_modul']
      );
    }
    echo json_encode($result);
  } else {
    // Note: Always use prepared statements for security.
    $username = mysqli_real_escape_string($connection, $_GET['username']);
    $query = mysqli_query($connection, "SELECT * FROM tb_moduldimiliki WHERE username='$username'");
    
    $result = array();
    while($row = mysqli_fetch_assoc($query)){
      $result[] = array(
        'username' => $row['username'],
        'id_modul' => $row['id_modul']
      );
    }
    echo json_encode($result);
  }
  
  mysqli_close($connection);

  
?>