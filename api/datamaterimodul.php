<?php
require_once('connection.php');
header('Content-Type: application/json;charset=utf8');

if (empty($_GET)) {
    $query = mysqli_query($connection, "SELECT * FROM tb_materi");

    $result = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = array(
            'id_materi' => $row['id_materi'],
            'judul' => htmlspecialchars($row['judul']),
            'materi' => htmlspecialchars($row['materi']),
            'gambar' => htmlspecialchars($row['gambar']),
            'id_subbab' => $row['id_subbab']
        );
    }
    echo json_encode($result);
} else {
    // Always use prepared statements for security.
    $idsubbabmodul = mysqli_real_escape_string($connection, $_GET['id_subbab']);
    $query = mysqli_query($connection, "SELECT * FROM tb_materi WHERE id_subbab='$idsubbabmodul'");

    $result = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = array(
            'id_materi' => $row['id_materi'],
            'judul' => htmlspecialchars($row['judul']),
            'materi' => htmlspecialchars($row['materi']),
            'gambar' => htmlspecialchars($row['gambar']),
            'id_subbab' => $row['id_subbab']
        );
    }
    header('Content-Type: application/json;charset=utf8');
    echo json_encode($result);
}

mysqli_close($connection);
?>