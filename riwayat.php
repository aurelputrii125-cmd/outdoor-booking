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

    <main>
        <?php
        $query = mysqli_query($conn, "SELECT * FROM bookings ORDER BY id DESC");
        if (mysqli_num_rows($query) == 0) {
            echo "<p style='text-align:center;'>Belum ada riwayat booking.</p>";
        }
        while ($b = mysqli_fetch_assoc($query)) {
            $booking_id = $b['id'];
        ?>
            <div class="riwayat-box">
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
            </div>
            <hr>
        <?php } ?>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-info">
                <p><strong>Kontak Kami:</strong></p>
                <p>📧 Email: admin@petualangoutdoor.com</p>
                <p>📞 No. Telepon: 0812-3456-7890</p>
            </div>
            <div class="footer-social">
                <p><strong>Media Sosial:</strong></p>
                <p>📸 Instagram: <a href="https://instagram.com/username_kamu" target="_blank">@username_kamu</a></p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Petualang Outdoor RENT. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>