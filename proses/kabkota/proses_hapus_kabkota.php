<?php
include("../../conf/db_conn.php");
const TARGET_DIR = "../../images/logo/";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $id = $_GET['id'];

    $query = "SELECT * FROM tb_kab_kota WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $kabupaten_kota = $row['kabupaten_kota'];
        $logo = $row['logo'];
        $target_file = TARGET_DIR . $logo;

        // Hapus file logo jika ada dan bukan default
        if (!empty($logo) && $logo !== 'logo_default.png' && file_exists($target_file)) {
            unlink($target_file);
        }

        // Hapus dari database
        $deleteQuery = "DELETE FROM tb_kab_kota WHERE id = '$id'";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($deleteResult) {
            echo "<script>alert('Berhasil menghapus data $kabupaten_kota.');</script>";
        } else {
            echo "<script>alert('Gagal menghapus data $kabupaten_kota, terjadi kesalahan.');</script>";
        }
    } else {
        echo "<script>alert('Gagal menghapus, data tidak ditemukan.');</script>";
    }

    // Redirect kembali
    echo "<script>window.location.href = '../../index.php?page=data_kabkota';</script>";
}
?>
