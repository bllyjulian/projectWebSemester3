<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "codingcamp");

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mengatur header untuk respons JSON
header("Content-Type: application/json");

// Mengambil data dari database (contoh)
$sql = "SELECT * FROM tb_akun";
$result = mysqli_query($conn, $sql);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Mengembalikan data sebagai respons JSON
echo json_encode($data);

// Menutup koneksi database
mysqli_close($conn);
?>