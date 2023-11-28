<?php
require_once('connection.php');
header('Content-Type: application/json;charset=utf8');

if (empty($_GET)) {
    $query = mysqli_query($connection, "SELECT * FROM tb_modul");

    $result = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = array(
            'id_modul' => $row['id_modul'],
            'judul' => $row['judul'],
            'keterangan' => $row['keterangan'],
            'gambar' => $row['gambar'],
            'tujuan' => $row['tujuan'],
            'harga' => $row['harga'],
            'id_jenismodul' => $row['id_jenismodul']
        );
    }
    echo json_encode($result);
} else {
    $username = mysqli_real_escape_string($connection, $_GET['username']);

    if (isset($_GET['id_jenismodul'])) {
        $id_jenismodul = mysqli_real_escape_string($connection, $_GET['id_jenismodul']);

        $query = mysqli_query($connection, "SELECT * FROM tb_modul 
            WHERE id_modul NOT IN (
                SELECT id_modul FROM tb_moduldimiliki WHERE username = '$username'
            ) AND id_jenismodul = '$id_jenismodul'");

        $result = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = array(
                'id_modul' => $row['id_modul'],
                'judul' => $row['judul'],
                'keterangan' => $row['keterangan'],
                'gambar' => $row['gambar'],
                'tujuan' => $row['tujuan'],
                'harga' => $row['harga'],
                'id_jenismodul' => $row['id_jenismodul']
            );
        }
        echo json_encode($result);
    } else {
        $query = mysqli_query($connection, "SELECT * FROM tb_modul 
            WHERE id_modul NOT IN (
                SELECT id_modul FROM tb_moduldimiliki WHERE username = '$username'
            )");

        $result = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = array(
                'id_modul' => $row['id_modul'],
                'judul' => $row['judul'],
                'keterangan' => $row['keterangan'],
                'gambar' => $row['gambar'],
                'tujuan' => $row['tujuan'],
                'harga' => $row['harga'],
                'id_jenismodul' => $row['id_jenismodul']
            );
        }
        echo json_encode($result);
    }
}

mysqli_close($connection);
?>
