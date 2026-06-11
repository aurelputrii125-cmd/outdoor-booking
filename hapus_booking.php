<?php
include 'koneksi.php';
$id = $_GET['id'];

// Menghapus data induk (detail otomatis terhapus jika pakai ON DELETE CASCADE)
$query = mysqli_query($conn, "DELETE FROM bookings WHERE id = '$id'");

if ($query) {
    echo "<script>alert('Booking berhasil dihapus!'); window.location='riwayat.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus!'); window.location='riwayat.php';</script>";
}
?>