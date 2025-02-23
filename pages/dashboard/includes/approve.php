<?php
// approve.php
include '../../../config/database.php'; // Include file koneksi database
$conn = connectDatabase(); // Pastikan fungsi ini mengembalikan objek PDO

$id = $_GET['id'];


try {
    // Mulai transaksi
    $conn->beginTransaction();

    // Ambil data dari tabel anggota_pending berdasarkan id
    $stmt = $conn->prepare("SELECT * FROM anggota_pending WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // Pastikan kita mendapatkan no_reg dari form
$no_reg = isset($_POST['no_reg']) ? $_POST['no_reg'] : null;

if (!$no_reg) {
    echo "Error: Nomor Registrasi tidak boleh kosong!";
    exit;
}

    if ($row) {
        // Ubah nilai keterangan_aktif menjadi 'Aktif'
        $row['keterangan_aktif'] = 'Aktif';
        // Masukkan data ke tabel anggota
        $stmt_insert = $conn->prepare("INSERT INTO anggota (no_reg, nik, no_kk, blok, no_rumah, rt, rw, tgl_lahir, tempat_lahir, jenis_kelamin, nama, status_menetap, stats_dalam_keluarga, keterangan_aktif, foto_berkas) 
                                        VALUES (:no_reg,:nik, :no_kk, :blok, :no_rumah, :rt, :rw, :tgl_lahir, :tempat_lahir, :jenis_kelamin, :nama, :status_menetap, :stats_dalam_keluarga, :keterangan_aktif, :foto_berkas)");

        $stmt_insert->bindParam(":no_reg", $no_reg);
        $stmt_insert->bindParam(":nik", $row['nik']);
        $stmt_insert->bindParam(":no_kk", $row['no_kk']);
        $stmt_insert->bindParam(":blok", $row['blok']);
        $stmt_insert->bindParam(":no_rumah", $row['no_rumah']);
        $stmt_insert->bindParam(":rt", $row['rt']);
        $stmt_insert->bindParam(":rw", $row['rw']);
        $stmt_insert->bindParam(":tgl_lahir", $row['tgl_lahir']);
        $stmt_insert->bindParam(":tempat_lahir", $row['tempat_lahir']);
        $stmt_insert->bindParam(":jenis_kelamin", $row['jenis_kelamin']);
        $stmt_insert->bindParam(":nama", $row['nama']);
        $stmt_insert->bindParam(":status_menetap", $row['status_menetap']);
        $stmt_insert->bindParam(":stats_dalam_keluarga", $row['stats_dalam_keluarga']);
        $stmt_insert->bindParam(":keterangan_aktif", $row['keterangan_aktif']);
        $stmt_insert->bindParam(":foto_berkas", $row['foto_berkas']);

        if ($stmt_insert->execute()) {
            // Update status_approve di tabel anggota_pending
            $stmt_update = $conn->prepare("UPDATE anggota_pending SET status_approve = 'Approved' WHERE id = :id");
            $stmt_update->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt_update->execute();

               // Hapus data dari tabel anggota_pending
               $stmt_delete = $conn->prepare("DELETE FROM anggota_pending WHERE id = :id");
               $stmt_delete->bindParam(":id", $id, PDO::PARAM_INT);
               $stmt_delete->execute();

            // Commit transaksi
            $conn->commit();
            echo "<script>
                    alert('Data berhasil di approve');
                    window.location.href = '../approval.php';
                  </script>";
        } else {
            // Rollback jika terjadi kesalahan
            $conn->rollBack();
            echo "Error: Gagal menyimpan ke anggota.";
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
