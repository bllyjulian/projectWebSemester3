<?php
require_once('../admin/crudphp/koneksi.php');
header('Content-Type: application/json;charset=utf8');

if(isset($_GET['username'])){
    $username = $_GET['username'];
    $query = $koneksi->prepare("SELECT * FROM tb_user WHERE username = :username");
    $query->bindParam(':username', $username);
    $query->execute();

    $result = array();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
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
    $query = $koneksi->query("SELECT * FROM tb_user");

    $result = array();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
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
?>
