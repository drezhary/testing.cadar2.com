<?php
// index.php
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nik = $_POST['nik'];
    $no_kk = $_POST['no_kk'];
    $blok = $_POST['blok'];
    $no_rumah = $_POST['no_rumah'];
    $rt = $_POST['rt'];
    $rw = $_POST['rw'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $stats_dalam_keluarga = $_POST['stats_dalam_keluarga'];
    $status_menetap = $_POST['status_menetap'];
    $keterangan_aktif = $_POST['keterangan_aktif'];
    $tanggal_pengajuan = date('Y-m-d H:i:s'); // Tanggal otomatis
    $foto_berkas = '';

    // Proses upload foto berkas
    if (isset($_FILES['foto_berkas']) && $_FILES['foto_berkas']['error'] === 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["foto_berkas"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file adalah gambar
        $check = getimagesize($_FILES["foto_berkas"]["tmp_name"]);
        if ($check !== false) {
            // Pastikan direktori ada
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            if (move_uploaded_file($_FILES["foto_berkas"]["tmp_name"], $target_file)) {
                $foto_berkas = basename($_FILES["foto_berkas"]["name"]);
            } else {
                echo "Error uploading file.";
                exit;
            }
        } else {
            echo "File is not an image.";
            exit;
        }
    }
    // Siapkan query untuk insert data
    $sql = "INSERT INTO anggota_pending (nik, no_kk, blok, no_rumah, rt, rw, nama, jenis_kelamin, tempat_lahir, tgl_lahir, stats_dalam_keluarga, status_menetap, keterangan_aktif, foto_berkas, tanggal_pengajuan, status_approve)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
    // Siapkan statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Kesalahan query: " . $conn->error);
    }
    // Bind parameter
    $stmt->bind_param(
        "sssssssssssssss",
        $nik,
        $no_kk,
        $blok,
        $no_rumah,
        $rt,
        $rw,
        $nama,
        $jenis_kelamin,
        $tempat_lahir,
        $tgl_lahir,
        $stats_dalam_keluarga,
        $status_menetap,
        $keterangan_aktif,
        $foto_berkas,
        $tanggal_pengajuan
    );

    // Eksekusi query
    if ($stmt->execute()) {
        // Jika berhasil, redirect ke halaman sukses
        header("Location: sukses.php?message=Data berhasil disimpan!");
        exit;
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Gagal menyimpan data: " . $stmt->error;
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi (Dua Kolom)</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Form Registrasi Anggota</h2>
        <form action="registrasi.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <!-- NIK -->
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" maxlength="16" placeholder="Masukkan NIK" required>
                    </div>

                    <!-- No KK -->
                    <div class="mb-3">
                        <label for="no_kk" class="form-label">No KK</label>
                        <input type="text" class="form-control" id="no_kk" name="no_kk" maxlength="16" placeholder="Masukkan No KK" required>
                    </div>

                    <!-- Blok -->
                    <div class="mb-3">
                        <label for="blok" class="form-label">Blok</label>
                        <input type="text" class="form-control" id="blok" name="blok" maxlength="10" placeholder="Masukkan Blok">
                    </div>

                    <!-- No Rumah -->
                    <div class="mb-3">
                        <label for="no_rumah" class="form-label">No Rumah</label>
                        <input type="text" class="form-control" id="no_rumah" name="no_rumah" maxlength="10" placeholder="Masukkan No Rumah">
                    </div>

                    <!-- RT -->
                    <div class="mb-3">
                        <label for="rt" class="form-label">RT</label>
                        <input type="text" class="form-control" id="rt" name="rt" maxlength="3" placeholder="Masukkan RT">
                    </div>

                    <!-- RW -->
                    <div class="mb-3">
                        <label for="rw" class="form-label">RW</label>
                        <input type="text" class="form-control" id="rw" name="rw" maxlength="3" placeholder="Masukkan RW">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="jenis_kelamin_l" name="jenis_kelamin" value="L" required>
                                <label class="form-check-label" for="jenis_kelamin_l">Laki-Laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="jenis_kelamin_p" name="jenis_kelamin" value="P">
                                <label class="form-check-label" for="jenis_kelamin_p">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" maxlength="100" placeholder="Masukkan Nama Lengkap" required>
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" maxlength="50" placeholder="Masukkan Tempat Lahir">
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="mb-3">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir">
                    </div>

                    <!-- Status Dalam Keluarga -->

                    <div class="mb-3">
                        <label for="stats_dalam_keluarga" class="form-label">Status dalam Keluarga</label>
                        <select class="form-select" id="stats_dalam_keluarga" name="stats_dalam_keluarga">
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="Kepala Keluarga">Kepala Keluarga</option>
                            <option value="Istri">Istri</option>
                            <option value="Anak">Anak</option>
                            <option value="Kerabat">Kerabat</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <!-- Status Menetap -->
                    <div class="mb-3">
                        <label for="status_menetap" class="form-label">Status Menetap</label>
                        <select class="form-select" id="status_menetap" name="status_menetap">
                            <option value="" disabled selected>Pilih Status Menetap</option>
                            <option value="Tetap">Tetap</option>
                            <option value="Kontrak">Kontrak</option>
                            <option value="Sementara">Sementara</option>
                        </select>
                    </div>

                    <!-- Upload Foto Berkas -->
                    <div class="mb-3">
                        <label for="foto_berkas" class="form-label">Upload Foto Berkas</label>
                        <input type="file" class="form-control" id="foto_berkas" name="foto_berkas">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary mt-3">Daftar</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
                <a href="../../../index.php" class="btn btn-primary">Kembali ke Halaman Depan</a>
            </div>
        </form>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>