<?php
// session_start();
// if (!isset($_SESSION['role'])) {
//     header('Location: /../login.php'); // Redirect ke login jika belum login
//     exit;
// }
// $user = $_SESSION['role'];

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
        <h1>Dashboard</h1>
        <p>Ini adalah halaman dashboard utama aplikasi.</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="../includes/main.js"></script>

</body>

</html>