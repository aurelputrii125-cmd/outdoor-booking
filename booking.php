<?php 
include 'koneksi.php'; 

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];
    $tgl_booking = $_POST['tgl_booking'];
    $tgl_kembali = $_POST['tgl_kembali'];
    
    $alat_dipilih = $_POST['alat']; 
    $jumlah_alat = $_POST['jumlah'];

    $query_booking = "INSERT INTO bookings (nama_pelanggan, telepon, tanggal_booking, tanggal_kembali) VALUES ('$nama', '$telepon', '$tgl_booking', '$tgl_kembali')";
    
    if (mysqli_query($conn, $query_booking)) {
        $booking_id = mysqli_insert_id($conn);

        for ($i = 0; $i < count($alat_dipilih); $i++) {
            $id_alat = $alat_dipilih[$i];
            $qty = $jumlah_alat[$i];
            
            if (!empty($id_alat) && $qty > 0) {
                mysqli_query($conn, "INSERT INTO booking_detail (booking_id, peralatan_id, jumlah) VALUES ('$booking_id', '$id_alat', '$qty')");
            }
        }
        echo "<script>alert('Booking berhasil disimpan!'); window.location='riwayat.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$peralatan_res = mysqli_query($conn, "SELECT * FROM peralatan");
$peralatan_array = [];
while($row = mysqli_fetch_assoc($peralatan_res)) {
    $peralatan_array[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Booking Outdoor</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script>
        function tambahAlat() {
            var container = document.getElementById("alat-container");
            var item = document.createElement("div");
            item.className = "alat-item";
            
            var selectHTML = '<select name="alat[]" required><option value="">-- Pilih Alat --</option>';
            <?php foreach($peralatan_array as $p) { ?>
                selectHTML += '<option value="<?php echo $p['id']; ?>"><?php echo $p['nama_alat']; ?></option>';
            <?php } ?>
            selectHTML += '</select>';
            
            item.innerHTML = selectHTML + ' <input type="number" name="jumlah[]" min="1" placeholder="Jumlah" required> <button type="button" class="btn-hapus" onclick="hapusAlat(this)">Hapus</button>';
            container.appendChild(item);
        }

        function hapusAlat(btn) {
            btn.parentElement.remove();
        }
    </script>
</head>
<body>
    <header>
        <h1>Form Booking</h1>
        <nav>
            <a href="index.php">Beranda</a>
            <a href="booking.php">Booking Sekarang</a>
            <a href="riwayat.php">Riwayat Booking</a>
        </nav>
    </header>

    <main>
        <form action="" method="POST">
            <label>Nama Lengkap:</label>
            <input type="text" name="nama" required>

            <label>Nomor Telepon:</label>
            <input type="text" name="telepon" required>

            <label>Tanggal Booking:</label>
            <input type="date" name="tgl_booking" required>

            <label>Tanggal Pengembalian:</label>
            <input type="date" name="tgl_kembali" required>

            <h3>Peralatan yang Di-booking:</h3>
            <div id="alat-container">
                <div class="alat-item">
                    <select name="alat[]" required>
                        <option value="">-- Pilih Alat --</option>
                        <?php foreach($peralatan_array as $p) { ?>
                            <option value="<?php echo $p['id']; ?>"><?php echo $p['nama_alat']; ?></option>
                        <?php } ?>
                    </select>
                    <input type="number" name="jumlah[]" min="1" placeholder="Jumlah" required>
                </div>
            </div>
            
            <button type="button" onclick="tambahAlat()" style="margin-top: 15px; background-color: #28a745;">+ Tambah Alat Lain</button>
            <hr>
            <button type="submit" name="submit">Konfirmasi Booking</button>
        </form>
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