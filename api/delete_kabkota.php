<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');

include_once('confdb.config.php');
include_once('model/kabkota.php');

$database = new Database;
$db = $database->connect();
$kabkota = new KabKota($db);

// Ambil ID dari query string (GET)
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data kabkota berdasarkan ID
    $data_kab_kota = $kabkota->readKabKotaById($id);

    if ($data_kab_kota->rowCount()) {
        $row = $data_kab_kota->fetch(PDO::FETCH_OBJ);

        // Hapus file logo jika ada
        $path_dir = "./image/logo/";
        $target_file = $path_dir . $row->logo;
        if (file_exists($target_file)) {
            unlink($target_file);
        }

        // Hapus dari database
        if ($kabkota->deleteKabKota($id)) {
            echo json_encode([
                'message' => 'Berhasil menghapus data kabupaten kota.',
                'data' => $row
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'message' => 'Gagal menghapus data kabupaten kota.',
                'data' => null
            ]);
        }
    } else {
        http_response_code(404);
        echo json_encode([
            'message' => 'Data kabupaten kota tidak ditemukan!',
            'data' => null
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        'message' => 'ID kabupaten kota tidak disertakan!',
        'data' => null
    ]);
}
