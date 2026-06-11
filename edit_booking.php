<?php 
include 'koneksi.php';

$id = $_GET['id'];

// 1. Ambil data induk booking
$data = mysqli_query($conn, "SELECT * FROM bookings WHERE id = '$id'");
$row = mysqli_fetch_assoc($data);

// 2. Ambil semua daftar peralatan untuk pilihan di dropdown (select)
$peralatan_master = [];
$p_query = mysqli_query($conn, "SELECT * FROM peralatan");
while ($p = mysqli_fetch_assoc($p_query)) {
    $peralatan_master[] = $p;
}

// 3. Ambil detail barang yang saat ini sedang dipesan
$detail_saat_ini = [];
$d_query = mysqli_query($conn, "SELECT * FROM booking_detail WHERE booking_id = '$id'");
while ($d = mysqli_fetch_assoc($d_query)) {
    $detail_saat_ini[] = $d;
}

// 4. Proses simpan perubahan ketika tombol diklik
if (isset($_POST['update'])) {
    $nama = $_POST['nama_pelanggan'];
    $telp = $_POST['telepon'];
    $tgl_b = $_POST['tanggal_booking'];
    $tgl_k = $_POST['tanggal_kembali'];
    
    // Update data induk pelanggan
    mysqli_query($conn, "UPDATE bookings SET nama_pelanggan='$nama', telepon='$telp', tanggal_booking='$tgl_b', tanggal_kembali='$tgl_k' WHERE id='$id'");
    
    // Hapus detail alat lama terlebih dahulu agar tidak menumpuk/bentrok
    mysqli_query($conn, "DELETE FROM booking_detail WHERE booking_id = '$id'");
    
    // Masukkan detail alat baru hasil editan
    $peralatan_ids = $_POST['peralatan_id'];
    $jumlahs = $_POST['jumlah'];
    
    for ($i = 0; $i < count($peralatan_ids); $i++) {
        $p_id = $peralatan_ids[$i];
        $jml = $jumlahs[$i];
        
        if (!empty($p_id) && $jml > 0) {
            mysqli_query($conn, "INSERT INTO booking_detail (booking_id, peralatan_id, jumlah) VALUES ('$id', '$p_id', '$jml')");
        }
    }
    
    echo "<script>alert('Seluruh data booking berhasil diperbarui!'); window.location='riwayat.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Booking Lengkap - Four.Tektokers</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div style="max-width: 600px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); font-family: sans-serif;">
        <h2 style="color: #2d5a27; margin-bottom: 20px; border-bottom: 2px solid #2d5a27; padding-bottom: 10px;">Edit Booking #<?php echo $id; ?></h2>
        
        <form method="POST">
            <label><strong>Nama Pelanggan:</strong></label>
            <input type="text" name="nama_pelanggan" value="<?php echo $row['nama_pelanggan']; ?>" required style="width:100%; padding: 10px; margin: 8px 0 18px 0; border: 1px solid #ccc; border-radius:4px;">
            
            <label><strong>No. Telepon:</strong></label>
            <input type="text" name="telepon" value="<?php echo $row['telepon']; ?>" required style="width:100%; padding: 10px; margin: 8px 0 18px 0; border: 1px solid #ccc; border-radius:4px;">
            
            <div style="display: flex; gap: 15px; margin-bottom: 18px;">
                <div style="flex: 1;">
                    <label><strong>Tanggal Pinjam:</strong></label>
                    <input type="date" name="tanggal_booking" value="<?php echo $row['tanggal_booking']; ?>" required style="width:100%; padding: 10px; margin-top: 8px; border: 1px solid #ccc; border-radius:4px;">
                </div>
                <div style="flex: 1;">
                    <label><strong>Tanggal Kembali:</strong></label>
                    <input type="date" name="tanggal_kembali" value="<?php echo $row['tanggal_kembali']; ?>" required style="width:100%; padding: 10px; margin-top: 8px; border: 1px solid #ccc; border-radius:4px;">
                </div>
            </div>

            <h3 style="color: #8b4513; margin: 25px 0 10px 0; font-size: 18px;">Peralatan yang Disewa:</h3>
            <div id="container-alat">
                <?php 
                // Loop untuk memunculkan alat-alat yang sudah dipilih sebelumnya
                foreach ($detail_saat_ini as $index => $detail) { 
                ?>
                    <div class="baris-alat" style="display: flex; gap: 10px; margin-bottom: 10px; align-items: center;">
                        <select name="peralatan_id[]" required style="flex: 2; padding: 10px; border: 1px solid #ccc; border-radius:4px;">
                            <option value="">-- Pilih Alat --</option>
                            <?php foreach ($peralatan_master as $p) { ?>
                                <option value="<?php echo $p['id']; ?>" <?php echo ($p['id'] == $detail['peralatan_id']) ? 'selected' : ''; ?>>
                                    <?php echo $p['nama_alat']; ?> (Rp <?php echo number_format($p['harga_sewa'], 0, ',', '.'); ?>)
                                </option>
                            <?php } ?>
                        </select>
                        <input type="number" name="jumlah[]" value="<?php echo $detail['jumlah']; ?>" min="1" required placeholder="Jumlah" style="width: 80px; padding: 10px; border: 1px solid #ccc; border-radius:4px;">
                        <button type="button" onclick="hapusBaris(this)" style="background: #e74c3c; color: white; border: none; padding: 10px 12px; border-radius: 4px; cursor: pointer;">X</button>
                    </div>
                <?php } ?>
            </div>

            <button type="button" onclick="tambahBaris()" style="background: #34495e; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; margin-bottom: 25px; font-size: 13px;">+ Tambah Alat Lain</button>
            
            <div style="border-top: 1px solid #eee; padding-top: 20px; text-align: right;">
                <a href="riwayat.php" style="margin-right: 15px; color: #7f8c8d; text-decoration: none; font-weight: bold;">Batal</a>
                <button type="submit" name="update" style="background: #2d5a27; color: white; padding: 12px 25px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 15px;">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <script>
        function tambahBaris() {
            var container = document.getElementById('container-alat');
            var barisBaru = document.createElement('div');
            barisBaru.className = 'baris-alat';
            barisBaru.style.display = 'flex';
            barisBaru.style.gap = '10px';
            barisBaru.style.marginBottom = '10px';
            barisBaru.style.alignItems = 'center';

            // Ambil template dropdown pilihan alat dari baris pertama
            var templateSelect = document.querySelector('.baris-alat select').innerHTML;

            barisBaru.innerHTML = `
                <select name="peralatan_id[]" required style="flex: 2; padding: 10px; border: 1px solid #ccc; border-radius:4px;">
                    ${templateSelect}
                </select>
                <input type="number" name="jumlah[]" min="1" required placeholder="Jumlah" style="width: 80px; padding: 10px; border: 1px solid #ccc; border-radius:4px;">
                <button type="button" onclick="hapusBaris(this)" style="background: #e74c3c; color: white; border: none; padding: 10px 12px; border-radius: 4px; cursor: pointer;">X</button>
            `;
            
            // Reset pilihan pada baris baru agar kosong kembali sewaktu di-tambah
            barisBaru.querySelector('select').value = "";
            container.appendChild(barisBaru);
        }

        function hapusBaris(tombol) {
            var totalBaris = document.querySelectorAll('.baris-alat').length;
            if (totalBaris > 1) {
                tombol.parentElement.remove();
            } else {
                alert("Minimal harus menyewa 1 alat outdoor!");
            }
        }
    </script>
</body>
</html>