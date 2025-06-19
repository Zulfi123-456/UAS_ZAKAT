<?php
require_once 'config.php';

if (isset($_GET['no'])) {
    $no = $_GET['no'];
    $query = "DELETE FROM pembayaran_zakat WHERE no = $no";
    
    if (mysqli_query($conn, $query)) {
        header("Location: data.php");
        exit;
    } else {
        echo "Gagal menghapus data!";
    }
} else {
    echo "ID data tidak ditemukan.";
}
?>
