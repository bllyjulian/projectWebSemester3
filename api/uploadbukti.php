<?php
require_once('connection.php');

header('Content-Type: application/json;charset=utf8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (
        isset($_POST['id_transaksi']) &&
        isset($_FILES['bukti_pembayaran']['name'])
    ) {
        $id_transaksi = mysqli_real_escape_string($connection, $_POST['id_transaksi']);

        $bukti_pembayaran = $_FILES['bukti_pembayaran']['name'];
        $ext = pathinfo($bukti_pembayaran, PATHINFO_EXTENSION);
        $nama_baru = md5($bukti_pembayaran . time()) . '.' . $ext;

        $folder_tujuan = '../admin/crudphp/buktipembayaran/';
        $path_gambar = $folder_tujuan . $nama_baru;

        if (move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $path_gambar)) {

            $url_gambar = 'https://codingcamp.myhost.id/admin/crudphp/buktipembayaran/' . $nama_baru;

            $sql = "UPDATE tb_transaksi SET bukti_pembayaran=? WHERE id_transaksi=?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("ss", $url_gambar, $id_transaksi);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response = array('message' => 'Update berhasil');
                echo json_encode($response);
            } else {
                $response = array('message' => 'Data dengan ID transaksi tersebut tidak ditemukan atau tidak ada perubahan yang dilakukan');
                echo json_encode($response);
            }
        } else {
            $response = array('message' => 'Gagal mengunggah file');
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
