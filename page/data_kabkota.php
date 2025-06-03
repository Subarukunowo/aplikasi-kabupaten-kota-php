<?php
require('api/conf/koneksi.php');

$query = "SELECT * FROM tb_kab_kota";
$result = mysqli_query($conn, $query);

$data_kab_kota = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data_kab_kota[] = $row;
}
?>

<!-- DataTables CSS -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Header -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0">Kelola Data <i class="fas fa-angle-right"></i> Kabupaten/Kota</h1>
      </div>
    </div>
  </div>
</div>

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Daftar Kabupaten/Kota</h3>
      </div>
      <div class="card-body">
        <a href="index.php?page=tambah_kabkota" type="button" class="btn btn-primary mb-3">
          <i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah Data
        </a>
        <div class="table-responsive">
          <table id="tb_kab_kota" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Kabupaten/Kota</th>
                <th>Pusat Pemerintahan</th>
                <th>Kepala Daerah</th>
                <th>Tanggal Berdiri</th>
                <th class="text-center">Logo</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              <?php foreach ($data_kab_kota as $row): ?>
              <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= $row["kabupaten_kota"] ?></td>
                <td><?= $row["pusat_pemerintahan"] ?></td>
                <td><?= $row["bupati_walikota"] ?></td>
                <td><?= $row["tanggal_berdiri"] ?></td>
                <td class="text-center">
                  <?php
                    $logo = $row["logo"];
                    $logo_src = ($logo == null || $logo == '') ? "images/logo/logo_default.png" : "images/logo/$logo";
                  ?>
                  <img src="<?= $logo_src ?>" style="width: 80px;" />
                </td>
                <td class="text-center" style="white-space: nowrap;">
                  <!-- TOMBOL AKSI YANG DIMINTA -->
                  <div style="text-align: center; white-space: nowrap;">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal<?= $row['id'] ?>">
                      <i class="fas fa-eye"></i>
                    </button>
                    <a href="index.php?page=ubah_kabkota&id=<?=$row['id']?>" class="btn btn-success btn-sm" role="button" title="Ubah Data">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="proses/kabkota/proses_hapus_kabkota.php?id=<?=$row['id']?>" class="btn btn-danger btn-sm" role="button" title="Hapus Data" onclick="return confirm('Apakah anda yakin?')">
                      <i class="fas fa-trash"></i>
                    </a>
                  </div>
                </td>
              </tr>

              <!-- Modal Detail -->
              <div class="modal fade" id="modal<?= $row['id'] ?>">
                <div class="modal-dialog modal-dialog-scrollable">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Detail Data <?= $row["kabupaten_kota"] ?></h5>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                      <div class="container">
                        <div class="row">
                          <div class="col-md-12 text-center mb-3">
                            <?php
                              $peta = $row["url_peta_wilayah"];
                              $peta_src = ($peta == null || $peta == '') ? "image/peta/indonesia.svg" : $peta;
                            ?>
                            <img src="<?= $peta_src ?>" style="width: 400px;" />
                          </div>

                          <div class="col-sm-5 col-6">Pusat Pemerintahan</div>
                          <div class="col-sm-7 col-6"><?= $row["pusat_pemerintahan"] ?></div>

                          <div class="col-sm-5 col-6">Kepala Daerah</div>
                          <div class="col-sm-7 col-6"><?= $row["bupati_walikota"] ?></div>

                          <div class="col-sm-5 col-6">Tanggal Berdiri</div>
                          <div class="col-sm-7 col-6"><?= $row["tanggal_berdiri"] ?></div>

                          <div class="col-sm-5 col-6">Luas Wilayah</div>
                          <div class="col-sm-7 col-6"><?= $row["luas_wilayah"] ?> m²</div>

                          <div class="col-sm-5 col-6">Jumlah Penduduk</div>
                          <div class="col-sm-7 col-6"><?= $row["jumlah_penduduk"] ?> jiwa</div>

                          <div class="col-sm-5 col-6">Jumlah Kecamatan</div>
                          <div class="col-sm-7 col-6"><?= $row["jumlah_kecamatan"] ?></div>

                          <div class="col-sm-5 col-6">Jumlah Kelurahan</div>
                          <div class="col-sm-7 col-6"><?= $row["jumlah_kelurahan"] ?></div>

                          <div class="col-sm-5 col-6">Jumlah Desa</div>
                          <div class="col-sm-7 col-6"><?= $row["jumlah_desa"] ?></div>

                          <div class="col-sm-5 col-6">Logo</div>
                          <div class="col-sm-7 col-6">
                            <img src="<?= $logo_src ?>" style="width: 80px;">
                          </div>

                          <div class="col-sm-5 col-6">Link URL Logo</div>
                          <div class="col-sm-7 col-6">
                            <a href="<?= $logo_src ?>" target="_blank"><?= $row["kabupaten_kota"] ?></a>
                          </div>

                          <div class="col-sm-5 col-6">Deskripsi Singkat</div>
                          <div class="col-sm-7 col-6"><?= $row["deskripsi"] ?></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- DataTables Scripts -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
  $(function () {
    $('#kabkota').DataTable({
      paging: true,
      lengthChange: true,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: false,
      responsive: true
    });
  });
</script>