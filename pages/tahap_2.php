<?php
session_start();
require_once '../config.php';
require_once DATABASE_PATH . 'db_config.php';
require_once FUNCTIONS_PATH . 'functions.php';

if (!isset($_SESSION['user'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit();
}

// Validasi token CSRF
// if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
//     echo json_encode(['error' => 'Invalid CSRF token']);
//     exit();
// }

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES)) {
    $allowedTypes = ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    $fileType = mime_content_type($_FILES['file']['tmp_name']);
    
    // Validasi tipe file
    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(['error' => 'Invalid file type']);
        exit();
    }

    $targetDir = UPLOADS_PATH . 'journals/';
    $fileName = basename($_FILES["file"]["name"]);
    $fileName = preg_replace("/[^a-zA-Z0-9\-\_\.]/", "", $fileName); // Sanitasi nama file
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
        $fileSize = round($_FILES["file"]["size"] / 1024 / 1024, 2) . " MB"; // Ukuran file dalam MB
        $uploadTime = date("H:i"); // Jam upload
        $uploadDate = date("d M Y"); // Tanggal upload

        $response = array(
            "success" => "File berhasil diupload!",
            "size" => $fileSize,
            "time" => $uploadTime,
            "date" => $uploadDate
        );

        // Simpan informasi file ke database
        $user_id = $_SESSION['user_id'];
        if (!saveUploadedDocx($user_id, $fileName, $conn)) {
            $response = array(
                "error" => "Gagal menyimpan informasi file ke database!"
            );
        }
    } else {
        $response = array(
            "error" => "Gagal mengupload file!"
        );
    }

    echo json_encode($response);
}
?>