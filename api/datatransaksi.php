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
        $result[] = $row;
    }
    echo json_encode($result);
} else {
    if (isset($_GET['username']) && isset($_GET['id_status'])) {
        $username = mysqli_real_escape_string($connection, $_GET['username']);
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
            tb_metodepembayaran ON tb_transaksi.id_pembayaran = tb_metodepembayaran.id_pembayaran 
        WHERE tb_transaksi.username='$username' AND tb_transaksi.id_status='$status'");

        $result = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        echo json_encode($result);
    } elseif (isset($_GET['username'])) {
        $username = mysqli_real_escape_string($connection, $_GET['username']);
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
            tb_metodepembayaran ON tb_transaksi.id_pembayaran = tb_metodepembayaran.id_pembayaran 
        WHERE tb_transaksi.username='$username'");

        $result = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        echo json_encode($result);
    } elseif (isset($_GET['id_status'])) {
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
            tb_metodepembayaran ON tb_transaksi.id_pembayaran = tb_metodepembayaran.id_pembayaran 
        WHERE tb_transaksi.id_status='$status'");

        $result = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        echo json_encode($result);
    } elseif (isset($_GET['id_transaksi'])) {
        $id_transaksi = mysqli_real_escape_string($connection, $_GET['id_transaksi']);
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
            tb_metodepembayaran ON tb_transaksi.id_pembayaran = tb_metodepembayaran.id_pembayaran 
        WHERE tb_transaksi.id_transaksi='$id_transaksi'");

        $result = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'Invalid parameters']);
    }
}

mysqli_close($connection);
?>
