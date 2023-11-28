<?php
session_start();
require 'koneksi.php';

if (!empty($_GET['aksi']) && $_GET['aksi'] == 'login') {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    // Prepare the SQL statement with placeholders
    $sql = "SELECT * FROM tb_admin WHERE username = :username AND password = :password";
    $row = $koneksi->prepare($sql);

    // Bind parameters to the prepared statement
    $row->bindParam(':username', $user);
    $row->bindParam(':password', $pass);

    // Execute the prepared statement
    $row->execute();
    $count = $row->rowCount();

    if ($count > 0) {
        $result = $row->fetch();

        // Simpan semua informasi pengguna ke dalam session
        $_SESSION['USER_INFO'] = $result;

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

        $url_gambar = 'https://codingcamp.myhost.id/admin/crudphp/foto_profil/' . urlencode($nama_baru);
    } else {
        // Jika gambar tidak diupload
        if ($jeniskelamin == "Laki Laki") {
            $url_gambar = 'https://codingcamp.myhost.id/admin/crudphp/foto_profil/fpkosongcwo.png';
        } elseif ($jeniskelamin == "Perempuan") {
            $url_gambar = 'https://codingcamp.myhost.id/admin/crudphp/foto_profil/fpkosongcwe.png';
        }
    }
    $data = array(
        $username,
        $nama_lengkap,
        $password,
        $url_gambar,
        // Simpan URL foto profil
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

    if ($jeniskelamin == "Laki Laki") {
        $url_gambar = 'https://codingcamp.myhost.id/admin/crudphp/foto_profil/fpkosongcwo.png';
    } elseif ($jeniskelamin == "Perempuan") {
        $url_gambar = 'https://codingcamp.myhost.id/admin/crudphp/foto_profil/fpkosongcwe.png';
    }

    // Perintah SQL untuk update data dengan prepared statement
    $sql = "UPDATE tb_admin SET nama_lengkap=?, no_hp=?, email=?, jenis_kelamin=?, foto_profil=?, id_lvl=? WHERE username=?";
    $stmt = $koneksi->prepare($sql);

    // Bind parameter ke prepared statement
    $stmt->bindParam(1, $nama_lengkap);
    $stmt->bindParam(2, $no_hp);
    $stmt->bindParam(3, $email);
    $stmt->bindParam(4, $jeniskelamin);
    $stmt->bindParam(5, $url_gambar);
    $stmt->bindParam(6, $id_lvl);
    $stmt->bindParam(7, $username);

    // Eksekusi query
    $stmt->execute();

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

    $url_gambar = 'https://codingcamp.myhost.id/admin/crudphp/poster/' . urlencode($nama_baru);

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

        $url_gambar = 'https://codingcamp.myhost.id/admin/crudphp/poster/' . urlencode($nama_baru);
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

    $url_gambar = 'https://codingcamp.myhost.id/admin/crudphp/gambarmodul/' . urlencode($nama_baru);
    $data = array(
        $id_modul,
        $judul,
        $keterangan,
        $url_gambar,
        // Simpan url gambar
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

        $url_gambar = 'https://codingcamp.myhost.id/admin/crudphp/gambarmodul/' . urlencode($nama_baru);
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

    $url_gambar = 'https://codingcamp.myhost.id/admin/crudphp/iconjenismodul/' . urlencode($gambar);

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
                $url_gambar = 'https://codingcamp.myhost.id/admin/crudphp/gambarmateri/' . urlencode($nama_baru);
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
if ($_GET['aksi'] == "editmateri") {
    $id_materi = $_POST["id_materi"];
    $judul = $_POST["judul"];
    $materi = $_POST["materi"];
    $id_subbab = $_POST["id_subbab"];

    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $ext = pathinfo($gambar, PATHINFO_EXTENSION); // Mendapatkan ekstensi file
        $nama_baru = md5($gambar . time()) . '.' . $ext; // Menghasilkan nama unik

        $gambar = str_replace(' ', '_', $nama_baru); // Mengganti spasi dengan _

        $folder_tujuan = 'gambarmateri/';
        $path_gambar = $folder_tujuan . $nama_baru;

        move_uploaded_file($_FILES['gambar']['tmp_name'], $path_gambar);

        $url_gambar = 'https://codingcamp.myhost.id/admin/crudphp/gambarmateri/' . urlencode($nama_baru);
    } else {
        $url_gambar = $_POST['gambarawal'];
    }
    $data = array(
        $judul,
        $materi,
        $url_gambar,
        $id_subbab,
        $id_materi
    );

    $sql = "UPDATE tb_materi SET judul=?, materi=?, gambar=?, id_subbab=? WHERE id_materi=?";
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

if ($_GET['aksi'] == "hapusmateri") {
    $id_materi = $_POST["id_materi"];

    // Jalankan query DELETE
    $stmt = $koneksi->prepare("DELETE FROM tb_materi WHERE id_materi = ?");
    $stmt->execute([$id_materi]);

    if ($stmt->rowCount() > 0) {
        $response = [
            'sukses' => true,
            'pesan' => 'Berhasil menghapus data'
        ];
    } else {
        $response = [
            'sukses' => false,
            'pesan' => 'Gagal menghapus data'
        ];
    }
}

if ($_GET['aksi'] == "transaksisetuju") {
    $username = $_POST["username"];
    $id_modul = $_POST["id_modul"];
    $koin_dipakai = $_POST["koin_dipakai"];

    $data = array($username, $id_modul);

    try {
        // Lakukan INSERT
        $sql_insert = "INSERT INTO tb_moduldimiliki (username, id_modul) VALUES (?, ?)";
        $stmt_insert = $koneksi->prepare($sql_insert);

        $stmt_insert->execute($data);

        // Cek apakah insert berhasil
        if ($stmt_insert->rowCount() > 0) {

            $id_transaksi = $_POST["id_transaksi"]; 

            $sql_update = "UPDATE tb_transaksi SET id_status = 3 WHERE id_transaksi = ?";
            $stmt_update = $koneksi->prepare($sql_update);
            $stmt_update->execute([$id_transaksi]);

            // Cek apakah update berhasil
            if ($stmt_update->rowCount() > 0) {
                $response = [
                    'sukses' => true,
                    'pesan' => 'Transaksi telah disetujui dan status diperbarui'
                ];
            } else {
                $response = [
                    'sukses' => false,
                    'pesan' => 'Gagal memperbarui status transaksi'
                ];
            }
        } else {
            $response = [
                'sukses' => false,
                'pesan' => 'Gagal menyetujui transaksi'
            ];
        }
    } catch (PDOException $e) {
        $response = [
            'sukses' => false,
            'pesan' => 'Terjadi kesalahan: ' . $e->getMessage()
        ];
    }

    echo json_encode($response);
}

if ($_GET['aksi'] == "transaksiditolak") {
    $username = $_POST["username"];
    $koin_dipakai = $_POST["koin_dipakai"];

    try {
        if ($koin_dipakai == 0) {
            $id_transaksi = $_POST["id_transaksi"];

            $sql_update_transaksi = "UPDATE tb_transaksi SET id_status = 4 WHERE id_transaksi = ?";
            $stmt_update_transaksi = $koneksi->prepare($sql_update_transaksi);
            $stmt_update_transaksi->execute([$id_transaksi]);

            if ($stmt_update_transaksi->rowCount() > 0) {
                $response = [
                    'sukses' => true,
                    'pesan' => 'Transaksi telah ditolak karena koin yang dipakai adalah 0'
                ];
            } else {
                $response = [
                    'sukses' => false,
                    'pesan' => 'Gagal memperbarui status transaksi'
                ];
            }
        } else {
            $sql_update_koin = "UPDATE tb_koin SET koin = koin + ? WHERE username = ?";
            $stmt_update_koin = $koneksi->prepare($sql_update_koin);
            $stmt_update_koin->execute([$koin_dipakai, $username]);

            if ($stmt_update_koin->rowCount() > 0) {
                $id_transaksi = $_POST["id_transaksi"];
                $sql_update_transaksi = "UPDATE tb_transaksi SET id_status = 4 WHERE id_transaksi = ?";
                $stmt_update_transaksi = $koneksi->prepare($sql_update_transaksi);
                $stmt_update_transaksi->execute([$id_transaksi]);

                if ($stmt_update_transaksi->rowCount() > 0) {
                    $response = [
                        'sukses' => true,
                        'pesan' => 'Transaksi telah ditolak dan koin berhasil ditambahkan'
                    ];
                } else {
                    $response = [
                        'sukses' => false,
                        'pesan' => 'Gagal memperbarui status transaksi'
                    ];
                }
            } else {
                $response = [
                    'sukses' => false,
                    'pesan' => 'Gagal menambahkan koin'
                ];
            }
        }
    } catch (PDOException $e) {
        $response = [
            'sukses' => false,
            'pesan' => 'Terjadi kesalahan: ' . $e->getMessage()
        ];
    }

    echo json_encode($response);
}

if ($_GET['aksi'] == "tambahchallenge") {
    $soal = $_POST["soal"];
    $kuota = $_POST["kuota"];
    $id_jenis = $_POST["id_jenis"];
    $id_lvlchallenge = $_POST["id_lvlchallenge"];

    $id_challenge = '';

    $query_nama_jenis = "SELECT nama_jenis FROM tb_jenischallenge WHERE id_jenis = ?";
    $stmt_nama_jenis = $koneksi->prepare($query_nama_jenis);
    $stmt_nama_jenis->execute([$id_jenis]);
    $result_nama_jenis = $stmt_nama_jenis->fetch(PDO::FETCH_ASSOC);

    if ($result_nama_jenis) {
        $nama_jenis = strtolower(str_replace(' ', '', $result_nama_jenis['nama_jenis']));

        $query_count = "SELECT COUNT(*) as count FROM tb_challenge WHERE id_jenis = ?";
        $stmt_count = $koneksi->prepare($query_count);
        $stmt_count->execute([$id_jenis]);
        $result_count = $stmt_count->fetch(PDO::FETCH_ASSOC);

        $id_challenge = $nama_jenis . sprintf("%03d", $result_count['count'] + 1);
    }
    $tropi = 0;
    $koin = 0;

    if ($id_lvlchallenge == "EZ01") {
        $tropi = 2;
        $koin = 500;
    } elseif ($id_lvlchallenge == "MD01") {
        $tropi = 5;
        $koin = 750;
    } elseif ($id_lvlchallenge == "HR01") {
        $tropi = 10;
        $koin = 1000;
    }

    $data = array($id_challenge, $soal, $tropi, $koin, $kuota, $id_jenis, $id_lvlchallenge);

    try {
        $sql = "INSERT INTO tb_challenge (id_challenge, soal, tropi, koin, kuota, id_jenis, id_lvlchallenge) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $koneksi->prepare($sql);

        $stmt->execute($data);

        if ($stmt->rowCount() > 0) {
            $response = [
                'sukses' => true,
                'pesan' => 'Berhasil menambahkan challenge'
            ];
        } else {
            $response = [
                'sukses' => false,
                'pesan' => 'Gagal menambahkan challenge'
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

if ($_GET['aksi'] == "tambahjenischal") {
    $nama_jenis = $_POST["nama_jenis"];

    $data = array($nama_jenis);

    try {
        $sql = "INSERT INTO tb_jenischallenge (nama_jenis) VALUES (?)";
        $stmt = $koneksi->prepare($sql);

        $stmt->execute($data);

        if ($stmt->rowCount() > 0) {
            $response = [
                'sukses' => true,
                'pesan' => 'Berhasil menambahkan jenis challenge'
            ];
        } else {
            $response = [
                'sukses' => false,
                'pesan' => 'Gagal menambahkan jenis challenge'
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

if ($_GET['aksi'] == "hapuschal") {
    $id = $_GET["id_challenge"];

    // Jalankan query DELETE
    $stmt = $koneksi->prepare("DELETE FROM tb_challenge WHERE id_challenge = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {

    } else {
        echo "<script>alert('Gagal menghapus data');</script>";
    }

    // Redirect atau lakukan aksi lain setelah penghapusan
    echo "<script>window.location='../pages/challenge';</script>";
}
if ($_GET['aksi'] == "editchal") {
    $id_challenge = $_POST["id_challenge"];
    $soal = $_POST["soal"];
    $id_lvlchallenge = $_POST["id_lvlchallenge"];

    $tropi = 0;
    $koin = 0;

    if ($id_lvlchallenge == "EZ01") {
        $tropi = 2;
        $koin = 500;
    } elseif ($id_lvlchallenge == "MD01") {
        $tropi = 5;
        $koin = 750;
    } elseif ($id_lvlchallenge == "HR01") {
        $tropi = 10;
        $koin = 1000;
    }

    $data = array(
        $soal,
        $tropi,
        $koin,
        $id_lvlchallenge,
        $id_challenge // Assuming this should come last in the SQL query
    );

    try {
        $sql = "UPDATE tb_challenge SET soal=?, tropi=?, koin=?, id_lvlchallenge=? WHERE id_challenge=?";
        $stmt = $koneksi->prepare($sql);

        $stmt->execute($data);

        if ($stmt->rowCount() > 0) {
            $response = [
                'sukses' => true,
                'pesan' => 'Berhasil mengedit challenge'
            ];
        } else {
            $response = [
                'sukses' => false,
                'pesan' => 'Gagal mengedit challenge'
            ];
        }
    } catch (PDOException $e) {
        // Handle PDO errors
        $response = [
            'sukses' => false,
            'pesan' => 'Terjadi kesalahan: ' . $e->getMessage()
        ];
    }

    echo json_encode($response);
}
if ($_GET['aksi'] == "accchal") {
    $username = $_POST["username"];
    $koin = $_POST["koin"];
    $tropi = $_POST["tropi"];

    try {
        if ($koin >= 0) {
            $id_challenge = $_POST["id_challenge"];

            $sql_update_transaksi = "UPDATE tb_submitchallenge SET id_status = 2 WHERE username = ?";
            $stmt_update_transaksi = $koneksi->prepare($sql_update_transaksi);
            $stmt_update_transaksi->execute([$username]);

            if ($stmt_update_transaksi->rowCount() > 0) {
                $sql_update_koin = "UPDATE tb_koin SET koin = koin + ? WHERE username = ?";
                $stmt_update_koin = $koneksi->prepare($sql_update_koin);
                $stmt_update_koin->execute([$koin, $username]);

                if ($stmt_update_koin->rowCount() > 0) {
                    $sql_update_tropi = "UPDATE tb_tropi SET tropi = tropi + ? WHERE username = ?";
                    $stmt_update_tropi = $koneksi->prepare($sql_update_tropi);
                    $stmt_update_tropi->execute([$tropi, $username]);

                    if ($stmt_update_tropi->rowCount() > 0) {
                        $response = [
                            'sukses' => true,
                            'pesan' => 'Challenge berhasil di setujui. Koin dan tropi telah ditambahkan.'
                        ];
                    } else {
                        $response = [
                            'sukses' => false,
                            'pesan' => 'Gagal menambahkan tropi.'
                        ];
                    }
                } else {
                    $response = [
                        'sukses' => false,
                        'pesan' => 'Gagal menambahkan koin.'
                    ];
                }
            } else {
                $response = [
                    'sukses' => false,
                    'pesan' => 'Gagal memperbarui status transaksi.'
                ];
            }
        }
    } catch (PDOException $e) {
        $response = [
            'sukses' => false,
            'pesan' => 'Terjadi kesalahan: ' . $e->getMessage()
        ];
    }

    echo json_encode($response);
}
if ($_GET['aksi'] == "tlkchal") {
    $username = $_POST["username"];
    $koin = $_POST["koin"];
    $tropi = $_POST["tropi"];
    $id_challenge = $_POST["id_challenge"]; // Dipindahkan ke luar kondisi if

    try {
        if ($koin >= 0) {
            // Perbarui status challenge hanya jika kondisi koin memenuhi syarat
            $sql_update_challenge = "UPDATE tb_submitchallenge SET id_status = 3 WHERE username = ? AND id_challenge=?";
            $stmt_update_challenge = $koneksi->prepare($sql_update_challenge);
            $stmt_update_challenge->execute([$username, $id_challenge]); // Tambahkan $id_challenge ke execute

            if ($stmt_update_challenge->rowCount() > 0) {
                $response = [
                    'sukses' => true,
                    'pesan' => 'Status challenge berhasil diubah menjadi 3.'
                ];
            } else {
                $response = [
                    'sukses' => false,
                    'pesan' => 'Gagal memperbarui status challenge.'
                ];
            }
        } else {
            $response = [
                'sukses' => false,
                'pesan' => 'Nilai koin tidak memenuhi syarat untuk mengubah status challenge.'
            ];
        }
    } catch (PDOException $e) {
        $response = [
            'sukses' => false,
            'pesan' => 'Terjadi kesalahan: ' . $e->getMessage()
        ];
    }

    echo json_encode($response);
}

if ($_GET['aksi'] == "tambah_tugas") {
    $keterangan = $_POST["keterangan"];
    $id_modul = $_POST["id_modul"];

    $data = array($keterangan, $id_modul);

    try {
        $sql = "INSERT INTO tb_tugasakhir (keterangan, id_modul) VALUES (?, ?)";
        $stmt = $koneksi->prepare($sql);

        $stmt->execute($data);

        if ($stmt->rowCount() > 0) {
            $response = [
                'sukses' => true,
                'pesan' => 'Berhasil menambahkan tugas'
            ];
        } else {
            $response = [
                'sukses' => false,
                'pesan' => 'Gagal menambahkan tugas'
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
if ($_GET['aksi'] == "edit_tugas") {
    $id_tugasAkhir = $_POST["id_tugasAkhir"];
    $keterangan = $_POST["soal"];

    $data = array($keterangan, $id_tugasAkhir);

    try {
        $sql = "UPDATE tb_tugasakhir SET keterangan=? WHERE id_tugasAkhir=?";
        $stmt = $koneksi->prepare($sql);

        $stmt->execute($data);

        if ($stmt->rowCount() > 0) {
            $response = [
                'sukses' => true,
                'pesan' => 'Berhasil Mengedit tugas'
            ];
        } else {
            $response = [
                'sukses' => false,
                'pesan' => 'Gagal mengedit tugas'
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
if ($_GET['aksi'] == "hapustugas") {
    $id_tugasAkhir = $_GET["id_tugasAkhir"];

    // Jalankan query DELETE
    $stmt = $koneksi->prepare("DELETE FROM tb_tugasakhir WHERE id_tugasAkhir = ?");
    $stmt->execute([$id_tugasAkhir]);

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

$koneksi = null;

?>