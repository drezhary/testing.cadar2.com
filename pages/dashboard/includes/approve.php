<?php
// approve.php
include 'db.php';

$id_pending = $_GET['id'];

// Ambil data dari tabel pending_warga berdasarkan id_pending
$stmt = $conn->prepare("SELECT * FROM anggota_pending WHERE id = ?");
$stmt->bind_param("i", $id_pending);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Masukkan data ke tabel anggota
    $stmt_insert = $conn->prepare("INSERT INTO anggota (nik, no_kk, tgl_lahir, tempat_lahir, jenis_kelamin, nama, status_menetap, foto_berkas) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt_insert) {
        die("Error pada query: " . $conn->error);
    }
    $stmt_insert->bind_param('ssssssss', $row['nik'], $row['no_kk'], $row['tgl_lahir'], $row['tempat_lahir'], $row['jenis_kelamin'], $row['nama'], $row['status_menetap'], $row['foto_berkas']);

    if ($stmt_insert->execute()) {
        // Update status_approve di tabel pending_warga
        $stmt_update = $conn->prepare("UPDATE anggota_pending SET status_approve = 'Approved' WHERE id = ?");
        $stmt_update->bind_param("i", $id_pending);
        $stmt_update->execute();

        echo "Data berhasil di-approve dan dipindahkan ke tabel anggota.";
    } else {
        echo "Error: " . $stmt_insert->error;
    }
} else {
    echo "Data tidak ditemukan.";
}
