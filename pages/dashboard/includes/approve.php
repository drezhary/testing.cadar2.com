<?php
// approve.php
include '../../../config/database.php'; // Include file koneksi database
$conn = connectDatabase(); // Pastikan fungsi ini mengembalikan objek PDO

$id = $_GET['id'];

try {
    // Mulai transaksi
    $conn->beginTransaction();

    // Ambil data dari tabel pending_warga berdasarkan id
    $stmt = $conn->prepare("SELECT * FROM anggota_pending WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Masukkan data ke tabel anggota_keluarga
        $stmt_insert = $conn->prepare("INSERT INTO anggota (nik, no_kk, tgl_lahir, tempat_lahir, jenis_kelamin, nama, status_menetap, foto_berkas) 
                                        VALUES (:nik, :no_kk, :tgl_lahir, :tempat_lahir, :jenis_kelamin, :nama, :status_menetap, :foto_berkas)");

        $stmt_insert->bindParam(":nik", $row['nik']);
        $stmt_insert->bindParam(":no_kk", $row['no_kk']);
        $stmt_insert->bindParam(":tgl_lahir", $row['tgl_lahir']);
        $stmt_insert->bindParam(":tempat_lahir", $row['tempat_lahir']);
        $stmt_insert->bindParam(":jenis_kelamin", $row['jenis_kelamin']);
        $stmt_insert->bindParam(":nama", $row['nama']); // Pastikan nama kolom sesuai
        $stmt_insert->bindParam(":status_menetap", $row['status_menetap']);
        $stmt_insert->bindParam(":foto_berkas", $row['foto_berkas']);

        if ($stmt_insert->execute()) {
            // Update status_approve di tabel anggota_pending
            $stmt_update = $conn->prepare("UPDATE anggota_pending SET status_approve = 'Approved' WHERE id = :id");
            $stmt_update->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt_update->execute();

            // Commit transaksi
            $conn->commit();
            echo "<script>
            alert('Data berhasil di approve');
            window.location.href = '../approval.php';
          </script>";
        } else {
            // Rollback jika terjadi kesalahan
            $conn->rollBack();
            echo "Error: Gagal menyimpan ke anggota_keluarga.";
        }
    } else {
        echo "Data tidak ditemukan.";
    }
} catch (Exception $e) {
    // Rollback jika ada error
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
