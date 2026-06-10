<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Outdoor</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Four.Tektokers</h1>
        
        <nav>
            <a href="index.php">Beranda</a>
            <a href="booking.php">Booking Sekarang</a>
            <a href="riwayat.php">Riwayat Booking</a>
        </nav>

        <p class="header-info">
        "Seperti 3726 mdpl, selalu butuh waktu lama untuk mendapatkan sesuatu yang indah"
    </p>
    </header>

    <main>
        <h2>Katalog Peralatan Outdoor</h2>
        <div class="katalog-container">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM peralatan");
            while ($row = mysqli_fetch_assoc($query)) {
            ?>
                <div class="card">
                    <img src="assets/images/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_alat']; ?>" style="width:100%; height: 220px; object-fit:cover; border-radius:5px; margin-bottom:10px;">
                    <h3><?php echo $row['nama_alat']; ?></h3>
                    <p style="font-weight:bold; color:#2c3e50; margin-top:5px;">Rp <?php echo number_format($row['harga_sewa'], 0, ',', '.'); ?> / hari</p>
                </div>
            <?php } ?>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-info">
                <p><strong>Kontak Kami:</strong></p>
                <p>📧 Email: fourtektokers@gmail.com</p>
                <p>📞 No. Telepon: 0857-4958-3301</p>
            </div>
            <div class="footer-social">
                <p><strong>Media Sosial:</strong></p>
                <p>📸 Instagram: <a href="https://instagram.com/four.tektokers" target="_blank">@four.tektokers</a></p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Four.Tektokers. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>