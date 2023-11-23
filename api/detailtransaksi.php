<?php
require_once('connection.php');
header('Content-Type: application/json;charset=utf8');

if (empty($_GET)) {
    $query = mysqli_query($connection, "SELECT 
        tb_transaksi.id_transaksi,
        tb_transaksi.username,
        tb_metodepembayaran.nama_pembayaran,
        tb_metodepembayaran.no_rekening,
        tb_metodepembayaran.icon,
        tb_transaksi.total
    FROM 
        tb_transaksi
    JOIN 
        tb_metodepembayaran ON tb_transaksi.id_pembayaran = tb_metodepembayaran.id_pembayaran");

    $result = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = array(
            'id_transaksi' => $row['id_transaksi'],
            'username' => $row['username'],
            'nama_pembayaran' => $row['nama_pembayaran'],
            'no_rekening' => $row['no_rekening'],
            'icon' => $row['icon'],
            'total' => $row['total']
        );
    }
    echo json_encode($result);
} else {
    // Note: Always use prepared statements for security.
    $id_transaksi = mysqli_real_escape_string($connection, $_GET['id_transaksi']);
    $query = mysqli_query($connection, "SELECT 
    tb_transaksi.id_transaksi,
    tb_transaksi.username,
    tb_metodepembayaran.nama_pembayaran,
    tb_metodepembayaran.no_rekening,
    tb_metodepembayaran.icon,
    tb_transaksi.total
FROM 
    tb_transaksi
JOIN 
    tb_metodepembayaran ON tb_transaksi.id_pembayaran = tb_metodepembayaran.id_pembayaran WHERE tb_transaksi.id_transaksi='$id_transaksi'");

    $result = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = array(
          'id_transaksi' => $row['id_transaksi'],
          'username' => $row['username'],
          'nama_pembayaran' => $row['nama_pembayaran'],
          'no_rekening' => $row['no_rekening'],
          'icon' => $row['icon'],
          'total' => $row['total']
        );
    }
    echo json_encode($result);
}

mysqli_close($connection);
?>