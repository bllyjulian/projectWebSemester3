<?php
require_once('connection.php');

header('Content-Type: application/json;charset=utf8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    if (
        isset($input['subtotal']) &&
        isset($input['koin_dipakai']) &&
        isset($input['total']) &&
        isset($input['username']) &&
        isset($input['id_modul']) &&
        isset($input['id_pembayaran'])
    ) {
        $subtotal = mysqli_real_escape_string($connection, $input['subtotal']);
        $koin_dipakai = mysqli_real_escape_string($connection, $input['koin_dipakai']);
        $total = mysqli_real_escape_string($connection, $input['total']);
        $username = mysqli_real_escape_string($connection, $input['username']);
        $id_modul = mysqli_real_escape_string($connection, $input['id_modul']);
        $id_pembayaran = mysqli_real_escape_string($connection, $input['id_pembayaran']);

        // Mengambil tanggal sekarang dalam format yang diinginkan (misalnya, TCCYYMMDD)
        $prefix = 'TCC' . date('ymd');

        $query = mysqli_query($connection, "SELECT COUNT(*) AS total_transaksi FROM tb_transaksi WHERE id_transaksi LIKE '$prefix%'");
        $result = mysqli_fetch_assoc($query);
        $num = str_pad($result['total_transaksi'] + 1, 3, '0', STR_PAD_LEFT); // Format nomor urut dengan panjang 3 digit

        $id_transaksi = $prefix . $num;

        // Set status ke "Belum Dibayar"
        $status = '1';
        $bukti_pembayaran = 'Belum Diisi';

        // Mulai transaksi
        mysqli_begin_transaction($connection);

        // Insert ke tabel transaksi
        $query_insert = mysqli_query($connection, "INSERT INTO tb_transaksi (id_transaksi, subtotal, koin_dipakai, total, id_status, bukti_pembayaran, username, id_modul, id_pembayaran) 
                                            VALUES ('$id_transaksi', '$subtotal', '$koin_dipakai', '$total', '$status', '$bukti_pembayaran', '$username', '$id_modul', '$id_pembayaran')");

        // Update jumlah koin pengguna di tabel tb_koin
        $query_update_koin = mysqli_query($connection, "UPDATE tb_koin SET koin = koin - '$koin_dipakai' WHERE username = '$username'");

        if ($query_insert && $query_update_koin) {
            // Commit transaksi jika semua query berhasil dieksekusi
            mysqli_commit($connection);
            $response = array('message' => 'Transaksi berhasil', 'id_transaksi' => $id_transaksi);
            echo json_encode($response);
        } else {
            // Rollback transaksi jika ada query yang gagal dieksekusi
            mysqli_rollback($connection);
            $response = array('message' => 'Transaksi gagal');
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