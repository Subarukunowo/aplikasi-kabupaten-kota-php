<?php
include('../conf/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username  = $_POST['username'];
    $email     = $_POST['email'];
    $no_hp     = $_POST['no_hp'];
    $password  = $_POST['password'];
    $role      = 'User';

    $spassword = md5($password); // Gunakan password_hash() untuk keamanan lebih baik

    $query = "INSERT INTO user SET 
                username = '$username',
                email = '$email',
                no_hp = '$no_hp',
                password = '$spassword',
                role = '$role'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Berhasil menambahkan data $username');</script>";
        echo "<script>window.location = '../index.php?page=data_user';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data $username, coba cek isian anda');</script>";
        echo "<script>window.location = '../index.php?page=tambah_user';</script>";
    }
}
?>
