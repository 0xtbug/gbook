<?php
include_once('../database/config.php');
include_once('alert.php');

// =============================== START OF USERS FUNCTIONS ==================================

    function loginUser($email, $password, $conn) {
        $email = $conn->real_escape_string($email);
        $password = $conn->real_escape_string($password);
    
        // Mengecek apakah ada user dengan email tersebut
        $query = $conn->query("SELECT * FROM mahasiswa WHERE email='$email'");
        if ($query->num_rows > 0) {
            $user = $query->fetch_assoc();
            // Cek apakah status user 'off'
            if ($user['status'] == 'off') {
                alert("error", "User belum aktif", "register.php");
            } else {
                // Verifikasi password
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user'] = $email;
                    alert_timer("Berhasil login", "../pages/dashboard.php");
                } else {
                    alert("error", "Password salah", "login.php");
                }
            }
        } else {
            alert("error", "Email tidak terdaftar", "login.php");
        }
    }    

    function registerUser($email, $password, $confirm_password, $conn) {
        $email = $conn->real_escape_string($email);
        $password = $conn->real_escape_string($password);
        $confirm_password = $conn->real_escape_string($confirm_password);

        // Cek jika password dan konfirmasi password sama
        if ($password != $confirm_password) {
            alert("error", "password dan konfirmasi password tidak sama.", "register.php");
            exit;
        }

        // Mengecek email sudah ada atau belum
        $query = $conn->query("SELECT * FROM mahasiswa WHERE email='$email'");
        if ($query->num_rows > 0) {
            $user = $query->fetch_assoc();
            if ($user['status'] == 'off') {
                // Jika status off, update password dan ubah status ke on
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $update = $conn->query("UPDATE mahasiswa SET password='$hashed_password', status='on' WHERE email='$email'");

                if ($update) {
                    alert_timer("Email anda terdaftar di database", "login.php");
                } else {
                    alert("error", "Terjadi kesalahan", "");
                }
            } elseif ($user['status'] == 'on') {
                // Jika status sudah on, beri tahu bahwa akun tidak dapat dibuat
                alert("error", "Email Anda sudah terdaftar di database", "");
            }
        } else {
            alert("error", "Email Anda belum terdaftar di database, akun tidak dapat dibuat", "");
        }
    }

    function logoutUser() {
        session_destroy();
        header("Location: ../auth/login.php");
        exit();
    }

    // =============================== END OF USERS FUNCTIONS ==================================


    // =============================== START OF ADMIN FUNCTIONS ==================================

    function loginAdmin(){
        if ($query->num_rows > 0) {
            
        }
    }













    // =============================== END OF ADMIN FUNCTIONS ==================================