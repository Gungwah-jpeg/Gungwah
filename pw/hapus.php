<?php
include 'koneksi.php';
$id = $_GET['id'];

// Hapus gambar
$result = mysqli_query($connect, "SELECT gambar FROM barang WHERE id=$id");
$row = mysqli_fetch_assoc($result);
if (!empty($row['gambar'])) {
    $file = "gambar/" . $row['gambar'];
    if (file_exists($file)) unlink($file);
}

mysqli_query($connect, "DELETE FROM barang WHERE id=$id");
header("Location: index.php");
?>
