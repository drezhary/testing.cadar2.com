<?php
session_start();
if (isset($_SESSION['role'])) {
    header('Location: index.php'); // Redirect ke dashboard jika sudah login
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
            <h4 class="text-center mb-4">Login</h4>
            <form action="../includes/proses_login.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Login Sebagai</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="" selected>Pilih peran...</option>
                        <option value="admin">Admin</option>
                        <option value="rw">RW</option>
                        <option value="rt">RT</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <a href="../../../index.php">Kembali</a>
            </form>
        </div>
    </div>
</body>

</html>