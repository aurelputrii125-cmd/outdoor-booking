<?php 
include 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM bookings WHERE id = '$id'");
$row = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $nama = $_POST['nama_pelanggan'];
    $telp = $_POST['telepon'];
    $tgl_b = $_POST['tanggal_booking'];
    $tgl_k = $_POST['tanggal_kembali'];
    
    $update = mysqli_query($conn, "UPDATE bookings SET nama_pelanggan='$nama', telepon='$telp', tanggal_booking='$tgl_b', tanggal_kembali='$tgl_k' WHERE id='$id'");
    if ($update) {
        echo "<script>alert('Data booking berhasil diperbarui!'); window.location='riwayat.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Booking</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div style="max-width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <h2 style="color: #2d5a27; margin-bottom: 20px;">Edit Data Booking #<?php echo $id; ?></h2>
        <form method="POST">
            <label>Nama Pelanggan:</label><br>
            <input type="text" name="nama_pelanggan" value="<?php echo $row['nama_pelanggan']; ?>" required style="width:100%; padding: 8px; margin: 10px 0;"><br>
            
            <label>No. Telepon:</label><br>
            <input type="text" name="telepon" value="<?php echo $row['telepon']; ?>" required style="width:100%; padding: 8px; margin: 10px 0;"><br>
            
            <label>Tanggal Pinjam:</label><br>
            <input type="date" name="tanggal_booking" value="<?php echo $row['tanggal_booking']; ?>" required style="width:100%; padding: 8px; margin: 10px 0;"><br>
            
            <label>Tanggal Kembali:</label><br>
            <input type="date" name="tanggal_kembali" value="<?php echo $row['tanggal_kembali']; ?>" required style="width:100%; padding: 8px; margin: 10px 0;"><br>
            
            <button type="submit" name="update" style="background: #2d5a27; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; margin-top: 10px;">Simpan Perubahan</button>
            <a href="riwayat.php" style="margin-left: 10px; color: #7f8c8d; text-decoration: none;">Batal</a>
        </form>
    </div>
</body>
</html>