<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/assetss/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
    <div class="left-container"></div>
    <div class="right-container">
        <form method="post">
            <center>
                <img src="../assets/img/logo-gubook.png" alt="Gubook Logo">
            </center>
            <h3>Selamat Datang!</h3>

            <label for="email">Alamat Email</label>
            <input type="email" placeholder="Masukkan alamat email" name="email" required>
            <span class="text-danger"></span>

            <label for="password">Kata Sandi</label>
            <input type="password" placeholder="Masukkan kata sandi" name="password" required>
            <span class="text-danger"></span>
        
            <label for="confirm_password">Konfirmasi Kata Sandi</label>
            <input type="password" placeholder="Konfirmasi kata sandi" name="confirm_password" required>
            <span class="text-danger"></span>

            <button type="submit" name="daftar">Daftar</button>

            <div class="register-link">
                <h4>Dengan membuat akun, Anda menyetujui <span class="h4-blue">Ketentuan Layanan</span> dan <span class="h4-blue">Kebijakan Privasi kami</span></h4>
            </div>
            
            <div class="register-link">
                <h4>Sudah punya akun? <a href="./login.php" class="h4-blue">Masuk</a></h4>  
            </div>
            
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>
</html>

<?php
include_once('../functions/functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    registerUser($_POST['email'], $_POST['password'], $_POST['confirm_password'], $conn);
}

?>