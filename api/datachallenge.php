<?php
require_once('connection.php');
header('Content-Type: application/json;charset=utf8');

if (empty($_GET)) {
    $query = mysqli_query($connection, "SELECT 
        c.id_challenge,
        c.soal,
        c.tropi,
        c.koin,
        c.kuota,
        c.id_jenis,
        c.id_lvlchallenge,
        lc.jenis_lvl,
        jc.nama_jenis
    FROM 
        tb_challenge c
    LEFT JOIN 
        tb_lvlchallenge lc ON c.id_lvlchallenge = lc.id_lvlchallenge
    LEFT JOIN 
        tb_jenischallenge jc ON c.id_jenis = jc.id_jenis");

    $result = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = $row;
    }
    echo json_encode($result);
} else {
    if (isset($_GET['id_challenge'])) {
        $id_challenge = mysqli_real_escape_string($connection, $_GET['id_challenge']);
        $query = mysqli_query($connection, "SELECT 
            c.id_challenge,
            c.soal,
            c.tropi,
            c.koin,
            c.kuota,
            c.id_jenis,
            c.id_lvlchallenge,
            lc.jenis_lvl,
            jc.nama_jenis
        FROM 
            tb_challenge c
        LEFT JOIN 
            tb_lvlchallenge lc ON c.id_lvlchallenge = lc.id_lvlchallenge
        LEFT JOIN 
            tb_jenischallenge jc ON c.id_jenis = jc.id_jenis
        WHERE c.id_challenge='$id_challenge'");

        $result = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        echo json_encode($result);
    } elseif (isset($_GET['id_lvlchallenge'])) {
        $id_lvlchallenge = mysqli_real_escape_string($connection, $_GET['id_lvlchallenge']);
        $query = mysqli_query($connection, "SELECT 
            c.id_challenge,
            c.soal,
            c.tropi,
            c.koin,
            c.kuota,
            c.id_jenis,
            c.id_lvlchallenge,
            lc.jenis_lvl,
            jc.nama_jenis
        FROM 
            tb_challenge c
        LEFT JOIN 
            tb_lvlchallenge lc ON c.id_lvlchallenge = lc.id_lvlchallenge
        LEFT JOIN 
            tb_jenischallenge jc ON c.id_jenis = jc.id_jenis
        WHERE c.id_lvlchallenge='$id_lvlchallenge'");

        $result = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        echo json_encode($result);
    } elseif (isset($_GET['id_jenis'])) {
        $id_jenis = mysqli_real_escape_string($connection, $_GET['id_jenis']);
        $query = mysqli_query($connection, "SELECT 
            c.id_challenge,
            c.soal,
            c.tropi,
            c.koin,
            c.kuota,
            c.id_jenis,
            c.id_lvlchallenge,
            lc.jenis_lvl,
            jc.nama_jenis
        FROM 
            tb_challenge c
        LEFT JOIN 
            tb_lvlchallenge lc ON c.id_lvlchallenge = lc.id_lvlchallenge
        LEFT JOIN 
            tb_jenischallenge jc ON c.id_jenis = jc.id_jenis
        WHERE c.id_jenis='$id_jenis'");

        $result = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        echo json_encode($result);
    } elseif (isset($_GET['username'])) {
        $username = mysqli_real_escape_string($connection, $_GET['username']);

        $query = mysqli_query($connection, "SELECT 
            c.id_challenge,
            c.soal,
            c.tropi,
            c.koin,
            c.kuota,
            c.id_jenis,
            c.id_lvlchallenge,
            lc.jenis_lvl,
            jc.nama_jenis
        FROM 
            tb_challenge c
        LEFT JOIN 
            tb_lvlchallenge lc ON c.id_lvlchallenge = lc.id_lvlchallenge
        LEFT JOIN 
            tb_jenischallenge jc ON c.id_jenis = jc.id_jenis
        WHERE c.id_challenge NOT IN (
            SELECT id_challenge FROM tb_submitchallenge WHERE username = '$username'
        )");

        $result = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'Invalid parameters']);
    }
}

mysqli_close($connection);
?>
