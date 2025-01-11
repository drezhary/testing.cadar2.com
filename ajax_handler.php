<?php
require_once 'includes/functions.php';

if (isset($_GET['search'])) {
    // Panggil fungsi getData dengan parameter pencarian
    $result = getData('anggota_keluarga');

    if (isset($result['message'])) {
        echo "<p>" . $result['message'] . "</p>";
    } else {
        if (!empty($result['data'])) {
            echo "<table class='table table-border'>";
            echo "<thead><tr><th>Nama</th><th>No. Reg</th><th>Blok</th><th>No. Rumah</th><th>RT</th><th>RW</th></tr></thead>";
            echo "<tbody>";

            foreach ($result['data'] as $row) {
                echo "<tr>";
                echo "<td>" . $row['nama'] . "</td>";
                echo "<td>" . $row['no_reg'] . "</td>";
                echo "<td>" . $row['blok'] . "</td>";
                echo "<td>" . $row['no_rumah'] . "</td>";
                echo "<td>" . $row['rt'] . "</td>";
                echo "<td>" . $row['rw'] . "</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";

            // Tambahkan pagination
            $current_page = $result['current_page'];
            $total_pages = $result['total_pages'];
            echo "<nav aria-label='Page navigation'>";
            echo "<ul class='pagination justify-content-center'>";

            // Previous button
            if ($current_page > 1) {
                echo "<li><a href='javascript:void(0)' class='page-link' data-page='" . ($current_page - 1) . "'>Previous</a></li>";
            }

            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<li class='" . ($current_page == $i ? 'active' : '') . "'><a href='javascript:void(0)' class='page-link' data-page='" . $i . "'>" . $i . "</a></li>";
            }

            // Next button
            if ($current_page < $total_pages) {
                echo "<li><a href='javascript:void(0)' class='page-link' data-page='" . ($current_page + 1) . "'>Next</a></li>";
            }

            echo "</ul></nav>";
        } else {
            echo "<p>Data tidak ditemukan.</p>";
        }
    }
}
