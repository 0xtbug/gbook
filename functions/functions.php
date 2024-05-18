<?php
include_once('../database/config.php');
include_once('alert.php');


function loginUser($email, $password, $conn) {
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    // Mengecek apakah ada user dengan email tersebut
    $query = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($query->num_rows > 0) {
        $user = $query->fetch_assoc();
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Set session atau token di sini
            $_SESSION['user'] = $email;
            alert_timer("Login berhasil.", "../pages/dashboard.php");
        } else {
            alert("error", "Login Gagal", "Kata sandi salah.", "");
        }
    } else {
        alert("error", "Login Gagal", "Email tidak terdaftar.", "");
    }
}

function registerUser($email, $password, $confirm_password, $conn) {
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);
    $confirm_password = $conn->real_escape_string($confirm_password);

    // Cek jika kata sandi dan konfirmasi kata sandi cocok
    if ($password != $confirm_password) {
        alert("error", "Register Gagal", "Kata sandi dan konfirmasi kata sandi tidak cocok.", "register.php");
        exit;
    }

    // Mengecek email sudah ada atau belum
    $query = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($query->num_rows > 0) {
        $user = $query->fetch_assoc();
        if ($user['status'] == 'off') {
            // Jika status off, update kata sandi dan ubah status ke on
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Mengenkripsi kata sandi baru
            $update = $conn->query("UPDATE users SET password='$hashed_password', status='on' WHERE email='$email'");

            if ($update) {
                alert_timer("Pendaftaran berhasil, silakan login.", "login.php");
            } else {
                alert("error", "Register Gagal", "Terjadi kesalahan.", "");
            }
        } elseif ($user['status'] == 'on') {
            // Jika status sudah on, beri tahu bahwa akun tidak dapat dibuat
            alert("error", "Register Gagal", "Email Anda sudah terdaftar di database.", "");
        }
    } else {
        alert("error", "Register Gagal", "Email Anda belum terdaftar di database, akun tidak dapat dibuat.", "");
    }
}
?>
