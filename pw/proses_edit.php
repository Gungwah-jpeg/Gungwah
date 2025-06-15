<?php
include 'koneksi.php';

$id = $_POST['id'];
$no = $_POST['no_barang'];
$nama = $_POST['nama_barang'];
$tipe = $_POST['tipe'];
$gambarBaru = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];

if ($gambarBaru != "") {
    move_uploaded_file($tmp, "gambar/$gambarBaru");
    mysqli_query($connect, "UPDATE barang SET no_barang='$no', nama_barang='$nama', tipe='$tipe', gambar='$gambarBaru' WHERE id=$id");
} else {
    mysqli_query($connect, "UPDATE barang SET no_barang='$no', nama_barang='$nama', tipe='$tipe' WHERE id=$id");
}

header("Location: index.php");
?>
