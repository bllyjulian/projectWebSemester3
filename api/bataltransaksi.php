<?php
require_once('connection.php');

header('Content-Type: application/json;charset=utf8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    if (
        isset($input['id_transaksi'])
    ) {
        $id_transaksi = mysqli_real_escape_string($connection, $input['id_transaksi']);
        // Langsung set nilai $id_status ke 5
        $id_status = 5;
        
        mysqli_begin_transaction($connection);

        // Gunakan prepared statement untuk mencegah SQL Injection
        $query_update = mysqli_prepare($connection, "UPDATE tb_transaksi SET id_status = ? WHERE id_transaksi = ?");
        mysqli_stmt_bind_param($query_update, "ii", $id_status, $id_transaksi);
        $query_execution = mysqli_stmt_execute($query_update);

        // Update jumlah koin pengguna di tabel tb_koin
        // Jika berhasil dieksekusi
        if ($query_execution) {
            // Commit transaksi jika semua query berhasil dieksekusi
            mysqli_commit($connection);
            $response = array('message' => 'Transaksi berhasil dibatalkan');
            echo json_encode($response);
        } else {
            // Rollback transaksi jika ada query yang gagal dieksekusi
            mysqli_rollback($connection);
            $response = array('message' => 'Transaksi gagal dibatalkan');
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
