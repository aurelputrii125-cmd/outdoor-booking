<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa Alat Outdoor - Beranda</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Petualang Outdoor Rent</h1>
        <nav>
            <a href="index.php">Beranda</a>
            <a href="booking.php">Booking Sekarang</a>
            <a href="riwayat.php">Riwayat Booking</a>
        </nav>
    </header>

    <main>
        <h2>Katalog Peralatan Populer</h2>
        <div class="katalog-container">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM peralatan");
            while ($row = mysqli_fetch_assoc($query)) {
            ?>
                <div class="card">
                    <h3><?php echo $row['nama_alat']; ?></h3>
                    <p>Harga: Rp <?php echo number_format($row['harga_sewa'], 0, ',', '.'); ?> / hari</p>
                </div>
            <?php } ?>
        </div>
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