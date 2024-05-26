<?php
include_once 'db_config.php';

// Membuat koneksi
$conn = new mysqli($con['host'], $con['user'], $con['pass'], $con['db']);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}