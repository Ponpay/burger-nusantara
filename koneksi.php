<?php
// Koneksi ke database MySQL
$host     = "localhost";
$username = "root";
$password = "";
$database = "db_burger_nusantara";

$koneksi = mysqli_connect($host, $username, $password, $database);

// Cek jika koneksi gagal
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set karakter utf8mb4 agar mendukung karakter khusus
mysqli_set_charset($koneksi, "utf8mb4");
?>
