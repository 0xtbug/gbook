<?php
session_start();
require_once '../../../config.php';
require_once FUNCTIONS_PATH . 'functions.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ' . BASE_URL . 'auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        // Hapus satu buku berdasarkan ID
        $id = $_POST['id'];
        deleteBook($id, $conn);
    } elseif (isset($_POST['ids'])) {
        // Hapus beberapa buku berdasarkan ID
        $ids = $_POST['ids'];
        foreach ($ids as $id) {
            deleteBook($id, $conn);
        }
    }
}
?>
