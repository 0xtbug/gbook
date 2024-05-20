<?php
session_start();
include_once('../database/config.php');

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit();
}
include('../template/header.php');
include('../template/navbar.php');
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
        <div class="col-md-3 grid-margin grid-margin-md-0">
          <div class="card shadow-sm">
            <div class="card-body">
              <img src="Cover-algo.jpg" class="card-img-top" alt="...">
              <p class="card-text mt-2">Kurnia Adi Cahyanto. M.Kom.</p>
              <h4 class="card-title">Algoritma & Pemrograman</h4>
            </div>
          </div>
        </div>
    </div>
  </div>

<?php include("../template/footer.php") ?>