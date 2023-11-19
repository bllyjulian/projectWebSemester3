<?php 
    session_start();
    require 'koneksi.php';
    if (!empty($_GET['aksi']) && $_GET['aksi'] == 'login') {
        $user = $_POST['user'];
        $pass = $_POST['pass'];
    
        $sql = "SELECT * FROM tb_admin WHERE username = ? AND password = ?";
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
    
            // Check apakah username sudah ada
    $check_username = $koneksi->prepare("SELECT * FROM tb_admin WHERE username = ?");
    $check_username->execute([$username]);

    if ($check_username->rowCount() > 0) {
        $response = [
            'sukses' => false,
            'pesan' => 'Username sudah digunakan. Silakan pilih username lain.'
        ];
        echo json_encode($response);
        exit(); // Keluar dari skrip
    }
        // Handle gambar (profile picture)
        if ($_FILES['foto_profil']['name'] != '') {
            $gambar = $_FILES['foto_profil']['name'];
            $ext = pathinfo($gambar, PATHINFO_EXTENSION); // Dapatkan ekstensi file
            $nama_baru = md5($gambar . time()) . '.' . $ext; // Menghasilkan nama unik
    
            $gambar = str_replace(' ', '_', $nama_baru); 
    
            $folder_tujuan = 'foto_profil/'; 
            $path_gambar = $folder_tujuan . $nama_baru;
    
            move_uploaded_file($_FILES['foto_profil']['tmp_name'], $path_gambar);
    
            $url_gambar = 'https://codingcamp.myhost.id/kelompok1/admin/crudphp/foto_profil/' . urlencode($nama_baru);
        } else {
            // Jika gambar tidak diupload
            if ($jeniskelamin == "Laki Laki") {
                $url_gambar = 'https://codingcamp.myhost.id/kelompok1/admin/crudphp/foto_profil/ppkosongv1.jpg';
            } elseif ($jeniskelamin == "Perempuan") {
                $url_gambar = 'https://codingcamp.myhost.id/kelompok1/admin/crudphp/foto_profil/ppkosongv2.jpg';
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
        
            $sql = "INSERT INTO tb_admin (username, nama_lengkap, password, foto_profil, no_hp, email, jenis_kelamin, id_lvl) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
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

    $sql = "UPDATE tb_admin SET nama_lengkap=?, no_hp=?, email=?, jenis_kelamin=?, id_lvl=? WHERE username=?";
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
        $stmt = $koneksi->prepare("DELETE FROM tb_admin WHERE username = ?");
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
        $ext = pathinfo($gambar, PATHINFO_EXTENSION); // Mendapatkan ekstensi file
        $nama_baru = md5($gambar . time()) . '.' . $ext; // Menghasilkan nama unik
    
        $gambar = str_replace(' ', '_', $nama_baru); // Mengganti spasi dengan _
    
        $folder_tujuan = 'poster/'; 
        $path_gambar = $folder_tujuan . $nama_baru;
    
        move_uploaded_file($_FILES['gambar']['tmp_name'], $path_gambar);
    
        $url_gambar = 'https://codingcamp.myhost.id/kelompok1/admin/crudphp/poster/' . urlencode($nama_baru);
    
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
    
        if (!empty($_FILES['gambar']['name'])) {
            $gambar = $_FILES['gambar']['name'];
            $ext = pathinfo($gambar, PATHINFO_EXTENSION); // Mendapatkan ekstensi file
            $nama_baru = md5($gambar . time()) . '.' . $ext; // Menghasilkan nama unik
    
            $gambar = str_replace(' ', '_', $nama_baru); // Mengganti spasi dengan _
    
            $folder_tujuan = 'poster/'; 
            $path_gambar = $folder_tujuan . $nama_baru;
    
            move_uploaded_file($_FILES['gambar']['tmp_name'], $path_gambar);
    
            $url_gambar = 'https://codingcamp.myhost.id/kelompok1/admin/crudphp/poster/' . urlencode($nama_baru);
        } else {
            $url_gambar = $_POST['gambarawal']; 
        }
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
        
        $gambar = $_FILES['gambar']['name'];
        $ext = pathinfo($gambar, PATHINFO_EXTENSION); // Mendapatkan ekstensi file
        $nama_baru = md5($gambar . time()) . '.' . $ext; // Menghasilkan nama unik

        $folder_tujuan = 'gambarmodul/'; 
        $path_gambar = $folder_tujuan . $nama_baru;
        move_uploaded_file($_FILES['gambar']['tmp_name'], $path_gambar);

        $url_gambar = 'https://codingcamp.myhost.id/kelompok1/admin/crudphp/gambarmodul/' . urlencode($nama_baru);
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
    
    if ($_GET['aksi'] == "editmodul") {
        $id_modul = $_POST["id_modul"];
        $judul = $_POST["judul"];
        $keterangan = $_POST["keterangan"];
        $tujuan = $_POST["tujuan"];
        $harga = $_POST['harga'];


        if (!empty($_FILES['gambar']['name'])) {
            $gambar = $_FILES['gambar']['name'];
            $ext = pathinfo($gambar, PATHINFO_EXTENSION); // Mendapatkan ekstensi file
            $nama_baru = md5($gambar . time()) . '.' . $ext; // Menghasilkan nama unik
    
            $gambar = str_replace(' ', '_', $nama_baru); // Mengganti spasi dengan _
    
            $folder_tujuan = 'gambarmodul/'; 
            $path_gambar = $folder_tujuan . $nama_baru;
    
            move_uploaded_file($_FILES['gambar']['tmp_name'], $path_gambar);
    
            $url_gambar = 'https://codingcamp.myhost.id/kelompok1/admin/crudphp/gambarmodul/' . urlencode($nama_baru);
        } else {
            $url_gambar = $_POST['gambarawal']; 
        }

        $data = array(
            $judul,
            $keterangan,
            $url_gambar,
            $tujuan,
            $harga,
            $id_modul // Sisipkan ID_modul untuk kondisi WHERE pada UPDATE
        );
    
        $sql = "UPDATE tb_modul SET judul=?, keterangan=?, gambar=?, tujuan=?, harga=? WHERE id_modul=?";
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
    
        $url_gambar = 'https://codingcamp.myhost.id/kelompok1/admin/crudphp/iconjenismodul/' . urlencode($gambar);
    
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

    
    if ($_GET['aksi'] == "tambah_bab") {
        $nama_bab = $_POST["judul_bab"];
        $id_modul = $_POST["id_modul"];
    
        $data = array($nama_bab, $id_modul);
    
        try {
            $sql = "INSERT INTO tb_bab (nama_bab, id_modul) VALUES (?, ?)";
            $stmt = $koneksi->prepare($sql);
    
            $stmt->execute($data);
    
            if ($stmt->rowCount() > 0) {
                $response = [
                    'sukses' => true,
                    'pesan' => 'Berhasil menambahkan bab'
                ];
            } else {
                $response = [
                    'sukses' => false,
                    'pesan' => 'Gagal menambahkan bab'
                ];
            }
        } catch (PDOException $e) {
            // Tangani kesalahan PDO jika terjadi
            $response = [
                'sukses' => false,
                'pesan' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }

        echo json_encode($response);
    }
    
    if ($_GET['aksi'] == "edit_bab") {
        $id_bab = $_POST["id_bab"];
        $nama_bab = $_POST["judul_bab"];
        $id_modul = $_POST["id_modul"];
    
        $data = array(
            $nama_bab,
            $id_bab
        );
    
        try {
            $sql = "UPDATE tb_bab SET nama_bab=? WHERE id_bab=?";
            $stmt = $koneksi->prepare($sql);
    
            $stmt->execute($data);
    
            if ($stmt->rowCount() > 0) {
                $response = [
                    'sukses' => true,
                    'pesan' => 'Berhasil mengedit bab'
                ];
            } else {
                $response = [
                    'sukses' => false,
                    'pesan' => 'Gagal mengedit bab'
                ];
            }
        } catch (PDOException $e) {
            // Tangani kesalahan PDO jika terjadi
            $response = [
                'sukses' => false,
                'pesan' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    
        echo json_encode($response);
    }
    
    if ($_GET['aksi'] == "hapusbab") {
        $id_bab = $_GET["id_bab"];
    
        // Jalankan query DELETE
        $stmt = $koneksi->prepare("DELETE FROM tb_bab WHERE id_bab = ?");
        $stmt->execute([$id_bab]);
    
        // Berikan respons JSON
        if ($stmt->rowCount() > 0) {
            $response = [
                'sukses' => true,
                'pesan' => 'Data berhasil dihapus.'
            ];
        } else {
            $response = [
                'sukses' => false,
                'pesan' => 'Gagal menghapus data.'
            ];
        }
    
        // Kembalikan respons JSON
        echo json_encode($response);
    }
    
    if ($_GET['aksi'] == "tambah_subbab") {
        $nama_subbab = $_POST["judul_subbab"];
        $pengantar_bab = $_POST["pengantar_bab"];
        $id_bab = $_POST["id_bab"];
    
        $data = array($nama_subbab, $pengantar_bab, $id_bab);
    
        try {
            $sql = "INSERT INTO tb_subbab (nama_subbab, pengantar, id_bab) VALUES (?, ?, ?)";
            $stmt = $koneksi->prepare($sql);
    
            $stmt->execute($data);
    
            if ($stmt->rowCount() > 0) {
                $response = [
                    'sukses' => true,
                    'pesan' => 'Berhasil menambahkan subbab'
                ];
            } else {
                $response = [
                    'sukses' => false,
                    'pesan' => 'Gagal menambahkan subbab'
                ];
            }
        } catch (PDOException $e) {
            // Tangani kesalahan PDO jika terjadi
            $response = [
                'sukses' => false,
                'pesan' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    
        echo json_encode($response);
    }
    if ($_GET['aksi'] == "edit_subbab") {
        $id_bab = $_POST["id_bab"];
        $nama_subbab = $_POST["nama_subbab"];
        $pengantar_subbab = $_POST["pengantar_subbab"];
        $id_subbab = $_POST["id_subbab"];
    
        $data = array(
            $nama_subbab,
            $pengantar_subbab,
            $id_subbab
        );
    
        try {
            $sql = "UPDATE tb_subbab SET nama_subbab=?, pengantar=? WHERE id_subbab=?";
            $stmt = $koneksi->prepare($sql);
    
            $stmt->execute($data);
    
            if ($stmt->rowCount() > 0) {
                $response = [
                    'sukses' => true,
                    'pesan' => 'Berhasil mengedit subbab'
                ];
            } else {
                $response = [
                    'sukses' => false,
                    'pesan' => 'Gagal mengedit subbab'
                ];
            }
        } catch (PDOException $e) {
            // Tangani kesalahan PDO jika terjadi
            $response = [
                'sukses' => false,
                'pesan' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    
        echo json_encode($response);
    }
    
    if ($_GET['aksi'] == "hapussubbab") {
        $id_subbab = $_GET["id_subbab"];
        
        try {
            // Jalankan query DELETE
            $stmt = $koneksi->prepare("DELETE FROM tb_subbab WHERE id_subbab = ?");
            $stmt->execute([$id_subbab]);
        
            // Berikan respons JSON
            if ($stmt->rowCount() > 0) {
                $response = [
                    'sukses' => true,
                    'pesan' => 'Data berhasil dihapus.'
                ];
            } else {
                $response = [
                    'sukses' => false,
                    'pesan' => 'Gagal menghapus data. Tidak ada data yang dihapus.'
                ];
            }
        } catch (PDOException $e) {
            // Tangani kesalahan PDO jika terjadi
            $response = [
                'sukses' => false,
                'pesan' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }    

    if ($_GET['aksi'] == "tambahmateri") {
        $jumlah_data = count($_POST['judul_materi']);
        $response = []; // Respons awal dalam bentuk array kosong
    
        for ($i = 0; $i < $jumlah_data; $i++) {
            $judul = $_POST['judul_materi'][$i];
            $materi = $_POST['materi'][$i];
            $id_subbab = $_POST['id_subbab'][$i];
            $nama_gambar = $_FILES['gambar']['name'][$i];
            $tmp_gambar = $_FILES['gambar']['tmp_name'][$i];
            $url_gambar = null;
    
            if ($nama_gambar !== '') {
                $nama_baru = md5($nama_gambar . time()) . '.' . pathinfo($nama_gambar, PATHINFO_EXTENSION);
                $folder_tujuan = 'gambarmateri/';
                $path_gambar = $folder_tujuan . $nama_baru;
    
                if (move_uploaded_file($tmp_gambar, $path_gambar)) {
                    $url_gambar = 'https://codingcamp.myhost.id/kelompok1/admin/crudphp/gambarmateri/' . urlencode($nama_baru);
                }
            }
    
            // Menyiapkan data untuk disimpan ke dalam database
            $data = array(
                $judul,
                $materi,
                $url_gambar,
                $id_subbab
            );
    
            $sql = "INSERT INTO tb_materi (judul, materi, gambar, id_subbab) VALUES (?, ?, ?, ?)";
            $stmt = $koneksi->prepare($sql);
    
            $stmt->execute($data);
    
            if ($stmt->rowCount() > 0) {
                $response[] = [
                    'sukses' => true,
                    'pesan' => 'Berhasil menyimpan data'
                ];
            } else {
                $response[] = [
                    'sukses' => false,
                    'pesan' => 'Gagal menyimpan data'
                ];
            }
        }
    
        echo json_encode($response); // Mengirim respons keseluruhan setelah semua data diolah
    }
    
    
    