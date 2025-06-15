<?php
include 'koneksi.php';

$no = $_POST['no_barang'];
$nama = $_POST['nama_barang'];
$tipe = $_POST['tipe'];
$gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];

if ($gambar != "") {
    move_uploaded_file($tmp, "gambar/$gambar");
}

mysqli_query($connect, "INSERT INTO barang (no_barang, nama_barang, tipe, gambar)
    VALUES ('$no', '$nama', '$tipe', '$gambar')");

header("Location: index.php");
?>
