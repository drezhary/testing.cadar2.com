<?php
require_once 'includes/functions.php';
$data = getData('anggota_keluarga');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website IKCD</title>
    <!-- Bootstrap framework -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .hero {
            position: relative;
            background-size: cover;
            background-position: center;
            color: white;
            height: 550px;
            /* Tinggi hero, sesuaikan jika perlu */
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            /* Overlay gelap untuk meningkatkan keterbacaan */
        }

        .hero-title {
            font-size: 2.5rem;
            /* Ukuran font untuk judul */
            margin: 0;
            /* Menghapus margin default */
        }

        .hero-subtitle {
            font-size: 1.25rem;
            /* Ukuran font untuk subjudul */
            margin: 10px 0;
            /* Menambahkan margin antara judul dan subjudul */
        }

        @media (max-width: 576px) {
            .hero {
                height: 580px;
                /* Tinggi lebih kecil untuk layar kecil */
            }

            .hero-title {
                font-size: 1.75rem;
                /* Ukuran font lebih kecil untuk layar kecil */
            }

            .hero-subtitle {
                font-size: 1rem;
                /* Ukuran font lebih kecil untuk layar kecil */
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <?php include 'includes/header.php' ?>

        <section class="hero d-flex align-items-center" style="background-image: url('assets/images/header-bg.jpg');">
            <div class="overlay"></div>
            <div class="container text-center">
                <h1 class="hero-title">Selamat Datang di Website Resmi</h1>
                <p class="hero-subtitle">Ikatan Kematian Cahaya Darussallam 2</p>
                <a href="#dataAnggota" class="btn btn-primary btn-lg mt-3">Lihat Data Anggota</a>
            </div>
        </section>

        <section class="mt-4">
            <h1>Data Anggota</h1>
            <!-- Menampilkan tabel data -->
            <form id="searchForm" method="GET" action="" class="mb-3">
                <input type="text" name="search" id="searchInput" placeholder="Cari nama..." class="form-control mb-2">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
            <div id="resultTable" class="table-responsive">

            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    // Tampil data di awal
                    loadData(1);
                    // Pencarian
                    $('#searchForm').on('submit', function(e) {
                        e.preventDefault(); // Mencegah reload halaman
                        loadData(1); // Muat halaman 1 saat pencarian
                    });

                    // Pagination
                    $(document).on('click', '.page-link', function() {
                        var page = $(this).data('page');
                        loadData(page);
                    });

                    // Fungsi untuk memuat data
                    function loadData(page) {
                        var searchValue = $('#searchInput').val(); // Ambil nilai pencarian

                        $.ajax({
                            url: 'ajax_handler.php', // Ganti dengan nama file PHP yang memproses pencarian
                            method: 'GET',
                            data: {
                                search: searchValue,
                                page: page
                            }, // Sertakan page dalam data
                            success: function(response) {
                                // Tampilkan hasil di dalam div resultTable
                                $('#resultTable').html(response);

                                // Scroll ke tabel hasil hanya saat pencarian di lakukan
                                if (page === 1) {
                                    $('html', 'body').animate({
                                        scrollTop: $("#resultTable").offset().top
                                    }, 500);
                                }
                            }
                        });
                    }
                });
            </script>
        </section>

        <section class="mt-4">
            <?php
            // admin_rejected.php
            include '../ikatan_kematian_warga/pages/dashboard/includes/db.php';

            // Ambil data warga yang ditolak dari tabel pending_warga
            $result = $conn->query("SELECT * FROM anggota_pending WHERE status_approve = 'Ditolak'");

            ?>
            <div class="container mt-5">
                <h2 class="mb-4">Data Warga Ditolak</h2>

                <?php if ($result->num_rows > 0): ?>
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Alasan Reject</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['nik']; ?></td>
                                    <td><?= $row['nama']; ?></td>
                                    <td><?= $row['alasan_reject']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Tidak ada data warga yang ditolak.</p>
                <?php endif; ?>
            </div>
        </section>
        <!-- JS Bootstrap-->
        <script src="assets/js/bootstrap.min.js"></script>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-5">
        <p>&copy; 2024 Ikatan Kematian Cahaya Darussallam 2. All rights reserved.</p>
    </footer>
</body>

</html>