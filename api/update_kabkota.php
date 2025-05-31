<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, PUT, OPTIONS');

include_once('conf/db_config.php');
include_once('model/kabkota.php');

$database = new Database();
$db = $database->connect();
$kabkota = new KabKota($db);

const TARGET_DIR = "./image/logo/";
const ALLOWED_EXT = ['png', 'jpg', 'jpeg', 'gif'];
const MAX_FILE_SIZE = 512000; // 500KB

function checkImage($imageKey, $remove_image = null) {
    if (!isset($_FILES[$imageKey])) {
        return ['success' => false, 'message' => "File image tidak ditemukan!"];
    }

    if ($_FILES[$imageKey]['error'] === UPLOAD_ERR_NO_FILE || $_FILES[$imageKey]['size'] === 0) {
        return ['success' => false, 'message' => "Tidak ada file yang diupload!"];
    }

    $filename = $_FILES[$imageKey]['name'];
    $ukuran = $_FILES[$imageKey]['size'];
    $tmp_file = $_FILES[$imageKey]['tmp_name'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if ($_FILES[$imageKey]['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => "Error upload file: " . $_FILES[$imageKey]['error']];
    }

    if (!getimagesize($tmp_file)) {
        return ['success' => false, 'message' => "File yang diupload bukan image!"];
    }

    if (!in_array($ext, ALLOWED_EXT)) {
        return ['success' => false, 'message' => "Ekstensi file tidak diperbolehkan (hanya png, jpg, jpeg, gif)"];
    }

    if ($ukuran > MAX_FILE_SIZE) {
        return ['success' => false, 'message' => "Ukuran file melebihi batas 500KB!"];
    }

    if (!is_dir(TARGET_DIR)) {
        if (!mkdir(TARGET_DIR, 0777, true)) {
            return ['success' => false, 'message' => "Gagal membuat direktori untuk menyimpan gambar."];
        }
    }

    $newFilename = uniqid() . '.' . $ext;
    $target_file = TARGET_DIR . $newFilename;

    if (!move_uploaded_file($tmp_file, $target_file)) {
        return ['success' => false, 'message' => "Gagal menyimpan file. Pastikan folder memiliki izin tulis."];
    }

    // Hapus file lama jika ada
    if ($remove_image) {
        $remove_file = TARGET_DIR . $remove_image;
        if (file_exists($remove_file)) {
            @unlink($remove_file);
        }
    }

    return ['success' => true, 'filename' => $newFilename];
}

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Supaya bisa ambil $_POST & $_FILES biasa meski PUT biasanya tidak support multipart/form-data
    // Saran: update lewat POST, jangan PUT, karena PUT tidak mudah support file upload di PHP

    // Gunakan POST agar upload file bisa diterima, karena PUT tidak mendukung $_FILES di PHP dengan mudah

    $method = $_SERVER['REQUEST_METHOD'];
    if ($method === 'PUT') {
        // Biasanya sulit handle PUT multipart/form-data,
        // tapi kita fallback ke POST jika bisa (atau ubah client jadi POST)
        http_response_code(400);
        echo json_encode(['message' => 'Untuk upload file gunakan POST, bukan PUT', 'data' => null]);
        exit;
    }

    $data = $_POST;

    if (empty($data) || !isset($data['id'])) {
        echo json_encode(['message' => 'Data tidak lengkap atau ID tidak ada', 'data' => null]);
        exit;
    }

    $logo = null;
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $remove_image = $data['logo'] ?? null;
        $uploadResult = checkImage('image', $remove_image);
        if ($uploadResult['success']) {
            $logo = $uploadResult['filename'];
        } else {
            echo json_encode(['message' => $uploadResult['message'], 'data' => null]);
            exit;
        }
    }

    // Siapkan data params untuk update
    $params = [
        'id' => $data['id'],
        'kabupaten_kota' => $data['kabupaten_kota'] ?? '',
        'pusat_pemerintahan' => $data['pusat_pemerintahan'] ?? '',
        'bupati_walikota' => $data['bupati_walikota'] ?? '',
        'tanggal_berdiri' => $data['tanggal_berdiri'] ?? '',
        'luas_wilayah' => $data['luas_wilayah'] ?? '',
        'jumlah_penduduk' => $data['jumlah_penduduk'] ?? '',
        'jumlah_kecamatan' => $data['jumlah_kecamatan'] ?? '',
        'jumlah_kelurahan' => $data['jumlah_kelurahan'] ?? '',
        'jumlah_desa' => $data['jumlah_desa'] ?? '',
        'url_peta_wilayah' => $data['url_peta_wilayah'] ?? '',
        'deskripsi' => $data['deskripsi'] ?? '',
        'logo' => $logo ?? ($data['logo'] ?? null)
    ];

    // Panggil fungsi update dengan logo jika ada, atau tanpa logo
    if ($kabkota->updateKabKota($params)) {
        echo json_encode(['message' => 'Data kabupaten kota berhasil diupdate', 'data' => $params]);
    } else {
        // Jika gagal, hapus file yang baru diupload agar tidak mubazir
        if ($logo) {
            @unlink(TARGET_DIR . $logo);
        }
        http_response_code(400);
        echo json_encode(['message' => 'Data kabupaten kota gagal diupdate', 'data' => null]);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Metode request tidak diizinkan!', 'data' => null]);
}
