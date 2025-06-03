<?php
require("conf/koneksi.php");
$query = "select * from tb_user";
$daftar_user = mysqli_query($conn, $query);

if (!$daftar_user) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0">Kelola Data <i class="fas fa-angle-right"></i> Pengguna</h1>
      </div>
    </div>
  </div>
</div>

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Daftar Pengguna</h3>
          </div>
          <div class="card-body">
            <a href="index.php?page=tambah_user" type="button" class="btn btn-primary mb-3">
              <i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah Data
            </a>
            <div class="table-responsive">
              <table id="tb_user" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Nomor HP</th>
                    <th style="text-align: center;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 0; ?>
                  <?php foreach ($daftar_user as $row): ?>
                    <tr>
                      <td style="text-align: center;"><?= $no = $no + 1; ?></td>
                      <td><?= $row['username']; ?></td>
                      <td><?= $row['email']; ?></td>
                      <td><?= $row['no_hp']; ?></td>
                      <td style="text-align: center; white-space: nowrap;">
                        <a href="index.php?page=ubah_user&id=<?= $row['id']; ?>" class="btn btn-success btn-sm" role="button" title="Ubah Data">
                          <i class="fas fa-edit"></i>
                        </a>
                     <a href="proses/proses_hapus_user.php?id=<?= $row['id']; ?>" 
   class="btn btn-danger btn-sm" 
   role="button" 
   title="Hapus Data" 
   onclick="return confirm('Apakah anda yakin ingin menghapus pengguna ini?')">
   <i class="fas fa-trash"></i>
</a>

                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div> <!-- /.table-responsive -->
          </div> <!-- /.card-body -->
        </div> <!-- /.card -->
      </div> <!-- /.col-12 -->
    </div> <!-- /.row -->
  </div> <!-- /.container-fluid -->
</div> <!-- /.content -->
