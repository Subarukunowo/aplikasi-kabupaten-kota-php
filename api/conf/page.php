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
             case 'tambah_kabkota':
            include 'page/tambah_kabkota.php';
            break;
                case 'ubah_kabkota':
            include 'page/ubah_kabkota.php';
            break;
            case 'data_user':
                if($_SESSION['role'] == 'admin') {
                include 'page/user/data_user.php'; } else{
                    include 'page/401.php';
                }
                break;
                case 'tambah_user':
                     if($_SESSION['role'] == 'admin') {
            include 'page/user/tambah_data_user.php'; } else{
                    include 'page/401.php';
                }
            
            break;
            case 'ubah_user':
                if($_SESSION['role'] == 'admin') {
            include 'page/user/ubah_user.php'; } else{
                    include 'page/401.php';
                }
            break;
        // Tambahkan case lain jika perlu
        default:
            include 'page/beranda.php';
            break;
    }
} else {
    include 'page/beranda.php';
}
