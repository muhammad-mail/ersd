<?php
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Ziola Thm | Nota</title>
	<link rel="stylesheet" href="admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'menu.php'; ?>

<section class="konten">
	<div class="container">
		<h2> Nota Pembelian</h2>
<?php
$ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan ON pembelian.id_pelanggan = pelanggan.id_pelanggan WHERE pembelian.id_pembelian = '$_GET[id]'");
$detail = $ambil->fetch_assoc()
?>

<!-- <pre><?php //print_r($detail); ?></pre> -->

<div class="row">
	<div class="col-md-4">
		<h3>Pembelian</h3>
		<strong>No. Pembelian : <?php echo $detail['id_pembelian']; ?></strong><br>
		Tanggal : <?php echo $detail['tanggal_pembelian']; ?><br>
		Total &nbsp;&nbsp;&nbsp;&nbsp; : Rp. <?php echo number_format($detail['total_pembelian']); ?>
	</div>
	<div class="col-md-4">
		<h3>Pelanggan</h3>
		<strong><?php echo $detail['nama_pelanggan']; ?></strong><p>
	Telepon : <?php echo $detail['telepon_pelanggan']; ?><br>
	Email &nbsp;&nbsp;&nbsp; : <?php echo $detail['email_pelanggan']; ?><br>
	</div>
	<div class="col-md-4">
		<h3>Pengiriman</h3>
		<strong>Kec. /Kel. : <?php echo $detail['nama_kota']; ?></strong><p>
	Alamat : <?php echo $detail['alamat_pengiriman']; ?><br>
	Ongkir : <?php echo $detail['tarif']; ?><br>
	</div>
</div>

<table class="table table-bordered text-center">
	<thead>
		<tr>
			<td> No. </td>
			<td> Nama Produk</td>
			<td> Harga Produk </td>
			<td> Berat Produk </td>
			<td> Jumlah </td>
			<td> Subtotal </td>
			<td> Subberat </td>
		</tr>
	</thead>
	<tbody>
		<?php $nomor = 1; ?>
		<?php $ambil = $koneksi->query("SELECT * FROM pembelian_produk WHERE id_pembelian = '$_GET[id]'"); ?>
		<?php while($pecah = $ambil->fetch_assoc()) {?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $pecah['nama']; ?></td>
			<td>Rp. <?php echo number_format($pecah['harga']); ?></td>
			<td><?php echo $pecah['berat']; ?>(gr)</td>
			<td><?php echo $pecah['jumlah']; ?></td>
			<td>Rp. <?php echo number_format($pecah['subharga']); ?></td>
			<td><?php echo number_format($pecah['subberat']); ?>(gr)</td>
		</tr>
		<?php $nomor++; ?>
		<?php } ?>
	</tbody>
</table>
<div class="row">
	<div class="col-md-6 alert alert-success">
		<p>
			Silahkan Lakukan Pembayaran Rp. <?php echo number_format($detail['total_pembelian']); ?> Ke<br><strong>BANK BRI/BNI/Mandiri NOMOR REKENING xxx-xxxxxx-xxxx AN. ZIOLA.THM</strong>
		</p>
	</div>
</div>
	</div>
</section>

</body>
</html>