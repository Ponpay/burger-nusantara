<?php
// Mulai session jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    // Tentukan letak file login.php secara otomatis
    $tujuan_login = file_exists('login.php') ? 'login.php' : (file_exists('../login.php') ? '../login.php' : '../../login.php');
    header("Location: " . $tujuan_login);
    exit;
}
?>
