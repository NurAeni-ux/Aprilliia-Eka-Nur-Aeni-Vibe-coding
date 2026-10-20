<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/auth.php";
check_login();

$user_nama = $_SESSION['nama'];
$user_role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>SIM Kepanitiaan Kampus</title>
  <link rel="stylesheet" href="<?= get_base_url(); ?>assets/css/style.css">
</head>
<body>

<div class="sidebar">
  <div class="brand">SIM KEPANITIAAN</div>
  <ul class="menu">
    <li><a href="<?= get_base_url(); ?>dashboard.php">Dashboard</a></li>
    <li><a href="<?= get_base_url(); ?>modules/acara/index.php">Data Acara</a></li>
    <li><a href="<?= get_base_url(); ?>modules/divisi/index.php">Data Divisi</a></li>
    <li><a href="<?= get_base_url(); ?>modules/anggota/index.php">Data Anggota</a></li>
    <li><a href="<?= get_base_url(); ?>modules/tugas/index.php">Pembagian Tugas</a></li>
    <li><a href="<?= get_base_url(); ?>modules/keuangan/index.php">Keuangan</a></li>
    <li><a href="<?= get_base_url(); ?>modules/laporan/index.php">Laporan LPJ</a></li>
    <li><a href="<?= get_base_url(); ?>logout.php" style="color:#f8d7da;" onclick="return confirm('Apakah Anda yakin ingin keluar?')">Logout</a></li>
  </ul>
</div>

<div class="main-content">
  <div class="topbar">
    <div><strong>Sistem Informasi Kepanitiaan</strong></div>
    <div class="user-profile">
      <?= htmlspecialchars($user_nama); ?> <span class="role-badge"><?= htmlspecialchars($user_role); ?></span>
    </div>
  </div>