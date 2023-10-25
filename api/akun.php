<?php
header('Content-Type: application/json; charset=utf8');
$koneksi = mysqli_connect("localhost", "root", "", "codingcamp");

if($_SERVER['REQUEST METHOD'] === 'GET'){
  $sql = "select * from tb_akun";
  $query = mysqli_query($koneksi, $sql);
  $array_data = array();
  while($data = mysqli_fetch_assoc($query)){
    $array_data[] = $data;
  }
  echo json_encode($array_data);

}









?>