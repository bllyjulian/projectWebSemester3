<?php
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari request
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $nama_lengkap = mysqli_real_escape_string($connection, $_POST['nama_lengkap']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password for security
    $foto_profil = base64_encode($_POST['foto_profil']);
    $no_hp = mysqli_real_escape_string($connection, $_POST['no_hp']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $status = mysqli_real_escape_string($connection, $_POST['status']);
    $id_lvl = mysqli_real_escape_string($connection, $_POST['id_lvl']);

    // Insert data ke database
    $query = mysqli_query($connection, "INSERT INTO tb_akun (username, nama_lengkap, password, foto_profil, no_hp, email, status, id_lvl) 
                                        VALUES ('$username', '$nama_lengkap', '$password', '$foto_profil', '$no_hp', '$email', '$status', '$id_lvl')");

    if ($query) {
        $response = array('message' => 'Registrasi berhasil');
        echo json_encode($response);
    } else {
        $response = array('message' => 'Registrasi gagal');
        echo json_encode($response);
    }
} else {
    $response = array('message' => 'Metode request tidak valid');
    echo json_encode($response);
}

mysqli_close($connection);
?>
