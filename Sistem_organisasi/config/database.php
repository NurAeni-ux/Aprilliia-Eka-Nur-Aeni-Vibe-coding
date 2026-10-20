<?php
$host     = "localhost";
$user     = "root";
$pass     = "shafa";
$database = "db_kepanitiaan";

$conn = mysqli_connect($host, $user, $pass, $database);

if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}
?>