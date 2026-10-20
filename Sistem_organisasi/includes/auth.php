<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function check_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: " . get_base_url() . "login.php");
        exit();
    }
}

function check_role($allowed_roles = []) {
    check_login();
    if (!in_array($_SESSION['role'], $allowed_roles)) {
        echo "<script>alert('Anda tidak memiliki hak akses untuk halaman ini.'); window.location.href='" . get_base_url() . "dashboard.php';</script>";
        exit();
    }
}

function get_base_url() {
    return "http://localhost/sistem_organisasi/";
}
?>