<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

// Cek apakah NIK ada dalam parameter URL
if (isset($_POST['nik'])) {
    $nik = $_POST['nik'];  // Dapatkan NIK dari URL

    // Ambil data warga dari tabel pending_warga berdasarkan NIK
    $query = $conn->prepare("SELECT * FROM anggota_pending WHERE nik = ?");
    if (!$query) {
        die("Error prepare: " . $conn->error);
    }
    $query->bind_param('i', $nik);
    $query->execute();
    $result = $query->get_result();

    // Cek apakah ada hasil
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        // Jika tidak ada data, tampilkan pesan error
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    // Jika NIK tidak ada, tampilkan pesan error
    echo "NIK tidak ditentukan.";
    exit;
}

// Jika data ditemukan, tampilkan form pengajuan ulang
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Ulang Data Warga</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Ajukan Ulang Data Warga</h2>
        <form action="update_pengajuan.php?id=<?= $data['id']; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Warga</label>
                <input type="text" class="form-control" name="nama" value="<?= $data['nama']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control" name="nik" value="<?= $data['nik']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" name="tgl_lahir" value="<?= $data['tgl_lahir']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" name="tempat_lahir" value="<?= $data['tempat_lahir']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-control" name="jenis_kelamin" required>
                    <option value="Laki - laki" <?= ($data['jenis_kelamin'] == 'Laki - laki') ? 'selected' : ''; ?>>Laki - laki</option>
                    <option value="Perempuan" <?= ($data['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status_tinggal" class="form-label">Status Tinggal</label>
                <select class="form-control" name="status_tinggal" required>
                    <option value="Menetap" <?= ($data['status_menetap'] == 'Menetap') ? 'selected' : ''; ?>>Menetap</option>
                    <option value="Tidak Menetap" <?= ($data['status_menetap'] == 'Tidak Menetap') ? 'selected' : ''; ?>>Tidak Menetap</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="no_kk" class="form-label">Nomor Kartu Keluarga</label>
                <input type="text" class="form-control" name="no_kk" value="<?= $data['no_kk']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="blok" class="form-label">Blok</label>
                <input type="text" class="form-control" name="blok" value="<?= $data['blok']; ?>">
            </div>
            <div class="mb-3">
                <label for="no_rumah" class="form-label">Nomor Rumah</label>
                <input type="text" class="form-control" name="no_rumah" value="<?= $data['no_rumah']; ?>">
            </div>
            <div class="mb-3">
                <label for="rt" class="form-label">RT</label>
                <input type="text" class="form-control" name="rt" value="<?= $data['rt']; ?>">
            </div>
            <div class="mb-3">
                <label for="rw" class="form-label">RW</label>
                <input type="text" class="form-control" name="rw" value="<?= $data['rw']; ?>">
            </div>
            <div class="mb-3">
                <label for="foto_berkas" class="form-label">Foto Berkas</label>
                <input type="file" class="form-control" name="foto_berkas" accept="image/*">
                <small class="form-text text-muted">*Opsional. Jika Anda ingin mengganti foto berkas yang ada.</small>
            </div>
            <button type="submit" class="btn btn-primary">Ajukan Ulang</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>