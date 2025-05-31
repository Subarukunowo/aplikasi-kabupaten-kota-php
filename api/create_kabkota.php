<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, OPTIONS');

include_once('conf/db_config.php');
include_once('model/kabkota.php');

$database = new Database();
$db = $database->connect();
$kabkota = new KabKota($db);

const TARGET_DIR = "images/logo/";
const ALLOWED_EXT = ['png', 'jpg', 'jpeg', 'gif'];
const MAX_FILE_SIZE = 512000; // 500KB

function checkImage($imageKey) {
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
    $target_file = TARGET_DIR . uniqid() . '.' . $ext;

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

    if (!move_uploaded_file($tmp_file, $target_file)) {
        return ['success' => false, 'message' => "Gagal menyimpan file. Pastikan folder memiliki izin tulis."];
    }

    return ['success' => true, 'filename' => basename($target_file)];
}

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fileKey = 'image';

    // Ambil semua data dari $_POST, bukan dari JSON
    $data = $_POST;

    if (empty($data)) {
        echo json_encode(['message' => 'Tidak ada data yang dikirim!', 'data' => null]);
        exit;
    }

    $logo = null;
    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['size'] > 0) {
        $uploadResult = checkImage($fileKey);

        if ($uploadResult['success'] === true) {
            $logo = $uploadResult['filename'];
        } else {
            echo json_encode(['message' => $uploadResult['message'], 'data' => null]);
            exit;
        }
    }

    $params = [
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
        'logo' => $logo
    ];

    if ($kabkota->createKabKota($params)) {
        echo json_encode([
            'message' => 'Data kabupaten kota berhasil ditambahkan!',
            'data' => $params
        ]);
    } else {
        if ($logo) {
            @unlink(TARGET_DIR . $logo);
        }
        echo json_encode(['message' => 'Gagal menyimpan data ke database!', 'data' => null]);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Metode request tidak diizinkan!', 'data' => null]);
}
