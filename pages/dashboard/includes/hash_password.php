<?php
// File hash_password.php
include '../includes/db.php';

$username = "admin"; // Ganti dengan username pengguna
$newPassword = "admin123"; // Ganti dengan password yang benar

// Buat hash password
$passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);

// Update password ke database
$sql = "UPDATE users SET password = '$passwordHash' WHERE username = '$username'";
if (mysqli_query($conn, $sql)) {
    echo "Password berhasil diupdate!";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
