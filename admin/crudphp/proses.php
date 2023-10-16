<?php 
    session_start();
    require 'koneksi.php';

    // proses login
    if(!empty($_GET['aksi'] == 'login'))
    {
        // validasi text untuk filter karakter khusus dengan fungsi strip_tags()
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $sql = "SELECT * FROM tb_akun WHERE username = ? AND password = ?";
        $row = $koneksi->prepare($sql);
        $row->execute(array($user,$pass));
        $count = $row->rowCount();

        if($count > 0)
        {
            $result = $row->fetch();
            $_SESSION['ADMIN'] = $result;
            // status yang diberikan 
            echo "<script>window.location='../pages/dashboard.php';</script>";
        }else{
            echo "<script>window.location='login.php?get=failed';</script>";
        }

    }
//     if ($_GET['aksi'] == "tambahakun") {
//         $username = $_POST["username"];
//         $nama_lengkap = $_POST["nama_lengkap"];
//         $password = $_POST["password"];
//         $foto_profil = file_get_contents($_FILES["foto_profil"]["tmp_name"]);
//         $no_hp = $_POST["nomor_hp"];
//         $email = $_POST["email"];
//         $status = $_POST["status"];
//         $id_lvl = $_POST["hak_akses"];
    
//         $data = array(
//             $username,
//             $nama_lengkap,
//             $password,
//             $foto_profil,
//             $no_hp,
//             $email,
//             $status,
//             $id_lvl
//         );
    
//         $sql = "INSERT INTO tb_akun (username, nama_lengkap, password, foto_profil, no_hp, email, status, id_lvl) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
//         $stmt = $koneksi->prepare($sql);
    
//         // Eksekusi query dengan menggunakan array $data
//         $stmt->execute($data);
//     // Cek apakah data berhasil disimpan
//     if ($stmt->rowCount() > 0) {
//         echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
//         echo "<script>
//             Swal.fire({
//                 title: 'Good job!',
//                 text: 'Data berhasil disimpan!',
//                 icon: 'success',
//                 confirmButtonText: 'OK'
//             });
//         </script>";
//     } else {
//         echo "<script>alert('Gagal menyimpan data');</script>";
//     }

//     echo "<script>window.location='../pages/akunSemua.php';</script>";
// }

if ($_GET['aksi'] == "tambahakun") {
    $username = $_POST["username"];
    $nama_lengkap = $_POST["nama_lengkap"];
    $password = $_POST["password"];
    $no_hp = $_POST["nomor_hp"];
    $email = $_POST["email"];
    $status = $_POST["status"];
    $id_lvl = $_POST["hak_akses"];

    $foto_profil_name = "api/foto_profil/" . $_FILES["foto_profil"]["name"];

    // Upload gambar ke repositori GitHub
    $github_username = "bllyjulian"; // Ganti dengan nama pengguna GitHub Anda
    $github_token = "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"; // Ganti dengan token akses pribadi GitHub Anda

    $file_path = $_FILES["foto_profil"]["tmp_name"];
    $commit_message = "Menambahkan foto profil";

    $url = "http://api.github.com/repos/$github_username/projectWebSemester3/api/foto_frofil/$foto_profil_name";

    $data = array(
        "message" => $commit_message,
        "content" => base64_encode(file_get_contents($file_path))
    );

    $options = array(
        "http" => array(
            "header" => "Content-type: application/json\r\n" .
                        "Authorization: token $github_token\r\n",
            "method" => "PUT",
            "content" => json_encode($data)
        )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === false) {
        die("Gagal mengunggah gambar ke GitHub.");
    }

    // Simpan data ke database
    $foto_profil_path = "http://raw.githubusercontent.com/$github_username/projectWebSemester3/master/api/foto_frofil$foto_profil_name";

    $data = array(
        $username,
        $nama_lengkap,
        $password,
        $foto_profil_path,
        $no_hp,
        $email,
        $status,
        $id_lvl
    );

    $sql = "INSERT INTO tb_akun (username, nama_lengkap, password, foto_profil, no_hp, email, status, id_lvl) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($sql);

    $stmt->execute($data);

    if ($stmt->rowCount() > 0) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Good job!',
                text: 'Data berhasil disimpan!',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>";
    } else {
        echo "<script>alert('Gagal menyimpan data');</script>";
    }

    echo "<script>window.location='../pages/akunSemua.php';</script>";
}



 

if ($_GET['aksi'] == "editakun") {
    $username = $_POST["username"];
    $nama_lengkap = $_POST["nama_lengkap"];
    $no_hp = $_POST["nomor_hp"];
    $email = $_POST["email"];
    $status = $_POST["status"];
    $id_lvl = $_POST["hak_akses"];

    $data = array(
        $nama_lengkap,
        $no_hp,
        $email,
        $status,
        $id_lvl,
        $username // Sisipkan username di sini untuk WHERE clause
    );

    $sql = "UPDATE tb_akun SET nama_lengkap=?, no_hp=?, email=?, status=?, id_lvl=? WHERE username=?";
    $stmt = $koneksi->prepare($sql);

    // Eksekusi query dengan menggunakan array $data
    $stmt->execute($data);

    // Cek apakah data berhasil disimpan
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('berhasil edit menyimpan data');</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data');</script>";
    }

    echo "<script>window.location='../pages/akunSemua.php';</script>";
}

    
    
    if ($_GET['aksi'] == "hapusakun") {
        $username = $_GET["username"];
    
        // Jalankan query DELETE
        $stmt = $koneksi->prepare("DELETE FROM tb_akun WHERE username = ?");
        $stmt->execute([$username]);
    
        if ($stmt->rowCount() > 0) {

        } else {
            echo "<script>alert('Gagal menghapus data');</script>";
        }
    
        // Redirect atau lakukan aksi lain setelah penghapusan
        echo "<script>window.location='../pages/akunSemua.php';</script>";
    }

    if ($_GET['aksi'] == "tambahevent") {
        $judul = $_POST["judul_event"];
        $keterangan = $_POST["keterangan"];
        $lokasi = $_POST["lokasi"];
        $poster = $_POST["gambar"];
        $kuota = $_POST["kuota"];
        $pelaksanaan = $_POST["pelaksanaan"];
        $linkpendaftaran = $_POST["link_pendaftaran"];
        $tanggal = $_POST["tanggal"];
    
        $data = array(
            $judul,
            $keterangan,
            $lokasi,
            $poster,
            $kuota,
            $pelaksanaan,
            $linkpendaftaran,
            $tanggal
        );
    
        $sql = "INSERT INTO tb_event (judul_event, keterangan, lokasi, gambar, kuota, pelaksanaan, link_pendaftaran, tanggal) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
    
        // Eksekusi query dengan menggunakan array $data
        $stmt->execute($data);
    // Cek apakah data berhasil disimpan
    if ($stmt->rowCount() > 0) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Good job!',
                text: 'Data berhasil disimpan!',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>";
    } else {
        echo "<script>alert('Gagal menyimpan data');</script>";
    }

    echo "<script>window.location='../pages/event.php';</script>";
}
    if ($_GET['aksi'] == "hapusevent") {
        $dini = $_GET["id_event"];
    
        // Jalankan query DELETE
        $stmt = $koneksi->prepare("DELETE FROM tb_event WHERE id_event = ?");
        $stmt->execute([$dini]);
    
        if ($stmt->rowCount() > 0) {

        } else {
            echo "<script>alert('Gagal menghapus data');</script>";
        }
    
        // Redirect atau lakukan aksi lain setelah penghapusan
        echo "<script>window.location='../pages/event.php';</script>";
    }