<?php
	//	pembuat raka aditya
	error_reporting(0);
	@session_start();
	include '../lib/library.php';
	$perintah = new lib();

	if (empty($_SESSION['username'])) {
		echo "<script>alert('Silahkan Login terlebih dahulu !');document.location.href='../index.php'</script>";
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Toko Buku</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
	       			<a class="nav-link" href="?menu=distributor">Distributor</a>
	      		</li>
	      		<li class="nav-item">
	       			<a class="nav-link" href="?menu=pasok">Pasok</a>
	      		</li>
	      		<li class="nav-item">
	       			<a class="nav-link" href="?menu=buku">Buku</a>
	      		</li>
	      		<li class="nav-item" style="margin-left: 270%">
	      			<a class="nav-link" href="?menu=logout">Logout</a>
	      		</li>
	    	</ul>
		</div>
	</nav>

		<div class="konten">
			<?php
				switch ($_GET['menu']) {

					case 'distributor':
						include 'distributor.php';
						break;

					case 'buku':
						include 'buku.php';
						break;

					case 'pasok':
						include 'pasok.php';
						break;

					case 'logout':
						include 'logout.php';
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
