<?php
require_once 'config.php'; // koneksi ke database

$total_bayar = 0;
$kembalian = 0;
$tanggal = date("Y-m-d");

// Proses form POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nik = $_POST["nik"];
  $nama = $_POST["nama"];
  $jenis_zakat = $_POST["jenis_zakat"];
  $nominal = $_POST["nominal"];

  if ($jenis_zakat == "uang") {
    $jumlah_uang = $_POST["jumlah_uang"];
    $jumlah_beras = "NULL";
    $jenis_beras = "-";
    $harga_beras = "NULL";
    $total_bayar = $jumlah_uang;
    $jumlah_zakat = $jumlah_uang;
  } else {
    $jenis_beras = $_POST["jenis_beras"];
    $harga_beras = (int)$jenis_beras;
    $jumlah_beras = $_POST["jumlah_beras"];
    $jumlah_uang = "NULL";
    $total_bayar = $jumlah_beras * $harga_beras;
    $jumlah_zakat = $jumlah_beras;
  }

  $kembalian = $nominal - $total_bayar;

  $query = "INSERT INTO pembayaran_zakat (
      nik, nama, jenis_zakat, jenis_beras, harga_beras, jumlah_uang_zakat,
      jumlah_beras, nominal_bayar, kembalian, tanggal_bayar
  ) VALUES (
      '$nik', '$nama', '$jenis_zakat', '$jenis_beras', " . ($harga_beras !== "NULL" ? "'$harga_beras'" : "NULL") . ",
      " . ($jumlah_uang !== "NULL" ? "'$jumlah_uang'" : "NULL") . ",
      " . ($jumlah_beras !== "NULL" ? "'$jumlah_beras'" : "NULL") . ", '$nominal', '$kembalian', '$tanggal'
  )";

  if (mysqli_query($conn, $query)) {
    $sukses = true;
  } else {
    echo "Gagal menyimpan: " . mysqli_error($conn);
  }
}

// Ambil data harga beras
$harga_beras_list = [];
$query = "SELECT * FROM harga_beras ORDER BY harga ASC";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $harga_beras_list[] = $row['harga'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pembayaran Zakat</title>
  <link rel="stylesheet" href="bayar.css">
</head>
<body>
<div class="container">

  <?php if (isset($sukses) && $sukses): ?>
    <div class="hasil">
      <h3>Pembayaran Berhasil!</h3>
    </div>
  <?php endif; ?>

  <form method="POST" action="">
    <h2 class="judul">Form Pembayaran Zakat</h2>

    <label>NIK</label>
    <input type="text" name="nik" required>

    <label>Nama</label>
    <input type="text" name="nama" required>

    <label>Jenis Zakat</label>
    <select name="jenis_zakat" id="jenis_zakat" required>
      <option value="beras">Beras</option>
      <option value="uang">Uang</option>
    </select>

    <div id="jenis_beras_group">
      <label>Jenis Beras (Harga per Kg)</label>
      <select name="jenis_beras" required>
        <?php foreach ($harga_beras_list as $harga): ?>
          <option value="<?= $harga ?>">Rp<?= number_format($harga, 0, ',', '.') ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div id="input-jumlah">
      <label id="label-jumlah">Jumlah Beras (Kg)</label>
      <input type="number" name="jumlah_beras" id="jumlah-input" required min="0" step="0.1">
    </div>

    <label>Nominal Bayar</label>
    <input type="number" name="nominal" required min="0">

    <div class="tombol-group">
      <button type="button" onclick="hitungTotal()">Hitung</button>
      <button type="submit" class="tombol-kanan">Simpan</button>
    </div>

    <button type="button" class="btn-kembali" onclick="history.back()">Kembali</button>
  </form>
</div>

<script>
function hitungTotal() {
  const jenis = document.getElementById("jenis_zakat").value;
  const harga = parseInt(document.querySelector("select[name=jenis_beras]").value);
  const jumlah = parseFloat(document.getElementById("jumlah-input").value);
  const nominal = parseInt(document.querySelector("input[name=nominal]").value);

  if (!isNaN(jumlah) && !isNaN(nominal)) {
    let total = (jenis === "beras") ? harga * jumlah : jumlah;
    let kembalian = nominal - total;
    alert(`Total Bayar: Rp${total.toLocaleString('id-ID')}\nKembalian: Rp${kembalian.toLocaleString('id-ID')}`);
  } else {
    alert("Mohon isi semua data dengan benar.");
  }
}

document.getElementById("jenis_zakat").addEventListener("change", function () {
  const jenis = this.value;
  const labelJumlah = document.getElementById("label-jumlah");
  const jumlahInput = document.getElementById("jumlah-input");
  const jenisBerasGroup = document.getElementById("jenis_beras_group");

  if (jenis === "uang") {
    labelJumlah.textContent = "Jumlah Uang Zakat";
    jumlahInput.name = "jumlah_uang";
    jumlahInput.placeholder = "Masukkan jumlah uang zakat";
    jumlahInput.step = "1000";
    jumlahInput.min = "1000";
    jenisBerasGroup.style.display = "none";
  } else {
    labelJumlah.textContent = "Jumlah Beras (Kg)";
    jumlahInput.name = "jumlah_beras";
    jumlahInput.placeholder = "Contoh: 2.5";
    jumlahInput.step = "0.1";
    jumlahInput.min = "0.1";
    jenisBerasGroup.style.display = "block";
  }
});

// Set awal
document.getElementById("jenis_zakat").dispatchEvent(new Event("change"));
</script>

</body>
</html>
