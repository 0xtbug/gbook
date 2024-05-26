<?php
require_once '../../../../config.php';;
require_once FUNCTIONS_PATH . 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_kategori'];
    $nama_kategori = $_POST['nama_kategori'];
    editCategoryBook($id, $nama_kategori, $conn);
}
?>
