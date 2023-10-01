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
    if ($_GET['aksi'] == "tambahakun") {
        $username = $_POST["username"];
        $nama_lengkap = $_POST["nama_lengkap"];
        $password = $_POST["password"];
        $foto_profil = file_get_contents($_FILES["foto_profil"]["tmp_name"]);
        $no_hp = $_POST["nomor_hp"];
        $email = $_POST["email"];
        $status = $_POST["status"];
        $id_lvl = $_POST["hak_akses"];
    
        $data = array(
            $username,
            $nama_lengkap,
            $password,
            $foto_profil,
            $no_hp,
            $email,
            $status,
            $id_lvl
        );
    
        $sql = "INSERT INTO tb_akun (username, nama_lengkap, password, foto_profil, no_hp, email, status, id_lvl) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
    
        // Eksekusi query dengan menggunakan array $data
        $stmt->execute($data);
        // Cek apakah data berhasil disimpan
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Data berhasil disimpan');</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data');</script>";
    }
    
        echo "<script>window.location='../pages/akunAdmin.php';</script>";
    }
//edit akun
    // if ($_GET['aksi'] == "editakun") {
    //     $username = $_POST["username"];
    //     $nama_lengkap = $_POST["nama_lengkap"];
    //     $password = $_POST["password"];
    //     $foto_profil = file_get_contents($_FILES["foto_profil"]["tmp_name"]);
    //     $no_hp = $_POST["nomor_hp"];
    //     $email = $_POST["email"];
    //     $status = $_POST["status"];
    //     $id_lvl = $_POST["hak_akses"];
    
    //     $data = array(
    //         $username,
    //         $nama_lengkap,
    //         $password,
    //         $foto_profil,
    //         $no_hp,
    //         $email,
    //         $status,
    //         $id_lvl,
    //         $id
    //     );
    
    //     $sql = "UPDATE tb_akun SET username = ?, nama_lengkap = ?, password = ?, foto_profil = ?, no_hp = ?, email = ?, status = ?, id_lvl = ? WHERE username = ?";
    //     $stmt = $koneksi->prepare($sql);
    
    //     // Eksekusi query dengan menggunakan array $data
    //     $stmt->execute($data);
    
    //     // Cek apakah data berhasil diubah
    //     if ($stmt->rowCount() > 0) {
    //         echo "<script>alert('Data berhasil diubah');</script>";
    //     } else {
    //         echo "<script>alert('Gagal mengubah data');</script>";
    //     }
    
    //     echo "<script>window.location='../pages/akunAdmin.php';</script>";
    // }
    if ($_GET['aksi'] == "editakun") {
        $username = $_POST["username"];
        $nama_lengkap = $_POST["nama_lengkap"];
        // tambahkan field lain sesuai kebutuhan
    
        // Jalankan query UPDATE
        $stmt = $koneksi->prepare("UPDATE tb_akun SET nama_lengkap = ? WHERE username = ?");
        $stmt->execute([$nama_lengkap, $username]);
    
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Data berhasil diubah');</script>";
        } else {
            echo "<script>alert('Gagal mengubah data');</script>";
        }
    
        echo "<script>window.location='tambahakun.php';</script>";
    }
    
    
    if ($_GET['aksi'] == "hapusakun") {
        $username = $_GET["username"];
    
        // Jalankan query DELETE
        $stmt = $koneksi->prepare("DELETE FROM tb_akun WHERE username = ?");
        $stmt->execute([$username]);
    
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Data berhasil dihapus');</script>";
        } else {
            echo "<script>alert('Gagal menghapus data');</script>";
        }
    
        // Redirect atau lakukan aksi lain setelah penghapusan
        echo "<script>window.location='../pages/akunAdmin.php';</script>";
    }
    
    if(!empty($_GET['aksi'] == "edit")) {
        $id =  (int)$_GET["id"];
        $data[] =  $_POST["kd_barang"];
        $data[] =  $_POST["nama_barang"];
        $data[] =  $_POST["satuan"];
        $data[] =  $_POST["harga"];

        $data[] = $id;
        $sql = "UPDATE barang SET kd_barang = ?, nama_barang = ?, satuan = ?, harga = ?  WHERE id = ? ";
        $row = $koneksi->prepare($sql);
        $row->execute($data);

        echo "<script>window.location='index.php';</script>";

    }

    if(!empty($_GET['aksi'] == 'logout'))
    {
        session_destroy();
        echo "<script>window.location='login.php?signout=success';</script>";
    }