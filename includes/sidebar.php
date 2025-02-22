<?php
//$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';
?>
<nav id="sidebar" class="d-flex flex-column p-3 bg-dark text-white">
    <h4 class="text-white">Dashboard</h4>
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a href="index.php" class="nav-link text-white active">Beranda</a>
        </li>
        <li class="nav-item">
            <a href="../public/admin.php" class="nav-link text-white">Data Warga</a>
        </li>
        <li class="nav-item">
            <a href="../dashboard/registrasi.php" class="nav-link text-white">Registrasi</a>
        </li>
        <?php 
        //if ($role === 'admin'): 
            ?>
            <li class="nav-item">
                <a href="../dashboard/approval.php" class="nav-link text-white">Approval</a>
            </li>
            <li class="nav-item">
                <a href="../public/tambah_akun.php" class="nav-link text-white">Tambah User</a>
            </li>
        <!-- <?php 
        //elseif ($role === 'rt'): 
        ?> -->
        <!-- <?php 
    //endif; 
    ?> -->
        <li class="nav-item">
            <a href="../../process/logout.php" class="nav-link text-white">Logout</a>
        </li>
    </ul>
</nav>