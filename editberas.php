<?php
require_once 'config.php';

// Tambah harga baru
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["harga_baru"])) {
    $harga_baru = intval($_POST["harga_baru"]);
    if ($harga_baru > 0) {
        $cek = mysqli_query($conn, "SELECT * FROM harga_beras WHERE harga = '$harga_baru'");
        if (mysqli_num_rows($cek) == 0) {
            mysqli_query($conn, "INSERT INTO harga_beras (harga) VALUES ('$harga_baru')");
            header("Location: editberas.php");
            exit;
        }
    }
}

// Hapus harga
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM harga_beras WHERE id = $id");
    header("Location: editberas.php");
    exit;
}

// Ambil semua data
$result = mysqli_query($conn, "SELECT * FROM harga_beras ORDER BY harga ASC");

// Cek jika kosong, tambahkan default
$cek_data = mysqli_query($conn, "SELECT COUNT(*) as total FROM harga_beras");
$jumlah = mysqli_fetch_assoc($cek_data)['total'];
if ($jumlah == 0) {
    mysqli_query($conn, "INSERT INTO harga_beras (harga) VALUES (10000), (15000), (20000), (25000)");
    header("Location: editberas.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Harga Beras</title>
    <link rel="stylesheet" href="editberas.css">
</head>
<body>
<div class="container">
    <h2>Edit Harga Beras per Liter</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Harga per Liter</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td>
                    <a href="editberas.php?hapus=<?= $row['id'] ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <!-- Form tambah harga baru -->
    <form method="POST" class="form-tambah">
        <h3>Tambah Harga Baru</h3>
        <input type="number" name="harga_baru" placeholder="Contoh: 12000" required>
        <div class="button-row">
            <a href="home.php" class="btn-kembali">Kembali</a>
            <button type="submit" class="btn-simpan">Simpan</button>
        </div>
    </form>
</div>
</body>
</html>
