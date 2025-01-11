<?php
include '../includes/db.php';

// $id_pending = $_GET['id'];
// $nama_warga = $_POST['nama'];
// $nik = $_POST['nik'];
// $tgl_lahir = $_POST['tgl_lahir'];
// $tempat_lahir = $_POST['tempat_lahir'];
$id_pending = isset($_GET['id']) ? $_GET['id'] : null;
$nama_warga = isset($_POST['nama']) ? $_POST['nama'] : null;
$nik = isset($_POST['nik']) ? $_POST['nik'] : null;
$tgl_lahir = isset($_POST['tgl_lahir']) ? $_POST['tgl_lahir'] : null;
$tempat_lahir = isset($_POST['tempat_lahir']) ? $_POST['tempat_lahir'] : null;

// Tambahkan variabel lain sesuai kebutuhan

// Update data yang di-reject
$stmt = $conn->prepare("UPDATE anggota_pending SET nama = ?, nik = ?, tgl_lahir = ?, tempat_lahir = ?, status_approve = 'Pending', alasan_reject = NULL WHERE id = ?");
$stmt->bind_param('ssssi', $nama_warga, $nik, $tgl_lahir, $tempat_lahir, $id_pending);

if ($stmt->execute()) {
    echo "Data berhasil diajukan ulang!";
    // Redirect ke halaman lain atau tampilkan pesan sukses
} else {
    echo "Error: " . $stmt->error;
}
