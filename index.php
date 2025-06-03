<?php
$request_uri = $_SERVER['REQUEST_URI'];
if (strpos($request_uri, '&') !== false) {
    $request_uri = substr($request_uri, 0, strpos($request_uri, '&'));
}

$adder = 'kabupaten-kota';
$beranda = array($adder, $adder.'index.php', $adder.'index.php?page=beranda');

$kab_kota_active = array(
    $adder.'index.php?page=data_kabkota',
    $adder.'index.php?page=tambah_kabkota',
    $adder.'index.php?page=ubah_kabkota',
);

$user_active = array(
    $adder.'index.php?page=data_user',
    $adder.'index.php?page=tambah_user',
    $adder.'index.php?page=ubah_user',
);


$kelola_data = array_merge($kab_kota_active, $user_active);
session_start();
if(!isset($_SESSION['email'])){
    echo "<script>alert('Anda harus login terlebih dahulu!'); 
    window.location.href='page/user/login.php'</script>";
} else {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $request_uri = $_SERVER['REQUEST_URI'];
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Kabupaten Kota</title>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

  <!-- Tempus Dominus (Date Picker) -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

  <!-- Summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

  <!-- AdminLTE -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <!-- Custom Style: Hilangkan tombol panah input number -->
  <style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>

  <!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="#" class="brand-link">
    <img src="images/polbeng.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">KabKota App</span>
  </a>
  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Admin</a>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

        <!-- Menu Beranda -->
        <li class="nav-item">
          <a href="index.php?page=beranda" class="nav-link <?= in_array($request_uri, $beranda) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-home"></i>
            <p>Beranda</p>
          </a>
        </li>

        <!-- Menu Kelola Data -->
        <li class="nav-item <?= in_array($request_uri, $kelola_data) ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= in_array($request_uri, $kelola_data) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-briefcase"></i>
            <p>
              Kelola Data
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="index.php?page=data_user" class="nav-link <?= in_array($request_uri, $user_active) ? 'active' : '' ?>">
                <i class="far fa-user nav-icon"></i>
                <p>Pengguna</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="index.php?page=data_kabkota" class="nav-link <?= in_array($request_uri, $kab_kota_active) ? 'active' : '' ?>">
                <i class="far fa-building nav-icon"></i>
                <p>Kabupaten/Kota</p>
              </a>
            </li>
          </ul>
        </li>
<!-- Sidebar user panel (optional) -->
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <a class="d-block"><?= $_SESSION['username'] ?></a>
    </div>
</div>
        <!-- Menu Logout -->
        <li class="nav-item">
          <a href="proses/proses_logout.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <?php include "api/conf/page.php"; ?>
  </div>

  <!-- Footer -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
      Developed By : Depandi Enda
    </div>
    <strong>Copyright &copy; 2023</strong> Admin LTE
  </footer>
</div>

<!-- Scripts -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<!-- Tempus Dominus -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- jQuery Validation -->
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>

<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>

<!-- Custom File Input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<!-- Page Specific Script -->
<script>
$(function () {
  // Inisialisasi DataTable
  $('#kabkota').DataTable({
    paging: true,
    lengthChange: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true
  });

  // Date Picker
  $('#tanggal_berdiri').datetimepicker({
    format: 'YYYY-MM-DD'
  });

  // Validasi Form
  $('#tambahData').validate({
    rules: {
      kabupaten_kota: { required: true, minlength: 3 },
      pusat_pemerintahan: { required: true, minlength: 3 },
      bupati_walikota: { required: true, minlength: 3 },
      tanggal_berdiri: { required: true, dateISO: true },
      luas_wilayah: { required: true, number: true, min: 1 },
      jumlah_penduduk: { required: true, number: true, min: 1 },
      jumlah_kecamatan: { required: true, number: true, min: 1 },
      jumlah_kelurahan: { required: true, number: true, min: 0 },
      jumlah_desa: { required: true, number: true, min: 0 },
      url_peta_wilayah: { required: true, url: true },
      deskripsi: { required: true, minlength: 10 },
      logo: { required: true, extension: "jpg|jpeg|png|gif" }
    },
    messages: {
      kabupaten_kota: {
        required: "Silahkan masukan data kabupaten/kota baru!",
        minlength: "Panjang nama kabupaten/kota minimal 3 karakter"
      },
      pusat_pemerintahan: {
        required: "Silahkan masukan data pusat pemerintahan!",
        minlength: "Panjang nama pusat pemerintahan minimal 3 karakter"
      },
      bupati_walikota: {
        required: "Silahkan masukan data kepala daerah!",
        minlength: "Panjang nama kepala daerah minimal 3 karakter"
      },
      tanggal_berdiri: {
        required: "Silahkan masukan data tanggal berdiri!",
        dateISO: "Format tanggal yang anda masukan salah!"
      },
      luas_wilayah: {
        required: "Silahkan masukan data luas wilayah!",
        number: "Silahkan masukan angka desimal!",
        min: "Nilai tidak boleh nol atau negatif!"
      },
      jumlah_penduduk: {
        required: "Silahkan masukan data jumlah penduduk!",
        number: "Silahkan masukan angka desimal!",
        min: "Nilai tidak boleh nol atau negatif!"
      },
      jumlah_kecamatan: {
        required: "Silahkan masukan data jumlah kecamatan!",
        number: "Silahkan masukan angka desimal!",
        min: "Nilai tidak boleh nol atau negatif!"
      },
      jumlah_kelurahan: {
        required: "Silahkan masukan data jumlah kelurahan!",
        number: "Silahkan masukan angka desimal!"
      },
      jumlah_desa: {
        required: "Silahkan masukan data jumlah desa!",
        number: "Silahkan masukan angka desimal!"
      },
      url_peta_wilayah: {
        required: "Silahkan masukan data url!",
        url: "Silahkan masukan link url yang benar!"
      },
      deskripsi: {
        required: "Silahkan masukan data deskripsi!",
        minlength: "Panjang teks deskripsi singkat minimal 10 karakter!"
      },
      logo: {
        required: "Silahkan masukan data logo!",
        extension: "Ekstensi file logo yang diizinkan adalah .jpg|.jpeg|.png|.gif"
      }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element) {
      $(element).removeClass('is-invalid');
    }
  });

  // Editor Summernote
  $('#deskripsi').summernote({
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'italic', 'underline', 'clear']],
      ['fontname', ['fontname']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['height', ['height']],
      ['insert', ['link']],
      ['view', ['fullscreen', 'codeview']]
    ]
  });

  // Inisialisasi file input custom
  bsCustomFileInput.init();
});
function disableLogo(checkboxElem) {
  const logoInput = document.getElementById('logo');
  logoInput.disabled = !checkboxElem.checked;
}
$(function () {
    // Data table kabkota
    $('#kabkota').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });

    // Data table user
    $('#user').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });

    // Date picker
    $('#tanggal_berdiri').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    // Validasi form tambahUser
    $('#tambahUser').validate({
        rules: {
            username: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            },
            no_hp: {
                required: true,
                rangelength: [10, 16]
            },
            password: {
                required: true,
                rangelength: [6, 25]
            },
            retype_password: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            username: {
                required: "Silahkan masukan nama pengguna!",
                minlength: "Panjang nama pengguna minimal 3 karakter"
            },
            email: {
                required: "Silahkan masukan data email",
                email: "Format email salah!"
            },
            no_hp: {
                required: "Silahkan masukan data nomor handphone!",
                rangelength: "Jumlah digit nomor handphone antara 10 – 16 digit."
            },
            password: {
                required: "Silahkan masukan password pengguna!",
                rangelength: "Jumlah karakter password harus 6 – 25 karakter."
            },
            retype_password: {
                required: "Silahkan ketik ulang password!",
                equalTo: "Password tidak sama."
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

    // Validasi form tambahData (jika ada)
});
$(function () {
    // Data table kabkota
    $('#kabkota').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });

    // Data table user
    $('#user').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });

    // Date picker
    $('#tanggal_berdiri').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    // Validasi form tambahUser
    $('#tambahUser').validate({
        rules: {
            username: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            },
            no_hp: {
                required: true,
                rangelength: [10, 16]
            },
            password: {
                required: true,
                rangelength: [6, 25]
            },
            retype_password: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            username: {
                required: "Silahkan masukan nama pengguna!",
                minlength: "Panjang nama pengguna minimal 3 karakter"
            },
            email: {
                required: "Silahkan masukan data email!",
                email: "Format email salah!"
            },
            no_hp: {
                required: "Silahkan masukan data nomor handphone!",
                rangelength: "Jumlah digit nomor handphone antara 10 ~ 16 digit."
            },
            password: {
                required: "Silahkan masukan password pengguna!",
                rangelength: "Jumlah karakter password harus 6 ~ 25 karakter."
            },
            retype_password: {
                required: "Silahkan ketik ulang password!",
                equalTo: "Password tidak sama."
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});
function disablePassword(checkboxElem) {
    let value = false;
    if (checkboxElem.checked) {
        value = false;
    } else {
        value = true;
    }
    document.getElementById('password').disabled = value;
    document.getElementById('retype_password').disabled = value;
}

</script>
</body>
</html>