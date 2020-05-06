<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['pelanggan'])) {
	echo "<script>alert('Silahkan Login Terlebih Dahulu');</script>";
	echo "<script>location='login.php';</script>";
}
if (empty($_SESSION['keranjang']) OR !isset($_SESSION['keranjang'])) {
	echo "<script>alert('Produk Kosong, Silahkan Anda Belanja Terlebih Dahulu');</script>";
	echo "<script>location='index.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title> Ziola Thm | Checkout</title>
	<link rel="stylesheet" href="admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'menu.php'; ?>

<!-- <pre><?php //print_r($_SESSION['pelanggan']); ?></pre> -->

<section class="konten">
	<div class="container">
		<h1>Keranjang Belanja</h1><br>
		<table class="table table-bordered text-center">
			<thead>
				<tr>
					<th class="text-center">No</th>
					<th class="text-center">Produk</th>
					<th class="text-center">Harga</th>
					<th class="text-center">Jumlah</th>
					<th class="text-center">Subharga</th>
				</tr>
			</thead>

			<tbody>
				<?php $nomor = 1; ?>
				<?php $total_belanja = 0;?>
				<?php foreach ($_SESSION['keranjang'] as $id_produk => $jumlah): ?>
					<?php
					$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk ='$id_produk'");
					$pecah = $ambil->fetch_assoc();
					$subharga = $pecah['harga_produk'] * $jumlah;
					?>
				<tr>
					<td><?php echo $nomor; ?></td>
					<td><?php echo $pecah['nama_produk']; ?></td>
					<td>Rp. <?php echo number_format($pecah['harga_produk']); ?></td>
					<td><?php echo $jumlah; ?></td>
					<td>Rp. <?php echo number_format ($subharga); ?></td>
				</tr>
				<?php $nomor++; ?>
				<?php $total_belanja += $subharga; ?>
				<?php endforeach ?>
			</tbody>
<!-- Untuk Menampilkan Jumlah Keseluruhan Pembelian-->
			<tfoot>
				<th class="text-center" colspan="4">Total</th>
				<th class="text-center">Rp. <?php echo number_format($total_belanja); ?></th>
			</tfoot>

		</table>
		<form method="POST">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<input type="text" readonly class="form-control text-center" value="<?php echo $_SESSION['pelanggan']['nama_pelanggan']; ?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<input type="text" readonly class="form-control text-center" value="<?php echo $_SESSION['pelanggan']['telepon_pelanggan']; ?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<select name="id_ongkir" class="form-control">
							<option value=""> -- PILIH -- </option>
							<?php
							$ambil = $koneksi->query("SELECT * FROM ongkir");
							while ($perongkir = $ambil->fetch_assoc()) {
							?>
							<option value="<?php echo $perongkir['id_ongkir']; ?>">
								<?php echo $perongkir['nama_kota']; ?> -
							Rp. <?php echo number_format($perongkir['tarif']); ?>
							</option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label> Alamat </label>
				<textarea name="alamat_pengiriman" rows="2" class="form-control" style="resize: none;" placeholder="Masukkan Alamat Pengiriman Secara Lengkap (Termaksud Kode Pos)"></textarea>
			</div>
			<button class="btn btn-success" name="checkout" > Checkout </button>
		</form>
		<?php
			if (isset($_POST['checkout'])) {
				$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];
				$id_ongkir = $_POST['id_ongkir'];
				$tanggal_pembelian = date("Y-m-d");
				$alamat_pengiriman = $_POST['alamat_pengiriman'];

				$ambil = $koneksi->query("SELECT * FROM ongkir WHERE id_ongkir = '$id_ongkir'");
				$array_ongkir = $ambil->fetch_assoc();
				$nama_kota = $array_ongkir['nama_kota'];
				$tarif = $array_ongkir['tarif'];

				$total_pembelian = $total_belanja + $tarif;

//Menyimpan data ke tabel pembelian
				$koneksi->query("INSERT INTO pembelian(id_pelanggan, id_ongkir, tanggal_pembelian, total_pembelian, nama_kota, tarif, alamat_pengiriman) VALUES('$id_pelanggan', '$id_ongkir', '$tanggal_pembelian', '$total_pembelian', '$nama_kota', '$tarif', '$alamat_pengiriman')");

				$id_pembelian_barusan = $koneksi->insert_id;

				foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
					//mendapatkan data produk berdasarkan id produk
					$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk = '$id_produk'");
					$perproduk = $ambil->fetch_assoc();

					$nama = $perproduk['nama_produk'];
					$harga = $perproduk['harga_produk'];
					$berat = $perproduk['berat_produk'];
					$subharga = $perproduk['harga_produk'] * $jumlah;
					$subberat = $perproduk['berat_produk'] * $jumlah;
					$koneksi->query("INSERT INTO pembelian_produk(id_pembelian, id_produk,nama, harga, berat, subharga, subberat, jumlah) VALUES('$id_pembelian_barusan', '$id_produk', '$nama', '$harga', '$berat', '$subharga', '$subberat', '$jumlah')");
				}

				//mengkosonkan Keranjang
				unset($_SESSION['keranjang']);

				echo "<script>alert('Pembelian Sukses');</script>";
				echo "<script>location='nota.php?id=$id_pembelian_barusan';</script>";
			}
		?>

		<!-- <pre><?php //print_r($_SESSION['keranjang']); ?></pre> -->

	</div>
</section><br>
</body>
</html>