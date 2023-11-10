<?php
require_once('connection.php');

if (empty($_GET)) {
    $query = mysqli_query($connection, "SELECT 
        tb_submodul.nama_submodul,
        tb_babpengantar.gambartitle,
        tb_babpengantar.pengantar,
        tb_bab.judul, 
        tb_bab.materi,
        tb_babgambar.gambar
    FROM 
        tb_bab
    LEFT JOIN 
        tb_submodul ON tb_submodul.id_submodul = tb_bab.id_submodul
    LEFT JOIN 
        tb_babpengantar ON tb_babpengantar.id_pengantar = tb_bab.id_pengantar
    LEFT JOIN
        tb_babgambar ON tb_babgambar.id_gambar = tb_bab.id_gambar");

    echo '<div>';
    while ($row = mysqli_fetch_assoc($query)) {
        // echo '<h1>' . $row['nama_submodul'] . '</h1>';

        echo '<img src="' . $row['gambartitle'] . '" alt="Submodul Image">';
        if ($row['gambar'] !== null) {
            echo '<img src="' . $row['gambar'] . '" alt="Submodul Image">';
        }
        echo '<p>' . $row['pengantar'] . '</p>';
        echo '<p><strong>' . $row['judul'] . '</strong></p>';
        echo '<p>' . $row['materi'] . '</p>';

        // Check if 'gambar' is not null before displaying the second image
    }
    echo '</div>';
}

mysqli_close($connection);
?>
