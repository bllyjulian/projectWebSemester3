<?php
require_once('connection.php');
header('Content-Type: application/json;charset=utf8');

if (empty($_GET)) {
    $query = mysqli_query($connection, "SELECT tb_statustugas.id_status, tb_statustugas.status_tugas,
    tb_submittugas.keterangan, tb_submittugas.username,
    tb_submittugas.id_modul, tb_submittugas.linkpengumpulan,
    tb_tugasakhir.id_tugasAkhir, tb_tugasakhir.keterangan AS soal,
    tb_tugasakhir.id_modul
FROM tb_statustugas
JOIN tb_submittugas ON tb_statustugas.id_status = tb_submittugas.id_status
JOIN tb_tugasakhir ON tb_submittugas.id_tugasAkhir = tb_tugasakhir.id_tugasAkhir");

    $result = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = $row;
    }
    echo json_encode($result);
} else {
    if (isset($_GET['username']) && isset($_GET['id_status'])) {
        $username = mysqli_real_escape_string($connection, $_GET['username']);
        $status = mysqli_real_escape_string($connection, $_GET['id_status']);

        $query = mysqli_query($connection, "SELECT tb_statustugas.id_status, tb_statustugas.status_tugas,
        tb_submittugas.keterangan, tb_submittugas.username,
        tb_submittugas.id_modul, tb_submittugas.linkpengumpulan,
        tb_tugasakhir.id_tugasAkhir, tb_tugasakhir.keterangan AS soal,
        tb_tugasakhir.id_modul
 FROM tb_statustugas
 JOIN tb_submittugas ON tb_statustugas.id_status = tb_submittugas.id_status
 JOIN tb_tugasakhir ON tb_submittugas.id_tugasAkhir = tb_tugasakhir.id_tugasAkhir 
        WHERE tb_submittugas.username='$username' AND tb_submittugas.id_status='$status'");

        $result = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        echo json_encode($result);
    } elseif (isset($_GET['username'])) {
        $username = mysqli_real_escape_string($connection, $_GET['username']);
        $query = mysqli_query($connection, "SELECT tb_statustugas.id_status, tb_statustugas.status_tugas,
        tb_submittugas.keterangan, tb_submittugas.username,
        tb_submittugas.id_modul, tb_submittugas.linkpengumpulan,
        tb_tugasakhir.id_tugasAkhir, tb_tugasakhir.keterangan AS soal,
        tb_tugasakhir.id_modul
 FROM tb_statustugas
 JOIN tb_submittugas ON tb_statustugas.id_status = tb_submittugas.id_status
 JOIN tb_tugasakhir ON tb_submittugas.id_tugasAkhir = tb_tugasakhir.id_tugasAkhir
        WHERE tb_submittugas.username='$username'");

        $result = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        echo json_encode($result);
    } elseif (isset($_GET['id_status'])) {
        $status = mysqli_real_escape_string($connection, $_GET['id_status']);
        $query = mysqli_query($connection, "SELECT tb_statustugas.id_status, tb_statustugas.status_tugas,
        tb_submittugas.keterangan, tb_submittugas.username,
        tb_submittugas.id_modul, tb_submittugas.linkpengumpulan,
        tb_tugasakhir.id_tugasAkhir, tb_tugasakhir.keterangan AS soal,
        tb_tugasakhir.id_modul
 FROM tb_statustugas
 JOIN tb_submittugas ON tb_statustugas.id_status = tb_submittugas.id_status
 JOIN tb_tugasakhir ON tb_submittugas.id_tugasAkhir = tb_tugasakhir.id_tugasAkhir
        WHERE tb_submittugas.id_status='$status'");

        $result = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        echo json_encode($result);
    } elseif (isset($_GET['id_tugasAkhir'])) {
        $id_tugas = mysqli_real_escape_string($connection, $_GET['id_tugasAkhir']);
        $query = mysqli_query($connection, "SELECT tb_statustugas.id_status, tb_statustugas.status_tugas,
        tb_submittugas.keterangan, tb_submittugas.username,
        tb_submittugas.id_modul, tb_submittugas.linkpengumpulan,
        tb_tugasakhir.id_tugasAkhir, tb_tugasakhir.keterangan AS soal,
        tb_tugasakhir.id_modul
 FROM tb_statustugas
 JOIN tb_submittugas ON tb_statustugas.id_status = tb_submittugas.id_status
 JOIN tb_tugasakhir ON tb_submittugas.id_tugasAkhir = tb_tugasakhir.id_tugasAkhir
        WHERE tb_submittugas.id_tugasAkhir='$id_tugas'");

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
