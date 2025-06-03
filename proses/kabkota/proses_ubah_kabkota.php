<?php
include("../../conf/koneksi.php");
const TARGET_DIR = "../../image/logo/";
const ALLOWED_EXT = array("jpg", "jpeg", "gif");
const MAX_FILE_SIZE = 512000;

function checkImage($image, $remove_image) {
    $filename = $_FILES[$image]['name'];
    $tmpname = $_FILES[$image]['tmp_name'];
    $tmp_ext = pathinfo($filename, PATHINFO_EXTENSION);
    $target_file = TARGET_DIR . basename($filename);

    // cek apakah file yang diupload
    if ($_FILES[$image]['error'] != UPLOAD_ERR_OK) {
        return("Tidak ada file yang diupload atau error!");
    }

    $image = getimagesize($tmpname);
    // cek apakah file image atau bukan
    if (!$image) {
        return("File yang diupload bukan image!");
    }

    // cek apakah file sudah ada
    if (file_exists($target_file)) {
        return("File yang diupload sudah ada, silahkan ganti nama file!");
    }

    // cek ukuran file
    if ($_FILES[$image]['size'] > MAX_FILE_SIZE) {
        return("Ukuran file yang diupload melebihi 512KB!");
    }

    // cek ekstensi file
    if (!in_array($tmp_ext, ALLOWED_EXT)) {
        return("Ekstensi file yang diupload tidak diperbolehkan (upload hanya .png | .jpg | .jpeg | .gif)!");
    }

    if (move_uploaded_file($tmpname, $target_file)) {
        if (file_exists($remove_image)) {
            unlink($remove_image);
        }
        return("OK");
    } else {
        return("Gagal mengupload file! $target_file");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $kabupaten_kota = $_POST['kabupaten_kota'];
    $pusat_pemerintahan = $_POST['pusat_pemerintahan'];
    $bupati_walikota = $_POST['bupati_walikota'];
    $tanggal_berdiri = $_POST['tanggal_berdiri'];
    $luas_wilayah = $_POST['luas_wilayah'];
    $jumlah_penduduk = $_POST['jumlah_penduduk'];
    $jumlah_kecamatan = $_POST['jumlah_kecamatan'];
    $jumlah_kelurahan = $_POST['jumlah_kelurahan'];
    $jumlah_desa = $_POST['jumlah_desa'];
    $url_peta_wilayah = $_POST['url_peta_wilayah'];
    $deskripsi = $_POST['deskripsi'];
    $ubah_logo = isset($_POST['ubah_logo']) && $_POST['ubah_logo'] ? true : false;

    if ($ubah_logo) {
        $remove_image = "../image/logo/" . $_POST['logo_lama'];
        $result = checkImage('logo', $remove_image);
        $filename = $_FILES['logo']['name'];

        if ($result == "OK") {
            $query = "UPDATE tb_kab_kota SET
                kabupaten_kota = '$kabupaten_kota',
                pusat_pemerintahan = '$pusat_pemerintahan',
                bupati_walikota = '$bupati_walikota',
                tanggal_berdiri = '$tanggal_berdiri',
                luas_wilayah = '$luas_wilayah',
                jumlah_penduduk = '$jumlah_penduduk',
                jumlah_kecamatan = '$jumlah_kecamatan',
                jumlah_kelurahan = '$jumlah_kelurahan',
                jumlah_desa = '$jumlah_desa',
                url_peta_wilayah = '$url_peta_wilayah',
                deskripsi = '$deskripsi',
                logo = '$filename'
                WHERE id = $id";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<script>alert('Berhasil mengubah data Kabupaten/kota'); 
                window.location = '../index.php?page=data_kabkota';</script>";
            } else {
                echo "<script>alert('Gagal mengubah data Kabupaten/kota, coba cek isian anda!');
                window.location = '../index.php?page=ubah_kabkota&id=$id';</script>";
            }
        } else {
            echo "<script>alert('$result'); 
            window.location = '../index.php?page=ubah_kabkota&id=$id';</script>";
        }
    } else {
        $query = "UPDATE tb_kab_kota SET
            kabupaten_kota = '$kabupaten_kota',
            pusat_pemerintahan = '$pusat_pemerintahan',
            bupati_walikota = '$bupati_walikota',
            tanggal_berdiri = '$tanggal_berdiri',
            luas_wilayah = '$luas_wilayah',
            jumlah_penduduk = '$jumlah_penduduk',
            jumlah_kecamatan = '$jumlah_kecamatan',
            jumlah_kelurahan = '$jumlah_kelurahan',
            jumlah_desa = '$jumlah_desa',
            url_peta_wilayah = '$url_peta_wilayah',
            deskripsi = '$deskripsi'
            WHERE id = $id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>alert('Berhasil mengubah data Kabupaten/kota'); 
            window.location = '../../index.php?page=data_kabkota';</script>";

        } else {
            echo "<script>alert('Gagal mengubah data Kabupaten/kota, coba cek isian anda!');
            window.location = '../../index.php?page=data_kabkota';</script>";

        }
    }
}
?>
