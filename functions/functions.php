<?php
include_once ('../database/config.php');
include_once ('alert.php');

// =============================== START OF USERS FUNCTIONS ==================================

function loginUser($email, $password, $conn)
{
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    // Check if email exists in mahasiswa table
    $query = $conn->query("SELECT * FROM mahasiswa WHERE email='$email'");
    if ($query->num_rows > 0) {
        $user = $query->fetch_assoc();
        // Check if user status is 'off'
        if ($user['status'] == 'off') {
            alert("error", "User belum aktif", "register.php");
        } else {
            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $email;
                alert_timer("Berhasil login", "../pages/dashboard.php");
            } else {
                alert("error", "Password salah", "login.php");
            }
        }
    } else {
        // Check if email exists in pengurus table
        $query = $conn->query("SELECT * FROM pengurus WHERE email='$email'");
        if ($query->num_rows > 0) {
            $user = $query->fetch_assoc();
            // Check if user status is 'off'
            if ($user['status'] == 'off') {
                alert("error", "User belum aktif", "register.php");
            } else {
                // Verify password
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
}

function registerUser($email, $password, $confirm_password, $conn)
{
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);
    $confirm_password = $conn->real_escape_string($confirm_password);

    // Check if password and confirm password are the same
    if ($password != $confirm_password) {
        alert("error", "Password dan konfirmasi password tidak sama.", "register.php");
        exit;
    }

    // Check if email exists in mahasiswa table
    $query = $conn->query("SELECT * FROM mahasiswa WHERE email='$email'");
    if ($query->num_rows > 0) {
        $user = $query->fetch_assoc();
        if ($user['status'] == 'off') {
            // If status is off, update password and change status to on
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update = $conn->query("UPDATE mahasiswa SET password='$hashed_password', status='on' WHERE email='$email'");
            if ($update) {
                alert_timer("Email Anda terdaftar di database mahasiswa", "login.php");
            } else {
                alert("error", "Terjadi kesalahan", "");
            }
        } elseif ($user['status'] == 'on') {
            // If status is already on, notify that the account cannot be created
            alert("error", "Email Anda sudah terdaftar di database mahasiswa", "");
        }
    } else {
        // Check if email exists in pengurus table
        $query = $conn->query("SELECT * FROM pengurus WHERE email='$email'");
        if ($query->num_rows > 0) {
            $user = $query->fetch_assoc();
            if ($user['status'] == 'off') {
                // If status is off, update password and change status to on
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $update = $conn->query("UPDATE pengurus SET password='$hashed_password', status='on' WHERE email='$email'");
                if ($update) {
                    alert_timer("Email Anda terdaftar di database pengurus", "login.php");
                } else {
                    alert("error", "Terjadi kesalahan", "");
                }
            } elseif ($user['status'] == 'on') {
                // If status is already on, notify that the account cannot be created
                alert("error", "Email Anda sudah terdaftar di database pengurus", "");
            }
        } else {
            alert("error", "Email Anda belum terdaftar di database, akun tidak dapat dibuat", "");
        }
    }
}


function logoutUser()
{
    session_destroy();
    header("Location: ../auth/login.php");
    exit();
}

// =============================== END OF USERS FUNCTIONS ==================================


// =============================== START OF ADMIN FUNCTIONS ==================================

function loginAdmin()
{
    if ($query->num_rows > 0) {

    }
}













// =============================== END OF ADMIN FUNCTIONS ==================================