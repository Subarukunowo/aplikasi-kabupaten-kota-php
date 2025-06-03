<?php
include('../conf/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "SELECT * FROM tb_user WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $username = $row['username'];

        $queryDelete = "DELETE FROM tb_user WHERE id = '$id'";
        $deleteResult = mysqli_query($conn, $queryDelete);

        if ($deleteResult) {
            echo "<script>alert('Berhasil menghapus data $username.');</script>";
        } else {
            echo "<script>alert('Gagal menghapus data $username, terjadi kesalahan.');</script>";
        }
    } else {
        echo "<script>alert('Data tidak ditemukan.');</script>";
    }

    echo "<script>window.location = '../index.php?page=data_user';</script>";
}
?>
