<?php
require_once('connection.php');
header('Content-Type: application/json;charset=utf8');

if (empty($_GET)) {
    $query = mysqli_query($connection, "SELECT tb_user.*, tb_koin.koin, COUNT(tb_moduldimiliki.id_modul) AS jumlah_modul 
        FROM tb_user 
        LEFT JOIN tb_koin ON tb_user.username = tb_koin.username 
        LEFT JOIN tb_moduldimiliki ON tb_user.username = tb_moduldimiliki.username 
        GROUP BY tb_user.username");

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
            'koin' => $row['koin'],
            'jumlah_modul' => $row['jumlah_modul']
        );
    }
    echo json_encode($result);
} else {
    $username = mysqli_real_escape_string($connection, $_GET['username']);
    $query = mysqli_prepare($connection, "SELECT tb_user.*, tb_koin.koin, COUNT(tb_moduldimiliki.id_modul) AS jumlah_modul 
        FROM tb_user 
        LEFT JOIN tb_koin ON tb_user.username = tb_koin.username 
        LEFT JOIN tb_moduldimiliki ON tb_user.username = tb_moduldimiliki.username 
        WHERE tb_user.username = ? 
        GROUP BY tb_user.username");

    mysqli_stmt_bind_param($query, 's', $username);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);

    $user_data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $user_data[] = array(
            'username' => $row['username'],
            'password' => $row['password'],
            'nama_lengkap' => $row['nama_lengkap'],
            'foto_profil' => $row['foto_profil'],
            'no_hp' => $row['no_hp'],
            'email' => $row['email'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'id_lvl' => $row['id_lvl'],
            'waktu_ditambahkan' => $row['timestamp'],
            'koin' => $row['koin'],
            'jumlah_modul' => $row['jumlah_modul']
        );
    }
    echo json_encode($user_data);
}

mysqli_close($connection);
?>
