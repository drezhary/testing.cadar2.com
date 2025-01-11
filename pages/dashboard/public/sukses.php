<?php
// Ambil pesan dari URL (jika ada)
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : "Registrasi berhasil!";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sukses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .message-box {
            padding: 20px;
            text-align: center;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
    <!-- Auto Redirect -->
    <meta http-equiv="refresh" content="3;url=registrasi.php">
</head>

<body>
    <div class="message-box">
        <h4 class="text-success">Sukses!</h4>
        <p><?php echo $message; ?></p>
        <p>Anda akan diarahkan kembali ke halaman registrasi dalam <strong>3 detik</strong>.</p>
        <p><a href="registrasi.php" class="btn btn-primary">Kembali ke Halaman Registrasi</a></p>
    </div>
</body>

</html>