<?php
require_once('connection.php');

header('Content-Type: application/json;charset=utf8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    if (
        isset($input['id_transaksi']) &&
        isset($input['bukti_pembayaran'])
    ) {
        $id_transaksi = mysqli_real_escape_string($connection, $input['id_transaksi']);
        $bukti_pembayaran = mysqli_real_escape_string($connection, $input['bukti_pembayaran']);

        // Update hanya kolom bukti_pembayaran untuk id_transaksi tertentu
        $query = mysqli_prepare($connection, "UPDATE tb_transaksi SET bukti_pembayaran=? WHERE id_transaksi=?");
        mysqli_stmt_bind_param($query, 'ss', $bukti_pembayaran, $id_transaksi);
        $query_exec = mysqli_stmt_execute($query);

        if ($query_exec) {
            if (mysqli_stmt_affected_rows($query) > 0) {
                $response = array('message' => 'Update berhasil');
            } else {
                $response = array('message' => 'Data dengan ID transaksi tersebut tidak ditemukan');
            }
            echo json_encode($response);
        } else {
            $response = array('message' => 'Update gagal');
            echo json_encode($response);
        }

        mysqli_stmt_close($query); // Tutup prepared statement setelah selesai digunakan
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
