<?php 
    session_start();
    require 'koneksi.php';
    if (!empty($_GET['aksi']) && $_GET['aksi'] == 'login') {
        $user = $_POST['user'];
        $pass = $_POST['pass'];
    
        $sql = "SELECT * FROM tb_akun WHERE username = ? AND password = ?";
        $row = $koneksi->prepare($sql);
        $row->execute(array($user, $pass));
        $count = $row->rowCount();
    
        if ($count > 0) {
            $result = $row->fetch();
            $_SESSION['ADMIN'] = $result;
            $response = array('success' => true);
            echo json_encode($response);
        } else {
            $response = array('success' => false, 'message' => 'Username dan Password Salah!');
            echo json_encode($response);
        }
    }
    
    
    // if ($_GET['aksi'] == "tambahakun") {
    //     $username = $_POST["username"];
    //     $nama_lengkap = $_POST["nama_lengkap"];
    //     $password = $_POST["password"];
    //     $foto_profil = file_get_contents($_FILES["foto_profil"]["tmp_name"]);
    //     $no_hp = $_POST["nomor_hp"];
    //     $email = $_POST["email"];
    //     $status = $_POST["status"];
    //     $id_lvl = $_POST["hak_akses"];
    
    //     // Periksa apakah username sudah ada
    //     $check_username_sql = "SELECT COUNT(*) FROM tb_akun WHERE username = ?";
    //     $check_username_stmt = $koneksi->prepare($check_username_sql);
    //     $check_username_stmt->execute([$username]);
    
    //     if ($check_username_stmt->fetchColumn() > 0) {
    //         // Jika username sudah ada, kirim respons JSON dengan pesan kesalahan
    //         $response = [
    //             'sukses' => false,
    //             'pesan' => 'Username sudah digunakan. Silakan pilih username lain.',
    //             'data' => [
    //                 'username' => $username,
    //                 'nama_lengkap' => $nama_lengkap,
    //                 'password' => $password,
    //                 'no_hp' => $no_hp,
    //                 'email' => $email,
    //                 'status' => $status,
    //                 'id_lvl' => $id_lvl
    //             ]
    //         ];
    //     } else {
    //         // Jika username belum ada, lakukan operasi penyimpanan
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
    
    //         if ($stmt->rowCount() > 0) {
    //             $response = [
    //                 'sukses' => true,
    //                 'pesan' => 'Berhasil menyimpan data'
    //             ];
    //         } else {
    //             $response = [
    //                 'sukses' => false,
    //                 'pesan' => 'Gagal menyimpan data'
    //             ];
    //         }
    //     }
    
    //     // Tutup statement
    //     $check_username_stmt = null;
    
    //     echo json_encode($response);
    // }
    
    if ($_GET['aksi'] == "tambahakun") {
        $username = $_POST["username"];
        $nama_lengkap = $_POST["nama_lengkap"];
        $password = $_POST["password"];
        $no_hp = $_POST["no_hp"];
        if (substr($no_hp, 0, 1) != '+') {
            $no_hp = '+62' . $no_hp;
        }
        
        $email = $_POST["email"];
        $jeniskelamin = $_POST["jenis_kelamin"];
        $id_lvl = $_POST["hak_akses"];
    
        // Handle gambar (profile picture)
        if ($_FILES['foto_profil']['name'] != '') {
            $gambar = $_FILES['foto_profil']['name'];
            $gambar = str_replace(' ', '_', $gambar);
            $folder_tujuan = 'foto_profil/'; // Tentukan path folder yang diinginkan
            $path_gambar = $folder_tujuan . $gambar;
    
            move_uploaded_file($_FILES['foto_profil']['tmp_name'], $path_gambar);
    
            $url_gambar = 'https://www.codingcamp.my.id/admin/crudphp/foto_profil/' . urlencode($gambar);
        } else {
            // Jika gambar tidak diupload
            if ($jeniskelamin == "Laki Laki") {
                $url_gambar = 'https://www.codingcamp.my.id/admin/crudphp/foto_profil/ppkosong.jpg';
            } elseif ($jeniskelamin == "Perempuan") {
                $url_gambar = 'https://www.codingcamp.my.id/admin/crudphp/foto_profil/ppkosongcwe.jpeg';
            }
        }
            $data = array(
                $username,
                $nama_lengkap,
                $password,
                $url_gambar, // Simpan URL foto profil
                $no_hp,
                $email,
                $jeniskelamin,
                $id_lvl
            );
        
            $sql = "INSERT INTO tb_akun (username, nama_lengkap, password, foto_profil, no_hp, email, jenis_kelamin, id_lvl) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $koneksi->prepare($sql);
        
            $stmt->execute($data);
        
            if ($stmt->rowCount() > 0) {
                $response = [
                    'sukses' => true,
                    'pesan' => 'Berhasil menyimpan data'
                ];
            } else {
                $response = [
                    'sukses' => false,
                    'pesan' => 'Gagal menyimpan data'
                ];
            }

        echo json_encode($response);
    }

  
    
