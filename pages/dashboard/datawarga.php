<?php
// session_start();
// if (!isset($_SESSION['role'])) {
//     header('Location: /../login.php'); // Redirect ke login jika belum login
//     exit;
// }
// $user = $_SESSION['role'];

require_once '../../includes/functions.php';
$data = getData('anggota');

?>
<?php include '../../includes/sidebar.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <!-- Main Content -->
    <div id="main-content" class="p-4">
        <h1>Data Warga</h1>
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
                            url: '../../includes/ajax_handler.php', // Ganti dengan nama file PHP yang memproses pencarian
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
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="../includes/main.js"></script>

</body>

</html>