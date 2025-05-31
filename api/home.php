<?php
class KabKota {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function home() {
        return [
            "message" => "Selamat datang di API Kabupaten Kota versi 1.0!",
            "data" => null
        ];
    }
}

// Contoh penggunaan
header('Content-Type: application/json');

$db = null; // atau koneksi database jika ada
$kabkota = new KabKota($db);

$response = $kabkota->home();
echo json_encode($response);
