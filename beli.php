<?php
session_start();

//Mendapatkan Id_produk Dari Url
$id_produk = $_GET['id'];

//Jika Produk itu sudah ada di keranjang, maka produk itu di tambah 1
if (isset($_SESSION['keranjang'][$id_produk])) {
	$_SESSION['keranjang'][$id_produk] += 1;
} else {
//selain itu (belumada di keranjang), maka produk itu dianggap dibeli 1
	$_SESSION['keranjang'][$id_produk] = 1;
}

//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";

echo "<script>alert('Produk Telah Masuk Dalam Keranjang');</script>";
echo "<script>location='keranjang.php';</script>"
?>