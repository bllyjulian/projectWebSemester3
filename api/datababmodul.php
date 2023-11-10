<?php
require_once('connection.php');

if (empty($_GET)) {
    $query = mysqli_query($connection, "SELECT 
        tb_bab.nama_bab,
        tb_subbab.nama_subbab,
        tb_subbab.pengantar,
        tb_materi.judul,
        tb_materi.materi,
        tb_materi.gambar
    FROM 
        tb_bab
    INNER JOIN 
        tb_subbab ON tb_bab.id_bab = tb_subbab.id_bab
    INNER JOIN 
        tb_materi ON tb_subbab.id_subbab = tb_materi.id_subbab");
    
    $result = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = array(
            'nama_bab' => $row['nama_bab'],
            'nama_subbab' => $row['nama_subbab'],
            'pengantar' => $row['pengantar'],
            'judul' => $row['judul'],
            'materi' => $row['materi'],
            'gambar' => $row['gambar']
        );
    }
    header('Content-Type: application/json;charset=utf8');
    echo json_encode($result);
} else {
    // Handle the case when $_GET is not empty (e.g., specific id_bab requested)
    $id_bab = mysqli_real_escape_string($connection, $_GET['id_bab']);
    $query = mysqli_query($connection, "SELECT 
        tb_bab.nama_bab,
        tb_subbab.nama_subbab,
        tb_subbab.gambarpengantar,
        tb_subbab.pengantar,
        tb_materi.judul,
        tb_materi.materi,
        tb_materi.gambar
    FROM 
        tb_bab
    INNER JOIN 
        tb_subbab ON tb_bab.id_bab = tb_subbab.id_bab
    INNER JOIN 
        tb_materi ON tb_subbab.id_subbab = tb_materi.id_subbab
    WHERE tb_bab.id_bab = $id_bab");
    
    $result = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = array(
            'nama_bab' => $row['nama_bab'],
            'nama_subbab' => $row['nama_subbab'],
            'gambarpengantar' => $row['gambarpengantar'],
            'pengantar' => $row['pengantar'],
            'judul' => $row['judul'],
            'materi' => $row['materi'],
            'gambar' => $row['gambar']
        );
    }
    header('Content-Type: application/json;charset=utf8');
    echo json_encode($result);
}

mysqli_close($connection);
?>
