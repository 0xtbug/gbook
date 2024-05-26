<?php
require_once '../../../../config.php';
require_once DATABASE_PATH . '/db_connection.php';
require_once FUNCTIONS_PATH . 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        deleteCategoryJournalArticel($id, $conn);
    } elseif (isset($_POST['ids'])) {
        foreach ($_POST['ids'] as $id) {
            deleteCategoryJournalArticel($id, $conn);
        }
    }
}
?>
