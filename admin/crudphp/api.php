<?php
$conn = mysqli_connect("localhost", "root", "", "codingcamp");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

header("Content-Type: application/json");

$sql = "SELECT * FROM tb_akun";
$result = mysqli_query($conn, $sql);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// var_dump($data); // Ini akan mencetak data untuk memeriksa apakah data ada

echo json_encode($data);

mysqli_close($conn);
?>
