<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION)) {
    die("Session tidak berfungsi!");
}

// Koneksi database
include '../config/database.php';
$conn = connectDatabase();

// Cek apakah form dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input
    $inputUsername = isset($_POST['username']) ? trim($_POST['username']) : null;
    $inputPassword = isset($_POST['password']) ? $_POST['password'] : null;
    $inputRole = isset($_POST['role']) ? $_POST['role'] : null;

    if (!$inputUsername || !$inputPassword || !$inputRole) {
        header("Location: ../pages/login.php?error=Semua field harus diisi!");
        exit();
    }

    // Query untuk validasi user menggunakan prepared statements
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND role = :role LIMIT 1");
    $stmt->bindParam(':username', $inputUsername);
    $stmt->bindParam(':role', $inputRole);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verifikasi password
        if (password_verify($inputPassword, $user['password'])) {
            // Set session dan redirect ke halaman yang sesuai
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../pages/dashboard/index.php");
            exit();
        } else {
            header("Location: ../pages/login.php?error=Password salah!");
            exit();
        }
    } else {
        header("Location: ../pages/login.php?error=Username atau role salah!");
        exit();
    }
}
