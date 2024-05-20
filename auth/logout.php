<?php

include_once('../functions/functions.php');

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}elseif($_SERVER["REQUEST_METHOD"] == "POST") {
    logoutUser();
}