<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION)) {
    die("Session tidak berfungsi!");
}


// Koneksi database
include '../includes/db.php';

// Cek apakah form dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input
    $inputUsername = isset($_POST['username']) ? mysqli_real_escape_string($conn, trim($_POST['username'])) : null;
    $inputPassword = isset($_POST['password']) ? $_POST['password'] : null;
    $inputRole = isset($_POST['role']) ? mysqli_real_escape_string($conn, $_POST['role']) : null;

    if (!$inputUsername || !$inputPassword || !$inputRole) {
        die("Semua field harus diisi!");
    }

    // Query untuk validasi user
    $sql = "SELECT * FROM users WHERE username = '$inputUsername' AND role = '$inputRole' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($inputPassword, $user['password'])) {
            // Login berhasil
            $_SESSION['role'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ];
            header("Location: ../public/index.php"); // Redirect ke dashboard
            exit();
        } else {
            // Password salah
            echo "Password salah.";
        }
    } else {
        // Username atau role tidak ditemukan
        echo "Username atau role salah.";
    }
} else {
    // Jika file ini diakses langsung tanpa form submission
    header("Location: ../public/login.php");
    exit();
}

// Tutup koneksi
mysqli_close($conn);
