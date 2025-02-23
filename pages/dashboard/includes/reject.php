<?php
include '../../../config/database.php'; // Include file koneksi database
$conn = connectDatabase(); // Pastikan fungsi ini mengembalikan objek PDO

$id = $_GET['id'];
$alasan_reject = $_POST['alasan_reject'];  // Mengambil alasan reject dari form

try {
    // Mulai transaksi
    $conn->beginTransaction();

    // Update status_approve menjadi 'Rejected' dan masukkan alasan reject
    $stmt = $conn->prepare("UPDATE anggota_pending SET status_approve = 'Rejected', alasan_reject = :alasan_reject WHERE id = :id");
    $stmt->bindParam(":alasan_reject", $alasan_reject, PDO::PARAM_STR);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Commit transaksi
        $conn->commit();
        echo "<script>
            alert('Data berhasil ditolak');
            window.location.href = '../approval.php';
          </script>";
    } else {
        // Rollback jika terjadi kesalahan
        $conn->rollBack();
        echo "Error: Gagal menolak data.";
    }
} catch (Exception $e) {
    // Rollback jika ada error
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
