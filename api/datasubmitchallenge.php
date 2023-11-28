<?php
require_once('connection.php');
header('Content-Type: application/json;charset=utf8');

if (empty($_GET)) {
    $query = mysqli_query($connection, "SELECT 
        sc.keterangan, 
        sc.linkpengumpulan, 
        sc.username, 
        sc.id_challenge, 
        sc.id_status,
        c.soal,
        c.tropi,
        c.koin,
        c.id_challenge,
        c.kuota,
        c.id_jenis,
        c.id_lvlchallenge,
        c.timestamp
    FROM 
        tb_submitchallenge AS sc
    JOIN 
        tb_challenge AS c ON sc.id_challenge = c.id_challenge");

    $result = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = array(
            'keterangan' => $row['keterangan'],
            'linkpengumpulan' => $row['linkpengumpulan'],
            'username' => $row['username'],
            'id_challenge' => $row['id_challenge'],
            'id_status' => $row['id_status'],
            'soal' => $row['soal'],
            'tropi' => $row['tropi'],
            'koin' => $row['koin'],
            'kuota' => $row['kuota'],
            'id_jenis' => $row['id_jenis'],
            'id_lvlchallenge' => $row['id_lvlchallenge'],
            'timestamp' => $row['timestamp']
        );
    }
    echo json_encode($result);
} elseif (isset($_GET['username'])) {
    $username = mysqli_real_escape_string($connection, $_GET['username']);
    if (isset($_GET['id_status'])) {
        $id_status = mysqli_real_escape_string($connection, $_GET['id_status']);
        $query = mysqli_query($connection, "SELECT 
            sc.keterangan, 
            sc.linkpengumpulan, 
            sc.username, 
            sc.id_challenge, 
            sc.id_status,
            c.soal,
            c.tropi,
            c.koin,
            c.id_challenge,
            c.kuota,
            c.id_jenis,
            c.id_lvlchallenge,
            c.timestamp
        FROM 
            tb_submitchallenge AS sc
        JOIN 
            tb_challenge AS c ON sc.id_challenge = c.id_challenge
        WHERE 
            sc.username='$username' AND sc.id_status='$id_status'");

        $result = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        echo json_encode($result);
    } else {
        $query = mysqli_query($connection, "SELECT 
            sc.keterangan, 
            sc.linkpengumpulan, 
            sc.username, 
            sc.id_challenge, 
            sc.id_status,
            c.soal,
            c.tropi,
            c.koin,
            c.id_challenge,
            c.kuota,
            c.id_jenis,
            c.id_lvlchallenge,
            c.timestamp
        FROM 
            tb_submitchallenge AS sc
        JOIN 
            tb_challenge AS c ON sc.id_challenge = c.id_challenge
        WHERE 
            sc.username='$username'");

        $result = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        echo json_encode($result);
    }
} else {
    echo json_encode(['error' => 'Invalid parameters']);
}

mysqli_close($connection);
?>
