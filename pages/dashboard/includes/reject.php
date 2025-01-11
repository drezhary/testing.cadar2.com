<?php
include 'db.php';

$id_pending = $_GET['id'];
$alasan_reject = $_POST['alasan_reject'];  // Mengambil alasan reject dari form

// Update status_approve menjadi 'Rejected' di tabel pending_warga dan masukkan alasan reject
$stmt = $conn->prepare("UPDATE anggota_pending SET status_approve = 'Ditolak', alasan_reject = ? WHERE id = ?");
if (!$stmt) {
    die("Error prepare: " . $conn->error);
}
$stmt->bind_param('si', $alasan_reject, $id_pending);


if ($stmt->execute()) {
    echo "Data berhasil ditolak.";
} else {
    echo "Error: " . $stmt->error;
}
