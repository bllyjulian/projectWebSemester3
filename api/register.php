<?php
require_once('connection.php');

header('Content-Type: application/json;charset=utf8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    if (
        isset($input['username']) &&
        isset($input['nama_lengkap']) &&
        isset($input['password']) &&
        isset($input['no_hp']) &&
        isset($input['email'])
    ) {
        $username = mysqli_real_escape_string($connection, $input['username']);
        $nama_lengkap = mysqli_real_escape_string($connection, $input['nama_lengkap']);
        $password = mysqli_real_escape_string($connection, $input['password']);
        $no_hp = mysqli_real_escape_string($connection, $input['no_hp']);
        $email = mysqli_real_escape_string($connection, $input['email']);
        $tgllahir = mysqli_real_escape_string($connection, $input['tanggal_lahir']);

        $query = mysqli_query($connection, "INSERT INTO tb_user (username, nama_lengkap, password, foto_profil, no_hp, email, jenis_kelamin, tanggal_lahir, id_lvl) 
                                            VALUES ('$usern', '$nama_lengkap', '$password', 'https://www.codingcamp.my.id/admin/crudphp/foto_profil/ppkosongv1.jpg', '$no_hp', '$email', 'Laki Laki', '$tgllahir', 'USR01')");

        if ($query) {
            $response = array('message' => 'Registrasi berhasil');
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
    $response = array('message' => 'Metode request tidak valid');
    echo json_encode($response);
}

mysqli_close($connection);


?>