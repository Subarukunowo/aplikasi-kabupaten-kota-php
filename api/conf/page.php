<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        // Beranda
        case 'beranda':
            include 'page/beranda.php';
            break;

        // Data Kab/Kota
        case 'data_kabkota':
            include 'page/data_kabkota.php';
            break;

        // Tambahkan case lain jika perlu
        default:
            include 'page/beranda.php';
            break;
    }
} else {
    include 'page/beranda.php';
}
