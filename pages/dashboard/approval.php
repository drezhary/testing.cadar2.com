<?php

// session_start();
// if (!isset($_SESSION['user'])) {
//     header('Location: login.php'); // Redirect ke login jika belum login
//     exit;
// }
// $user = $_SESSION['user'];

include '../../config/database.php'; // Include file koneksi database
include '../../includes/sidebar.php';
$conn = connectDatabase();
// Ambil data warga dari tabel pending_warga yang statusnya Pending
$result = $conn->query("SELECT * FROM anggota_pending WHERE status_approve = 'Pending'");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Approval Warga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Sidebar styling */
        #sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            transition: all 0.3s;
        }

        #main-content {
            margin-left: 250px;
            transition: all 0.3s;
        }

        /* Sidebar collapse for smaller screens */
        #sidebar.collapsed {
            transform: translateX(-250px);
        }

        #main-content.collapsed {
            margin-left: 0;
        }

        #sidebarToggle {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1030;
        }

        @media (min-width: 768px) {
            #sidebarToggle {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar (included from external HTML) -->
    <div id="sidebar-container"></div>
    <!-- Toggle Button -->
    <button id="sidebarToggle" class="btn btn-primary">Toggle Sidebar</button>
    <div id="main-content" class="p-4">
        <div class="container mt-5">
            <h2 class="mb-4">Approval Data Warga</h2>

            <?php 
            if ($result->rowCount() > 0):
            ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th>Tempat Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Status Tinggal</th>
                            <th>Nomor KK</th>
                            <th>Role Warga</th>
                            <th>Foto Berkas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?= $row['nik']; ?></td>
                                <td><?= $row['nama']; ?></td>
                                <td><?= $row['tgl_lahir']; ?></td>
                                <td><?= $row['tempat_lahir']; ?></td>
                                <td><?= $row['jenis_kelamin']; ?></td>
                                <td><?= $row['status_menetap']; ?></td>
                                <td><?= $row['no_kk']; ?></td>
                                <td><?= $row['stats_dalam_keluarga']; ?></td>
                                <td>
                                    <img src="../uploads/<?= $row['foto_berkas']; ?>" alt="Berkas" width="100">
                                </td>
                                <td>
                                    <a href="includes/approve.php?id=<?= $row['id']; ?>" class="btn btn-success btn-sm">Approve</a>
                                    <a href="../includes/reject.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal<?= $row['id']; ?>">Reject</a>
                                    <!-- Modal Pop-up untuk mengisi alasan reject -->
                                    <div class="modal fade" id="rejectModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="rejectModalLabel">Alasan Penolakan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="../includes/reject.php?id=<?= $row['id']; ?>" method="POST">
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="alasan_reject" class="form-label">Alasan Penolakan:</label>
                                                            <textarea name="alasan_reject" id="alasan_reject" class="form-control" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Reject</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Tidak ada data warga yang pending.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="../includes/main.js"></script>
</body>

</html>