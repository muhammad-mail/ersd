<nav class="navbar navbar-default">
		<div class="container">
			<ul class="nav navbar-nav">
				<li><a href="index.php"> HOME </a></li>
				<li><a href="keranjang.php"> Keranjang </a></li>
				<?php if (isset($_SESSION['pelanggan'])): ?>
					<li><a href="logout.php" onclick="return confirm('Apakah Anda Yakin Ingin Logout ?')"> Logout </a></li>
				<?php else : ?>
				<li><a href="login.php"> Login </a></li>
				<?php endif ?>
				<li><a href="checkout.php"> Checkout </a></li>
			</ul>
		</div>
</nav>