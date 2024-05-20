<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: auth/login.php'); 
    exit();
}else{
    header('Location: pages/dashboard.php');
    exit();
}
