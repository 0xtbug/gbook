<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: auth/login.php'); 
    exit();
}else{
    header('Location: books/manage_books.php');
    exit();
}
