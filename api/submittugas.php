<?php
require_once('connection.php');

header('Content-Type: application/json;charset=utf8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    if (
        isset($input['username']) &&
        isset($input['id_modul']) &&
        isset($input['id_tugasAkhir']) &&
        isset($input['keterangan']) &&
        isset($input['linkpengumpulan'])
    ) {
        $username = mysqli_real_escape_string($connection, $input['username']);
        $id_modul = mysqli_real_escape_string($connection, $input['id_modul']);
        $id_tugas = mysqli_real_escape_string($connection, $input['id_tugasAkhir']);
        $keterangan = mysqli_real_escape_string($connection, $input['keterangan']);
        $linkpengumpulan = mysqli_real_escape_string($connection, $input['linkpengumpulan']);

        $status = '1';

        mysqli_begin_transaction($connection);

        $query_insert = mysqli_query($connection, "INSERT INTO tb_submittugas (linkpengumpulan, keterangan, id_modul, id_tugasAkhir, username, id_status) 
                                            VALUES ('$linkpengumpulan', '$keterangan', '$id_modul', '$id_tugas', '$username', '$status')");
        if ($query_insert) {

            mysqli_commit($connection);
            $response = array('message' => 'Berhasil Submit tugas');
            echo json_encode($response);
        } else {

            mysqli_rollback($connection);
            $response = array('message' => 'gagal submit');
            echo json_encode($response);
        }
    } else {
        $response = array('message' => 'Data tidak lengkap');
        echo json_encode($response);
    }
} else {
    $response = array('message' => 'Metode request tidak valid');
    echo json_encode($response);
}

mysqli_close($connection);
?>