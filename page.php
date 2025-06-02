<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        // Beranda
        case 'beranda':
            include 'page/beranda.php';
            break;

        // Data Kab/Kota
        case 'data_kab_kota':
            include 'page/datakabkota.php';
            break;
            case 'tambah_kab_kota':
            include 'page/tambahkabkota.php';
            break;
        // Tambahkan case lain jika perlu
        default:
            include 'page/beranda.php';
            break;

    }
} else {
    include 'page/beranda.php';
}
