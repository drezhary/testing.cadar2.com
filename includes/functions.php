<?php
require_once __DIR__ . '/../config/database.php';
function getData($tableName)
{
    $conn = connectDatabase();
    $limit = 25;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start = ($page > 1) ? ($page * $limit) - $limit : 0;
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    if ($conn) {
        // Hitung total data
        $queryhitung = "SELECT COUNT(*) as total FROM anggota WHERE no_reg IS NOT NULL AND no_reg != ''";

        if ($search) {
            $queryhitung .= " AND nama LIKE :search";
        }

        $stmt = $conn->prepare($queryhitung);
        if ($search) {
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        }
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Hitung jumlah halaman yang dibutuhkan
        $total_pages = ceil($total / $limit);

        // Ambil query berdasarkan halaman
        $query = "SELECT nama, no_reg, blok, no_rumah, rt, rw FROM anggota WHERE no_reg IS NOT NULL and no_reg != ''";
        //$query = "SELECT nama, no_reg, blok, no_rumah, rt, rw FROM anggota";

        if ($search) {
            $query .= " AND nama LIKE :search";
        }

        $query .= " ORDER BY no_reg ASC LIMIT :start, :limit;";

        $ambil = $conn->prepare($query);
        if ($search) {
            $ambil->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        }
        $ambil->bindValue(':start', $start, PDO::PARAM_INT);
        $ambil->bindValue(':limit', $limit, PDO::PARAM_INT);
        $ambil->execute();
        $daftaranggota = $ambil->fetchAll(PDO::FETCH_ASSOC);

        return [
            'data' => $daftaranggota,
            'total_pages' => $total_pages,
            'current_page' => $page
        ];
    }

    return []; // Jika koneksi gagal, kembalikan array kosong
}


function createPagination($total_pages, $current_page)
{
    // Jika hanya ada 1 halaman, tidak perlu menampilkan pagination
    if ($total_pages <= 1) return '';

    $paginationHTML = '<nav aria-label="Page navigation example">';
    $paginationHTML .= '<ul class="pagination justify-content-center">';

    // Tombol "Previous"
    if ($current_page > 1) {
        $paginationHTML .= '<li class="page-item">
        <a class="page-link" href="?page=' . ($current_page - 1) . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
        </li>';
    } else {
        $paginationHTML .= '<li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
    }

    // Link halaman
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $current_page) {
            $paginationHTML .= '<li class="page-item active"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        } else {
            $paginationHTML .= '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }
    }

    // Tombol "Next"
    if ($current_page < $total_pages) {
        $paginationHTML .= '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
    } else {
        $paginationHTML .= '<li class="page-item disabled"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
    }

    $paginationHTML .= '</ul>';
    $paginationHTML .= '</nav>';

    return $paginationHTML;
}
