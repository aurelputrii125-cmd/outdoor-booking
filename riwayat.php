<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Booking</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Riwayat Booking Anda</h1>
        <nav>
            <a href="index.php">Beranda</a>
            <a href="booking.php">Booking Sekarang</a>
            <a href="riwayat.php">Riwayat Booking</a>
        </nav>
    </header>

    <main style="padding: 20px; max-width: 800px; margin: 0 auto;">
        <?php
        $query = mysqli_query($conn, "SELECT * FROM bookings ORDER BY id DESC");
        if (mysqli_num_rows($query) == 0) {
            echo "<p style='text-align:center;'>Belum ada riwayat booking.</p>";
        }
        while ($b = mysqli_fetch_assoc($query)) {
            $booking_id = $b['id'];
        ?>
            <div class="riwayat-box" style="background: #fff; padding: 20px; margin-bottom: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); position: relative;">
                <h4>Booking ID: #<?php echo $booking_id; ?> - Atas Nama: <?php echo $b['nama_pelanggan']; ?></h4>
                <p>No. Telp: <?php echo $b['telepon']; ?> | Durasi: <?php echo $b['tanggal_booking']; ?> s/d <?php echo $b['tanggal_kembali']; ?></p>
                <ul>
                    <?php
                    $detail_query = mysqli_query($conn, "SELECT bd.jumlah, p.nama_alat FROM booking_detail bd JOIN peralatan p ON bd.peralatan_id = p.id WHERE bd.booking_id = '$booking_id'");
                    while ($d = mysqli_fetch_assoc($detail_query)) {
                        echo "<li>" . $d['nama_alat'] . " (" . $d['jumlah'] . " pcs)</li>";
                    }
                    ?>
                </ul>
                
                <div style="margin-top: 15px; text-align: right;">
                    <a href="edit_booking.php?id=<?php echo $booking_id; ?>" style="background: #2980b9; color: white; padding: 5px 12px; text-decoration: none; border-radius: 4px; font-size: 14px; margin-right: 5px;">Edit Data</a>
                    <a href="hapus_booking.php?id=<?php echo $booking_id; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')" style="background: #c0392b; color: white; padding: 5px 12px; text-decoration: none; border-radius: 4px; font-size: 14px;">Hapus</a>
                </div>
            </div>
            <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <?php } ?>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-info">
                <p><strong>Kontak Kami:</strong></p>
                <p>📧 Email: fourtektokers@gmail.com</p>
                <p>📞 No. Telepon: 0857-4953-8301</p>
            </div>
            <div class="footer-social">
                <p><strong>Media Sosial:</strong></p>
                <p>📸 Instagram: <a href="https://instagram.com/fourtektokers" target="_blank">@fourtektokers</a></p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Four.Tektokers All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>