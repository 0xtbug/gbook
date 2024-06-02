<?php
session_start();
require_once '../config.php';
require_once FUNCTIONS_PATH . 'functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . 'auth/login.php');
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $_SESSION['user_id'];
$book_id = sanitizeInput($data['book_id'], $conn);

if (addBookmark($user_id, $book_id, $conn)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
