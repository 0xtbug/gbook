<?php
require_once '../../../../config.php';
require_once FUNCTIONS_PATH . 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kategori = $_POST['nama_kategori'];
    addCategoryJournalArticel($nama_kategori, $conn);
}
?>
