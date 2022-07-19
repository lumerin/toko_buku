<?php
	if (isset($_POST['print'])) {
		echo "<script>document.location.href='print_pemasukan.php'</script>";
	}
	$table = "query_pasok";
	$where = "tanggal BETWEEN '$_POST[mulai]' and '$_POST[sampai]'";
	$id = "tanggal";
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Laporan Pemasukan</title>
 	<link rel="stylesheet" href="../css/bootstrap.min.css">
 </head>
 <body>
 	<br>
 	<form method="post">
 		<div class="row col-md-12 justify-content-center">
 			<div class="form-group col-md-4">
 				<label>Mulai tanggal</label>
 				<input type="date" name="mulai">
 			</div>
 			<div class="form-group col-md-3">
 				<label>Sampai tanggal</label>
 				<input type="date" name="sampai">
 			</div>
 			<div class="form-group col-md-1">
 				<button class="btn btn-primary" name="cari">Cari</button>
 			</div>
 			<div class="form-group col-md-2">
 				<button class="btn btn-primary" name="print">Print</button>
 			</div>
 		</div>
 	</form>
 	<table class="table table-hover" align="center">
 		<thead>
	 		<tr>
	 			<th scope="col" class="text-center">Id Pasok</th>
	 			<th scope="col" class="text-center">Id Distributor</th>
	 			<th scope="col" class="text-center">Nama Distributor</th>
	 			<th scope="col" class="text-center">Id Buku</th>
	 			<th scope="col" class="text-center">Judul Buku</th>
	 			<th scope="col" class="text-center">No ISBN</th>
	 			<th scope="col" class="text-center">Penulis</th>
	 			<th scope="col" class="text-center">Penerbit</th>
	 			<th scope="col" class="text-center">Harga Jual</th>
	 			<th scope="col" class="text-center">Jumlah Buku Masuk</th>
	 			<th scope="col" class="text-center">Tanggal Masuk</th>
	 		</tr>
 		</thead>
 		<tbody>
 		<?php
 			if (isset($_POST['cari'])) {
 				if ($_POST['mulai'] == "" || $_POST['sampai'] == "") {
 					echo "<script>alert('Harap masukan tanggal mulai dan sampai')</script>";
 					$sql = $perintah->tampil($table, $id);
 				} else {
 					$sql = $perintah->cari($table, $where, $id);
 				}

 			} else {
 				$sql = $perintah->tampil($table, $id);
 			}
 			foreach ($sql as $data) {
 		 ?>
	 		<tr>
	 			<td class="text-center"><?php echo $data['id_pasok'] ?></td>
	 			<td class="text-center"><?php echo $data['id_distributor'] ?></td>
	 			<td class="text-center"><?php echo $data['nama_distributor'] ?></td>
	 			<td class="text-center"><?php echo $data['id_buku'] ?></td>
	 			<td class="text-center"><?php echo $data['judul'] ?></td>
	 			<td class="text-center"><?php echo $data['noisbn'] ?></td>
	 			<td class="text-center"><?php echo $data['penulis'] ?></td>
	 			<td class="text-center"><?php echo $data['penerbit'] ?></td>
	 			<td class="text-center"><?php echo $data['harga_jual'] ?></td>
	 			<td class="text-center"><?php echo $data['jumlah'] ?></td>
	 			<td class="text-center"><?php echo $data['tanggal'] ?></td>
	 		</tr>
 		<?php } ?>
 		</tbody>
 	</table>
 </body>
 <script src="js/jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
 </html>
