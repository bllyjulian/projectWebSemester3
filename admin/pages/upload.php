<?php
$target_dir = "api/foto_profil/";
$target_file = $target_dir . basename($_FILES["foto_profil"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// ... (periksa validitas gambar, ukuran, dll)

// Periksa apakah $uploadOk memiliki nilai 0 karena terjadi kesalahan
if ($uploadOk == 0) {
    echo "Maaf, gambar tidak diunggah.";
// Jika semuanya benar, coba unggah file
} else {
    if (move_uploaded_file($_FILES["foto_profil"]["tmp_name"], $target_file)) {
        echo "Gambar ". htmlspecialchars( basename( $_FILES["foto_profil"]["name"])). " telah berhasil diunggah.";
    } else {
        echo "Maaf, terjadi kesalahan saat mengunggah gambar.";
    }
}
?>
