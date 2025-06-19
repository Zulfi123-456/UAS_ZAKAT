<?php
require_once 'config.php';

// Ambil data berdasarkan no
if (isset($_GET['no'])) {
    $no = $_GET['no'];
    $query = "SELECT * FROM pembayaran_zakat WHERE no = $no";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
}

// Proses update
if (isset($_POST['update'])) {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $jenis_zakat = $_POST['jenis_zakat'];
    $jenis_beras = $_POST['jenis_beras'];
    $jumlah_beras = $_POST['jumlah_beras'];
    $jumlah_uang_zakat = $_POST['jumlah_uang_zakat'];
    $nominal_bayar = $_POST['nominal_bayar'];
    $metode = $_POST['metode_pembayaran'];
    $kembalian = $_POST['kembalian'];
    $tanggal_bayar = $_POST['tanggal_bayar'];

    $update = "UPDATE pembayaran_zakat SET 
        nik='$nik', 
        nama='$nama', 
        jenis_zakat='$jenis_zakat',
        jenis_beras='$jenis_beras',
        jumlah_beras='$jumlah_beras',
        jumlah_uang_zakat='$jumlah_uang_zakat',
        nominal_bayar='$nominal_bayar',
        metode_pembayaran='$metode',
        kembalian='$kembalian',
        tanggal_bayar='$tanggal_bayar'
        WHERE no=$no";
    
    if (mysqli_query($conn, $update)) {
        header("Location: data.php");
        exit;
    } else {
        echo "Gagal update data!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pembayaran Zakat</title>
    <link rel="stylesheet" href="edit.css">
</head>
<body>
    <div class="container">
        <h2 class="judul">Edit Data Zakat</h2>
        <form method="POST">
            <label>NIK:
                <input type="text" name="nik" value="<?= $data['nik'] ?>" required>
            </label>
            <label>Nama:
                <input type="text" name="nama" value="<?= $data['nama'] ?>" required>
            </label>
            <label>Jenis Zakat:
                <input type="text" name="jenis_zakat" value="<?= $data['jenis_zakat'] ?>" required>
            </label>
            <label>Jenis Beras:
                <input type="text" name="jenis_beras" value="<?= $data['jenis_beras'] ?>">
            </label>
            <label>Jumlah Beras (Kg):
                <input type="number" step="0.01" name="jumlah_beras" value="<?= $data['jumlah_beras'] ?>">
            </label>
            <label>Jumlah Uang Zakat:
                <input type="number" name="jumlah_uang_zakat" value="<?= $data['jumlah_uang_zakat'] ?>">
            </label>
            <label>Nominal Bayar:
                <input type="number" name="nominal_bayar" value="<?= $data['nominal_bayar'] ?>">
            </label>
            <label>Metode Pembayaran:
                <input type="text" name="metode_pembayaran" value="<?= $data['metode_pembayaran'] ?>">
            </label>
            <label>Kembalian:
                <input type="number" name="kembalian" value="<?= $data['kembalian'] ?>">
            </label>
            <label>Tanggal Bayar:
                <input type="date" name="tanggal_bayar" value="<?= $data['tanggal_bayar'] ?>">
            </label>

            <div class="tombol-group">
                <button type="submit" name="update">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>
</html>
