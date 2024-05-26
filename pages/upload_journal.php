<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . 'auth/login.php');
    exit();
}


require_once TEMPLATE_PATH . '/header.php';
require_once TEMPLATE_PATH . '/navbar.php';
require_once FUNCTIONS_PATH . 'functions.php';

?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
        
    </div>
  </div>

<?php require_once TEMPLATE_PATH . '/footer.php'; ?>
