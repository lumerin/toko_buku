<?php
	if (isset($_POST['print'])) {
		echo "<script>document.location.href='print_pemasukan.php'</script>";
	}
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
	 			<th scope="col" class="text-center">Id Penjualan</th>
	 			<th scope="col" class="text-center">Jumlah Buku</th>
	 			<th scope="col" class="text-center">Total pembayaran</th>
	 			<th scope="col" class="text-center">Pembayaran</th>
	 			<th scope="col" class="text-center">Kembalian</th>
	 			<th scope="col" class="text-center">Nama Petugas</th>
	 			<th scope="col" class="text-center">Tanggal</th>
	 		</tr>
 		</thead>
 		<tbody>
 		<?php
 			if (isset($_POST['cari'])) {
 				if ($_POST['mulai'] == "" || $_POST['sampai'] == "") {
 					echo "<script>alert('Harap masukan tanggal mulai dan sampai')</script>";
 					$sql = mysqli_query($this->koneksi,"SELECT * FROM query_penjualan ORDER BY tanggal ASC");
 				} else {
 					$sql = mysqli_query($this->koneksi,"SELECT * FROM query_penjualan WHERE tanggal BETWEEN '$_POST[mulai]' and '$_POST[sampai]' ORDER BY tanggal ASC");
 				}

 			} else {
 				$sql = mysqli_query($this->koneksi,"SELECT * FROM query_penjualan ORDER BY tanggal ASC");
 			}
 			while ($data = mysqli_fetch_array($sql)) {
 		 ?>
	 		<tr>
	 			<td class="text-center"><?php echo $data['id_penjualan'] ?></td>
	 			<td class="text-center"><?php echo $data['jumlah'] ?></td>
	 			<td class="text-center"><?php echo $data['total'] ?></td>
	 			<td class="text-center"><?php echo $data['bayar'] ?></td>
	 			<td class="text-center"><?php echo $data['kembalian'] ?></td>
	 			<td class="text-center"><?php echo $data['tanggal'] ?></td>
	 			<td class="text-center"><?php echo $data['nama'] ?></td>
	 		</tr>
 		<?php } ?>
 		</tbody>
 	</table>
 </body>
 <script src="js/jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
 </html>