if ($_GET['aksi'] == "editakun") {
    $username = $_POST["username"];
    $nama_lengkap = $_POST["nama_lengkap"];
    $no_hp = $_POST["no_hp"];
    $email = $_POST["email"];
    $jeniskelamin = $_POST["jenis_kelamin"];
    $id_lvl = $_POST["hak_akses"];

    $data = array(
        $nama_lengkap,
        $no_hp,
        $email,
        $jeniskelamin,
        $id_lvl,
        $username // Sisipkan username di sini untuk WHERE clause
    );

    $sql = "UPDATE tb_akun SET nama_lengkap=?, no_hp=?, email=?, jenis_kelamin=?, id_lvl=? WHERE username=?";
    $stmt = $koneksi->prepare($sql);

    // Eksekusi query dengan menggunakan array $data
    $stmt->execute($data);

    // Cek apakah data berhasil disimpan
    if ($stmt->rowCount() > 0) {
        $response = [
            'sukses' => true,
            'pesan' => 'Berhasil menyimpan data'
        ];
    } else {
        $response = [
            'sukses' => false,
            'pesan' => 'Gagal menyimpan data'
        ];
    }

    echo json_encode($response);
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
        echo "<script>window.location='../pages/akun';</script>";
    }

    if ($_GET['aksi'] == "tambahevent") {
        $judul = $_POST["judul_event"];
        $keterangan = $_POST["keterangan"];
        $lokasi = $_POST["lokasi"];
        $kuota = $_POST["kuota"];
        $pelaksanaan = $_POST["pelaksanaan"];
        $linkpendaftaran = $_POST["link_pendaftaran"];
        $tanggal = $_POST["tanggal"];
    
        $data = array(
            $judul,
            $keterangan,
            $lokasi,
            $kuota,
            $pelaksanaan,
            $linkpendaftaran,
            $tanggal
        );
    
        // Handle gambar
        $gambar = $_FILES['gambar']['name'];
        $gambar = str_replace(' ', '_', $gambar);
        $folder_tujuan = 'poster/'; 
        $path_gambar = $folder_tujuan . $gambar;
    
        move_uploaded_file($_FILES['gambar']['tmp_name'], $path_gambar);
    
        $url_gambar = 'https://www.codingcamp.my.id/admin/crudphp/poster/' . urlencode($gambar);
    
        $data[] = $url_gambar; 
    
        $sql = "INSERT INTO tb_event (judul_event, keterangan, lokasi, kuota, pelaksanaan, link_pendaftaran, tanggal, gambar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
    

        $stmt->execute($data);
    
        if ($stmt->rowCount() > 0) {
            $response = [
                'sukses' => true,
                'pesan' => 'Berhasil menyimpan data'
            ];
        } else {
            $response = [
                'sukses' => false,
                'pesan' => 'Gagal menyimpan data'
            ];
        }
    
        echo json_encode($response);
    }
    if ($_GET['aksi'] == "editevent") {
        $id_event = $_POST["id_event"];
        $judul = $_POST["judul_event"];
        $keterangan = $_POST["keterangan"];
        $lokasi = $_POST["lokasi"];
        $kuota = $_POST["kuota"];
        $pelaksanaan = $_POST["pelaksanaan"];
        $linkpendaftaran = $_POST["link_pendaftaran"];
        $tanggal = $_POST["tanggal"];
    
        // Handle gambar
        $gambar = $_FILES['gambar']['name'];
        $folder_tujuan = 'poster/'; 
        $path_gambar = $folder_tujuan . $gambar;
    
        move_uploaded_file($_FILES['gambar']['tmp_name'], $path_gambar);
    
        $url_gambar = 'https://www.codingcamp.my.id/admin/crudphp/poster/' . urlencode($gambar);
    
        $data = array(
            $judul,
            $keterangan,
            $lokasi,
            $url_gambar, 
            $kuota,
            $pelaksanaan,
            $linkpendaftaran,
            $tanggal,
            $id_event
        );
    
        $sql = "UPDATE tb_event SET judul_event=?, keterangan=?, lokasi=?, gambar=?, kuota=?, pelaksanaan=?, link_pendaftaran=?, tanggal=? WHERE id_event=?";
        $stmt = $koneksi->prepare($sql);
    
        $stmt->execute($data);
    
        if ($stmt->rowCount() > 0) {
            $response = [
                'sukses' => true,
                'pesan' => 'Berhasil menyimpan data'
            ];
        } else {
            $response = [
                'sukses' => false,
                'pesan' => 'Gagal menyimpan data'
            ];
        }
    
        echo json_encode($response);
    }
    
    if ($_GET['aksi'] == "hapusevent") {
        $id = $_GET["id_event"];
    
        // Jalankan query DELETE
        $stmt = $koneksi->prepare("DELETE FROM tb_event WHERE id_event = ?");
        $stmt->execute([$id]);
    
        if ($stmt->rowCount() > 0) {

        } else {
            echo "<script>alert('Gagal menghapus data');</script>";
        }
    
        // Redirect atau lakukan aksi lain setelah penghapusan
        echo "<script>window.location='../pages/event.php';</script>";
    }

    //crud modul
    if ($_GET['aksi'] == "tambahmodul") {
        $id_jenismodul = $_POST["id_jenismodul"];
        
        // Retrieve the latest count of modul for the selected id_jenismodul
        $stmt = $koneksi->prepare("SELECT COUNT(*) FROM tb_modul WHERE id_jenismodul = ?");
        $stmt->execute([$id_jenismodul]);
        $count_modul = $stmt->fetchColumn() + 1;
        
        // Determine the prefix based on id_jenismodul
        $prefix = "";
        switch ($id_jenismodul) {
            case 3:
                $prefix = "WEB";
                break;
            case 4:
                $prefix = "ML";
                break;
            case 5:
                $prefix = "MBL";
                break;
            case 6:
                $prefix = "DB";
                break;
            case 7:
                $prefix = "NS";
                break;
        }
        
        do {
            $id_modul = $prefix . str_pad($count_modul, 2, "0", STR_PAD_LEFT);
    
            // Check if the generated ID_modul already exists in the table
            $stmt_check_id = $koneksi->prepare("SELECT COUNT(*) FROM tb_modul WHERE id_modul = ?");
            $stmt_check_id->execute([$id_modul]);
            $count_existing_id = $stmt_check_id->fetchColumn();
    
            if ($count_existing_id > 0) {
                $count_modul++; // Tambahkan 1 ke count_modul
            } else {
                break; // Keluar dari loop jika ID unik ditemukan
            }
        } while (true);
        
        $judul = $_POST["judul"];
        $keterangan = $_POST["keterangan"];
        $tujuan = $_POST["tujuan"];
        $harga = $_POST["harga"];
        
        // Handle gambar
        $gambar = $_FILES['gambar']['name'];
        $folder_tujuan = 'gambarmodul/'; 
        $path_gambar = $folder_tujuan . $gambar;
        move_uploaded_file($_FILES['gambar']['tmp_name'], $path_gambar);
        $url_gambar = 'https://www.codingcamp.my.id/admin/crudphp/gambarmodul/' . urlencode($gambar);
        
        $data = array(
            $id_modul,
            $judul,
            $keterangan,
            $url_gambar, // Simpan url gambar
            $tujuan,
            $harga,
            $id_jenismodul
        );
        
        $sql = "INSERT INTO tb_modul (id_modul, judul, keterangan, gambar, tujuan, harga, id_jenismodul) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
        
        $stmt->execute($data);
        
        if ($stmt->rowCount() > 0) {
            $response = [
                'sukses' => true,
                'pesan' => 'Berhasil menyimpan data'
            ];
        } else {
            $response = [
                'sukses' => false,
                'pesan' => 'Gagal menyimpan data'
            ];
        }
        
        echo json_encode($response);
    }
    
    if ($_GET['aksi'] == "hapusmodul") {
        $id = $_GET["id_modul"];
    
        // Jalankan query DELETE
        $stmt = $koneksi->prepare("DELETE FROM tb_modul WHERE id_modul = ?");
        $stmt->execute([$id]);
    
        if ($stmt->rowCount() > 0) {

        } else {
            echo "<script>alert('Gagal menghapus data');</script>";
        }
    
        // Redirect atau lakukan aksi lain setelah penghapusan
        echo "<script>window.location='../pages/course';</script>";
    }

    if ($_GET['aksi'] == "tambahjenismodul") {
        $judul = $_POST["nama_jenis"];
    
        $data = array(
            $judul,

        );
    
        // Handle gambar
        $gambar = $_FILES['gambar']['name'];
        $gambar = str_replace(' ', '_', $gambar);
        $folder_tujuan = 'iconjenismodul/'; 
        $path_gambar = $folder_tujuan . $gambar;
    
        move_uploaded_file($_FILES['gambar']['tmp_name'], $path_gambar);
    
        $url_gambar = 'https://www.codingcamp.my.id/admin/crudphp/iconjenismodul/' . urlencode($gambar);
    
        $data[] = $url_gambar; 
    
        $sql = "INSERT INTO tb_jenismodul (id_jenismodul, nama_jenis, gambar) VALUES (?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
    

        $stmt->execute($data);
    
        if ($stmt->rowCount() > 0) {
            $response = [
                'sukses' => true, 
                'pesan' => 'Berhasil menyimpan data'
            ];
        } else {
            $response = [
                'sukses' => false,
                'pesan' => 'Gagal menyimpan data'
            ];
        }
    
        echo json_encode($response);
    }