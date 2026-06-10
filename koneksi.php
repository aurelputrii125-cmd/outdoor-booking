<?php

$host = "sql208.infinityfree.com";
$user = "if0_42149711";
$pass = "Matchaw01";
$db   = "if0_42149711_outdoor_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

///echo "Koneksi database berhasil!";

?>