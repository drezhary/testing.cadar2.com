<?php
// Include file koneksi database
include '../includes/db.php';

// Ambil data dari form
$username = $_POST['username'];
$password = $_POST['password'];
$peran = $_POST['role'];

// Validasi input
if (empty($username) || empty($password) || empty($peran)) {
    die("Semua field wajib diisi!");
}

// Enkripsi password
$password_hashed = password_hash($password, PASSWORD_DEFAULT);

// Query untuk memasukkan data ke tabel users
$stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
if (!$stmt) {
    die("Error prepare: " . $conn->error);
}

$stmt->bind_param('sss', $username, $password_hashed, $peran);

if ($stmt->execute()) {
    echo "Akun berhasil didaftarkan!";
    // Redirect ke halaman lain jika perlu
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
