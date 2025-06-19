<?php
require_once 'config.php';

// Ambil data dari database
$query = "SELECT * FROM pembayaran_zakat ORDER BY no ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Pembayaran Zakat</title>
  <link rel="stylesheet" href="data.css">
</head>
<body>
  <div class="container">
    <h2>Data Pembayaran Zakat</h2>

    <div class="top-buttons">
      <a href="home.php" class="btn-kembali">Kembali</a>
      <a href="export_excel.php" class="btn-export">Export to Excel</a>
    </div>

    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>NIK</th>
          <th>Nama</th>
          <th>Jenis Zakat</th>
          <th>Jenis Beras</th>
          <th>Jumlah Beras (Kg)</th>
          <th>Jumlah Uang Zakat (Rp)</th>
          <th>Nominal Bayar (Rp)</th>
          <th>Tanggal Bayar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $tanggal_bayar = date('d/m/Y', strtotime($row['tanggal_bayar']));
            echo "<tr>";
            echo "<td data-label='No'>{$no}</td>";
            echo "<td data-label='NIK'>{$row['nik']}</td>";
            echo "<td data-label='Nama'>{$row['nama']}</td>";
            echo "<td data-label='Jenis Zakat'>{$row['jenis_zakat']}</td>";
            echo "<td data-label='Jenis Beras'>" . ($row['jenis_beras'] ?? '-') . "</td>";
            echo "<td data-label='Jumlah Beras (Kg)'>" . ($row['jumlah_beras'] ?? '-') . "</td>";
            echo "<td data-label='Jumlah Uang Zakat (Rp)'>Rp " . number_format($row['jumlah_uang_zakat'], 0, ',', '.') . "</td>";
            echo "<td data-label='Nominal Bayar (Rp)'>Rp " . number_format($row['nominal_bayar'], 0, ',', '.') . "</td>";
            echo "<td data-label='Tanggal Bayar'>{$tanggal_bayar}</td>";
            echo "<td data-label='Aksi'>
                    <div class='aksi-buttons'>
                      <a href='edit.php?no={$row['no']}' class='btn-edit'>Edit</a>
                      <a href='hapus.php?no={$row['no']}' class='btn-hapus' onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Hapus</a>
                    </div>
                  </td>";
            echo "</tr>";
            $no++;
          }
        } else {
          echo "<tr><td colspan='12'>Belum ada data pembayaran zakat.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>
