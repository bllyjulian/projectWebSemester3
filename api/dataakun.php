<?php
require_once('connection.php');
header('Content-Type: application/json;charset=utf8');

if (empty($_GET)) {
    $query = mysqli_query($connection, "SELECT tb_user.*, tb_koin.koin FROM tb_user LEFT JOIN tb_koin ON tb_user.username = tb_koin.username");

    $result = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = array(
            'username' => $row['username'],
            'password' => $row['password'],
            'nama_lengkap' => $row['nama_lengkap'],
            'foto_profil' => $row['foto_profil'],
            'no_hp' => $row['no_hp'],
            'email' => $row['email'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'id_lvl' => $row['id_lvl'],
            'waktu_ditambahkan' => $row['timestamp'],
            'koin' => $row['koin']
        );
    }
    echo json_encode($result);
} else {

    $username = mysqli_real_escape_string($connection, $_GET['username']);
    $query = mysqli_query($connection, "SELECT tb_user.*, tb_koin.koin  FROM tb_user LEFT JOIN tb_koin ON tb_user.username = tb_koin.username WHERE tb_user.username='$username'");

    $result = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = array(
            'username' => $row['username'],
            'password' => $row['password'],
            'nama_lengkap' => $row['nama_lengkap'],
            'foto_profil' => $row['foto_profil'],
            'no_hp' => $row['no_hp'],
            'email' => $row['email'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'id_lvl' => $row['id_lvl'],
            'waktu_ditambahkan' => $row['timestamp'],
            'koin' => $row['koin']
        );
    }
    echo json_encode($result);
}

mysqli_close($connection);
?>