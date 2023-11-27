<?php
require_once('connection.php');

header('Content-Type: application/json;charset=utf8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    if (
        isset($input['username']) &&
        isset($input['id_challenge']) &&
        isset($input['keterangan']) &&
        isset($input['linkpengumpulan'])
    ) {
        $username = mysqli_real_escape_string($connection, $input['username']);
        $id_challenge = mysqli_real_escape_string($connection, $input['id_challenge']);
        $keterangan = mysqli_real_escape_string($connection, $input['keterangan']);
        $linkpengumpulan = mysqli_real_escape_string($connection, $input['linkpengumpulan']);

        $status = '1';

        mysqli_begin_transaction($connection);

        $query_insert = mysqli_query($connection, "INSERT INTO tb_submitchallenge (linkpengumpulan, keterangan, id_challenge, username, id_status) 
                                            VALUES ('$linkpengumpulan', '$keterangan', '$id_challenge', '$username', '$status')");
        if ($query_insert) {

            mysqli_commit($connection);
            $response = array('message' => 'Berhasil Submit');
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