<?php 
//	pembuat raka aditya
	error_reporting(0);
	@session_start();
	include '../lib/library.php';
	$perintah = new lib();

	if (empty($_SESSION['username'])) {
		echo "<script>alert('Silahkan Login terlebih dahulu !');document.location.href='../index.php'</script>";
	}

	if (isset($_GET['logout'])) {
		$_SESSION['username'] = "";
		$_SESSION['hak_akses'] = "";
		echo "<script>alert('Berhasil logout');document.location.href='../index.php'</script>";
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Transaksi</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="../materialize/css/materialize.min.css">
    <link rel="stylesheet" href="../ICON/icon-material.css">
    <link rel="stylesheet" href="../Scss/custom.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
	 	<a class="navbar-brand" href="menu.php">Toko Buku</a>
	 	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
	   	<span class="navbar-toggler-icon"></span>
	  	</button>

	  	<div class="collapse navbar-collapse" id="navbarSupportedContent">
	    	<ul class="navbar-nav mr-auto">
	      		<li class="nav-item">
	        		<a class="nav-link" href="menu.php">Home <span class="sr-only">(current)</span></a>
	      		</li>
	     		<li class="nav-item">
	       			<a class="nav-link" href="?menu=laporan_pemasukan">LaporanPemasukan</a>
	      		</li>
	      		<li class="nav-item">
	       			<a class="nav-link" href="?menu=laporan_penjualan">LaporanPenjualan</a>
	      		</li>
	      		<li class="nav-item" style="margin-left: 640%">
	      			<a class="nav-link" href="?&logout">Logout</a>
	      		</li>
	    	</ul>
		</div>
	</nav>

		<div class="konten">
			<?php 
				switch ($_GET['menu']) {
					case 'laporan_penjualan':
						include 'laporan_penjualan.php';
						break;

					case 'laporan_pemasukan':
						include 'laporan_pemasukan.php';
						break;
				}
			 ?>
		</div>
</body>
<script src="../js/jquery-1.11.2.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</html>
<?php 
//	pembuat raka aditya
 ?>