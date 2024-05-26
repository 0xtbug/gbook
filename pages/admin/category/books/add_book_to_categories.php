<?php
session_start();
require_once '../../../../config.php';
require_once FUNCTIONS_PATH . 'functions.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ' . BASE_URL . 'auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['ids'])) {
        $ids = $_POST['ids'];
        $category_id = $_POST['category_id'];
        $success = true;
        $messages = [];
        
        foreach ($ids as $id) {
            if (!addbooktoCategory($id, $category_id, $conn)) {
                $success = false;
            }
        }

        if ($success) {
            echo json_encode(['status' => 'success', 'message' => 'Semua buku berhasil ditambahkan ke kategori.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat menambahkan beberapa buku ke kategori.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Tidak ada ID yang dipilih.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode permintaan tidak valid.']);
}