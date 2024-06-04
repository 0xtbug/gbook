<?php
session_start();
require_once '../config.php';
require_once FUNCTIONS_PATH . 'functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . 'auth/login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $ja_id = generateJAID($user_id);

    if (saveNewSubmission($user_id, $ja_id, $conn)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat membuat submission.']);
    }
}
?>
