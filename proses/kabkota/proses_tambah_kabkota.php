<?php
include("../../conf/koneksi.php"); // Path ke koneksi.php

const TARGET_DIR = "../../images/logo/";
const ALLOWED_EXT = ['png', 'jpg', 'jpeg', 'gif'];
const MAX_FILE_SIZE = 512000; // 500KB

function checkingFile($image) {
    if (!isset($_FILES[$image]) || $_FILES[$image]['error'] !== UPLOAD_ERR_OK) {
        return "Tidak ada file yang diupload atau terjadi error. Kode error: " . $_FILES[$image]['error'];
    }

    $filename = $_FILES[$image]['name'];
    $ukuran = $_FILES[$image]['size'];
    $tmp_file = $_FILES[$image]['tmp_name'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $target_file = TARGET_DIR . basename($filename);

    // Cek MIME
    $valid_mime = ['image/jpeg', 'image/png', 'image/gif'];
    $file_info = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($file_info, $tmp_file);
    finfo_close($file_info);

    if (!in_array($mime_type, $valid_mime)) {
        return "File yang diupload bukan gambar valid";
    }

    if (!in_array($ext, ALLOWED_EXT)) {
        return "Ekstensi file tidak diperbolehkan (png, jpg, jpeg, gif)";
    }

    if ($ukuran > MAX_FILE_SIZE) {
        return "Ukuran file melebihi 500KB";
    }

    if (file_exists($target_file)) {
        return "Nama file sudah ada, silakan rename";
    }

    if (!move_uploaded_file($tmp_file, $target_file)) {
        return "Gagal mengupload file (move_uploaded_file gagal)";
    }

    return "OK";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil dan sanitasi input
    $kabupaten_kota     = mysqli_real_escape_string($conn, $_POST['kabupaten_kota']);
    $pusat_pemerintahan = mysqli_real_escape_string($conn, $_POST['pusat_pemerintahan']);
    $bupati_walikota      = mysqli_real_escape_string($conn, $_POST['bupati_walikota']);
    $tanggal_berdiri     = mysqli_real_escape_string($conn, $_POST['tanggal_berdiri']);
    $luas_wilayah        = mysqli_real_escape_string($conn, $_POST['luas_wilayah']);
    $jumlah_penduduk     = (int) $_POST['jumlah_penduduk'];
    $jumlah_kecamatan    = (int) $_POST['jumlah_kecamatan'];
    $jumlah_kelurahan    = (int) $_POST['jumlah_kelurahan'];
    $jumlah_desa         = (int) $_POST['jumlah_desa'];
    $url_peta_wilayah    = mysqli_real_escape_string($conn, $_POST['url_peta_wilayah']);
    $deskripsi           = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $filename            = basename($_FILES['logo']['name']);

    // Validasi file upload
    $result = checkingFile('logo');
    if ($result !== "OK") {
        echo "<script>alert('$result');</script>";
        echo "<script>window.location = '../../index.php?page=tambah_kabkota';</script>";
        exit;
    }

    // Query insert
    $query = "INSERT INTO tb_kab_kota (
                kabupaten_kota,
                pusat_pemerintahan,
                bupati_walikota,
                tanggal_berdiri,
                luas_wilayah,
                jumlah_penduduk,
                jumlah_kecamatan,
                jumlah_kelurahan,
                jumlah_desa,
                url_peta_wilayah,
                deskripsi,
                logo
              ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param(
        $stmt,
        'ssssdiiiisss',
        $kabupaten_kota,
        $pusat_pemerintahan,
        $bupati_walikota,
        $tanggal_berdiri,
        $luas_wilayah,
        $jumlah_penduduk,
        $jumlah_kecamatan,
        $jumlah_kelurahan,
        $jumlah_desa,
        $url_peta_wilayah,
        $deskripsi,
        $filename
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Berhasil menambahkan data $kabupaten_kota');</script>";
        echo "<script>window.location = '../../index.php?page=data_kabkota';</script>";
    } else {
        $error = mysqli_error($conn);
        echo "<script>alert('Gagal menambahkan data: $error');</script>";
        echo "<script>window.location = '../../index.php?page=tambah_kabkota';</script>";
    }

    mysqli_stmt_close($stmt);
}
?>
