<?php
require_once 'config.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data_zakat.xls");

$query = "SELECT * FROM pembayaran_zakat ORDER BY no ASC";
$result = mysqli_query($conn, $query);
?>

<table border="1">
    <tr>
        <th>No</th>
        <th>NIK</th>
        <th>Nama</th>
        <th>Jenis Zakat</th>
        <th>Jenis Beras</th>
        <th>Jumlah Beras (Kg)</th>
        <th>Jumlah Uang Zakat (Rp)</th>
        <th>Nominal Bayar (Rp)</th>
        <th>Metode</th>
        <th>Kembalian (Rp)</th>
        <th>Tanggal Bayar</th>
    </tr>
    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>$no</td>
            <td>{$row['nik']}</td>
            <td>{$row['nama']}</td>
            <td>{$row['jenis_zakat']}</td>
            <td>{$row['jenis_beras']}</td>
            <td>{$row['jumlah_beras']}</td>
            <td>{$row['jumlah_uang_zakat']}</td>
            <td>{$row['nominal_bayar']}</td>
            <td>{$row['metode_pembayaran']}</td>
            <td>{$row['kembalian']}</td>
            <td>{$row['tanggal_bayar']}</td>
        </tr>";
        $no++;
    }
    ?>
</table>
