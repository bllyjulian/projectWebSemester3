<?php
require_once('connection.php');

header('Content-Type: application/json;charset=utf8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    if (
        isset($input['id_transaksi']) &&
        isset($input['koin_dipakai']) &&
        isset($input['username'])
    ) {
        $id_transaksi = mysqli_real_escape_string($connection, $input['id_transaksi']);
        $koin_dipakai = mysqli_real_escape_string($connection, $input['koin_dipakai']);
        $username = mysqli_real_escape_string($connection, $input['username']);

        mysqli_begin_transaction($connection);

        // Ambil nilai koin_dipakai dari tb_transaksi berdasarkan id_transaksi
        $query_get_koin_dipakai = mysqli_query($connection, "SELECT koin_dipakai FROM tb_transaksi WHERE id_transaksi = '$id_transaksi'");
        $row = mysqli_fetch_assoc($query_get_koin_dipakai);
        $koin_dipakai = $row['koin_dipakai'];

        // Update jumlah koin pengguna di tabel tb_koin
        $query_update_koin = mysqli_query($connection, "UPDATE tb_koin SET koin = koin + '$koin_dipakai' WHERE username = '$username'");

        if ($query_update_koin) {
            // Update id_status pada tb_transaksi berdasarkan id_transaksi yang diberikan
            $query_update_status = mysqli_query($connection, "UPDATE tb_transaksi SET id_status = '5' WHERE id_transaksi = '$id_transaksi'");

            if ($query_update_status) {
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
