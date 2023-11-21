<?php
require_once('connection.php');
header('Content-Type: application/json;charset=utf8');

if (empty($_GET)) {
    $query = mysqli_query($connection, "SELECT 
        tb_transaksi.id_transaksi,
        tb_transaksi.subtotal,
        tb_transaksi.koin_dipakai,
        tb_transaksi.total,
        tb_statustransaksi.jenis_status,
        tb_transaksi.username,
        tb_modul.judul,
        tb_modul.harga,
        tb_metodepembayaran.nama_pembayaran,
        tb_metodepembayaran.icon,
        tb_transaksi.tanggal_transaksi,
        tb_transaksi.id_status
    FROM 
        tb_transaksi
    JOIN 
        tb_statustransaksi ON tb_transaksi.id_status = tb_statustransaksi.id_status
    JOIN 
        tb_modul ON tb_transaksi.id_modul = tb_modul.id_modul
    JOIN 
        tb_metodepembayaran ON tb_transaksi.id_pembayaran = tb_metodepembayaran.id_pembayaran");

    $result = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = array(
            'id_transaksi' => $row['id_transaksi'],
            'subtotal' => $row['subtotal'],
            'koin_dipakai' => $row['koin_dipakai'],
            'total' => $row['total'],
            'jenis_status' => $row['jenis_status'],
            'username' => $row['username'],
            'judul' => $row['judul'],
            'harga' => $row['harga'],
            'nama_pembayaran' => $row['nama_pembayaran'],
            'icon' => $row['icon'],
            'tanggal_transaksi' => $row['tanggal_transaksi'],
            'id_status' => $row['id_status']
        );
    }
    echo json_encode($result);
}  else {
    // Note: Always use prepared statements for security.
    $status = mysqli_real_escape_string($connection, $_GET['id_status']);
    $query = mysqli_query($connection, "SELECT 
    tb_transaksi.id_transaksi,
    tb_transaksi.subtotal,
    tb_transaksi.koin_dipakai,
    tb_transaksi.total,
    tb_statustransaksi.jenis_status,
    tb_transaksi.username,
    tb_modul.judul,
    tb_modul.harga,
    tb_metodepembayaran.nama_pembayaran,
    tb_metodepembayaran.icon,
    tb_transaksi.tanggal_transaksi,
    tb_transaksi.id_status
FROM 
    tb_transaksi
JOIN 
    tb_statustransaksi ON tb_transaksi.id_status = tb_statustransaksi.id_status
JOIN 
    tb_modul ON tb_transaksi.id_modul = tb_modul.id_modul
JOIN 
    tb_metodepembayaran ON tb_transaksi.id_pembayaran = tb_metodepembayaran.id_pembayaran WHERE tb_transaksi.id_status='$status'");
    
    $result = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = array(
          'id_transaksi' => $row['id_transaksi'],
          'subtotal' => $row['subtotal'],
          'koin_dipakai' => $row['koin_dipakai'],
          'total' => $row['total'],
          'jenis_status' => $row['jenis_status'],
          'username' => $row['username'],
          'judul' => $row['judul'],
          'harga' => $row['harga'],
          'nama_pembayaran' => $row['nama_pembayaran'],
          'icon' => $row['icon'],
          'tanggal_transaksi' => $row['tanggal_transaksi'],
          'id_status' => $row['id_status']
        );
    }
    echo json_encode($result);
}

mysqli_close($connection);
?>
