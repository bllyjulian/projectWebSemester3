<?php
require_once('connection.php');
header('Content-Type: application/json;charset=utf8');

if (empty($_GET)) {
    $query = mysqli_query($connection, "SELECT * FROM tb_subbab");

    $result = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = array(
            'id_subbab' => $row['id_subbab'],
            'nama_subbab' => htmlspecialchars($row['nama_subbab']),
            'pengantar' => htmlspecialchars($row['pengantar']),
            'id_bab' => $row['id_bab']
        );
    }
    echo json_encode($result);
} else {
    $idbabmodul = mysqli_real_escape_string($connection, $_GET['id_bab']);
    $query = mysqli_query($connection, "SELECT * FROM tb_subbab WHERE id_bab='$idbabmodul'");

    $result = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = array(
            'id_subbab' => $row['id_subbab'],
            'nama_subbab' => htmlspecialchars($row['nama_subbab']),
            'pengantar' => htmlspecialchars($row['pengantar']),
            'id_bab' => $row['id_bab']
        );
    }
    header('Content-Type: application/json;charset=utf8');
    echo json_encode($result);
}

mysqli_close($connection);
?>