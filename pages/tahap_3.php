<?php
session_start();
require_once '../config.php';
require_once FUNCTIONS_PATH . 'functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . 'auth/login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = sanitizeInput($_POST["first_name"], $conn);
    $middleName = sanitizeInput($_POST["middle_name"], $conn);
    $lastName = sanitizeInput($_POST["last_name"], $conn);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $affiliation = sanitizeInput($_POST["affiliation"], $conn);
    $country = sanitizeInput($_POST["country"], $conn);
    $user_id = $_SESSION['user_id'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Email tidak valid.']);
        exit();
    }

    if (saveAuthorData($user_id, $firstName, $middleName, $lastName, $email, $affiliation, $country, $conn)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan data.']);
    }
}