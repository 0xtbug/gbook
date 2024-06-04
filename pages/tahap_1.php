<?php
session_start();
require_once '../config.php';
require_once FUNCTIONS_PATH . 'functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . 'auth/login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $category = sanitizeInput($_POST["category"], $conn);
        $language = sanitizeInput($_POST["language"], $conn);
        $user_id = $_SESSION['user_id'];
    
        if (saveSubmissionData($user_id, $category, $language, $conn)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }