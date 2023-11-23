<?php
require_once('connection.php');

header('Content-Type: application/json;charset=utf8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    if (
        isset($input['username'])
    ) {
        $username = mysqli_real_escape_string($connection, $input['username']);


        $query = mysqli_query($connection, "SELECT * FROM tb_akun WHERE username ='$username' ");

        if ($query) {
            $response = array('message' => 'data tampil berhasil');
            echo json_encode($response);
        } else {
            $response = array('message' => 'Registrasi gagal');
            echo json_encode($response);
        }
    } else {
        $response = array('message' => 'Data tidak lengkap');
        echo json_encode($response);
    }
} else {
    $response = array('message' => 'belum ada yg diklik');
    echo json_encode($response);
}

mysqli_close($connection);


?>