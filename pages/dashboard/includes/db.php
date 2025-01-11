<?php
// db.php

$host = 'localhost';
$user = 'root';
$password = '';  // Ganti sesuai password MySQL kamu
$dbname = 'ikatan_kematian_warga';

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
