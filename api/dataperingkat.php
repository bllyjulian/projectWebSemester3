<?php
require_once('connection.php');
header('Content-Type: application/json;charset=utf8');

if (empty($_GET)) {
    $query = mysqli_query($connection, "SELECT tb_user.username, tb_user.nama_lengkap, tb_user.foto_profil, tb_tropi.tropi, tb_tropi.tanggal
    FROM tb_user
    LEFT JOIN tb_tropi ON tb_user.username = tb_tropi.username  WHERE tb_tropi.tropi != 0
    ORDER BY tb_tropi.tropi DESC");

    $result = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = array(
            'username' => $row['username'],
            'foto_profil' => $row['foto_profil'],
            'tropi' => $row['tropi']
        );
    }
    echo json_encode($result);
} else {
    $username = mysqli_real_escape_string($connection, $_GET['username']);
    $query = mysqli_prepare($connection, "SELECT tb_user.username, tb_user.nama_lengkap, tb_user.foto_profil, tb_tropi.tropi, tb_tropi.tanggal
    FROM tb_user
    LEFT JOIN tb_tropi ON tb_user.username = tb_tropi.username
        WHERE tb_user.username = ? 
        ");

    mysqli_stmt_bind_param($query, 's', $username);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);

    $user_data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $user_data[] = array(
          'username' => $row['username'],
          'foto_profil' => $row['foto_profil'],
          'tropi' => $row['tropi']
        );
    }
    echo json_encode($user_data);
}

mysqli_close($connection);
?>
