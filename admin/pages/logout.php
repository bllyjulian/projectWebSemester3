<?php
session_start();

// Hapus semua variabel session
session_unset();

// Hapus semua session yang ada
session_destroy();

// Redirect ke halaman login
header("Location: ../../loginpage/login.php");
exit();
?>
