<?php 
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title> Ziola Thm | Beranda</title>
	<link rel="stylesheet" href="admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'menu.php'; ?>
<section class="konten">
	<div class="container">
		<h1>Produk Terbaru</h1><br>
		<div class="row">
			<?php $ambil = $koneksi->query("SELECT * FROM produk"); ?>
			<?php while($perproduk=$ambil->fetch_assoc()) {?>
			<div class="col-md-4">
				<div class="thumbnail">
					<img src="foto_produk/<?php echo $perproduk['foto_produk']; ?>" alt="">
					<div class="caption text-center">
						<h3><?php echo $perproduk['nama_produk']; ?></h3>
						<h5>Rp <?php echo number_format($perproduk['harga_produk']); ?></h5>
						<a href="detail.php?id=<?php echo $perproduk['id_produk']; ?>" class="btn btn-primary">Detail Produk</a>
						<a href="beli.php?id=<?php echo $perproduk['id_produk']; ?>" class="btn btn-success">Beli Sekarang</a>
					</div>
				</div>				
			</div>
			<?php } ?>
		</div>
	</div>
	
</section>

</body>
</html>