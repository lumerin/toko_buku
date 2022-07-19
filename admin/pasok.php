<?php
//	pembuat raka aditya
	$table = 'pasok';
	$halaman = '?menu=pasok';
	$where = "id_pasok = '$_GET[id]'";
	$wheree = "id_pasok LIKE '%$_POST[text_cari]%' OR id_distributor LIKE '%$_POST[text_cari]%' OR nama_distributor LIKE '%$_POST[text_cari]%' OR id_buku LIKE '%$_POST[text_cari]%' OR judul LIKE '%$_POST[text_cari]%' OR tanggal LIKE '%$_POST[text_cari]%'";
	$id = "id_pasok";
	$def_param = "P00001";
	$param = "P";
	$kode = $perintah->kode($id, $table, $def_param, $param);	
	$data = "pasok.id_pasok, pasok.id_distributor, distributor.nama_distributor, pasok.id_buku, buku.judul, pasok.jumlah, pasok.tanggal";
	$inner1 = "distributor ON pasok.id_distributor = distributor.id_distributor";
	$inner2 = "buku ON pasok.id_buku = buku.id_buku";

	if (isset($_POST['simpan'])) {
		$field = array('id_pasok' => $kode, 'id_distributor' => $_POST['id_distributor'], 'id_buku' => $_POST['id_buku'], 'jumlah' => $_POST['jumlah'], 'tanggal' => date('Y-m-d'));
		$perintah->simpan($table, $field, $halaman);
	}

	if (isset($_GET['edit'])) {
		@$edit = $perintah->edit($table, $where);
	}

	if (isset($_POST['ubah'])) {
		$field = array('id_pasok' => $edit['id_pasok'], 'id_distributor' => $_POST['id_distributor'], 'id_buku' => $_POST['id_buku'], 'jumlah' => $_POST['jumlah'], 'tanggal' => date('Y-m-d'));
		$perintah->ubah($table, $field, $where, $halaman);
	}

	if (isset($_GET['hapus'])) {
		$perintah->hapus($table, $where, $halaman);
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Input Pasok</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
	<form method="post">
		<div class="row justify-content-md-center text-uppercase">
		<div class="col-md-4 align-items-center">
			<div class="card" style="margin-top: 40%;">
				<div class="card-header badge-primary">
					<i></i><center style="font-size: 25px">PASOK</center>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>Distributor</label>
						<select name="id_distributor" class="form-control">
							<?php 
								 $dit = $perintah->edit("distributor", "id_distributor = '$edit[id_distributor]'");
							 ?>
							<option value="<?php echo $edit['id_distributor'] ?>"><?php echo $dit['nama_distributor'] ?></option>
								<?php 
									$dist = $perintah->tampil("distributor", "id_distributor");
									foreach ($dist as $dat){
								?>
								<option value="<?php echo $dat['id_distributor'] ?>"><?php echo $dat['nama_distributor'] ?></option>
								<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label>Buku</label>
						<select name="id_buku" class="form-control">
							<?php 
								 $dit2 = $perintah->edit("buku", "id_buku = '$edit[id_buku]'");
							 ?>
							<option value="<?php echo $edit['id_buku'] ?>"><?php echo $dit2['judul'] ?></option>
								<?php 
									$dist2 = $perintah->tampil("buku", "id_buku");
									foreach ($dist2 as $dat2){
								?>
								<option value="<?php echo $dat2['id_buku'] ?>"><?php echo $dat2['judul'] ?></option>
								<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label>Jumlah</label>
						<input type="number" class="form-control" name="jumlah" value="<?php echo $edit['jumlah'] ?>">
					</div>
					<div class="form-group">
						<?php 
							if ($_GET['id'] == "") {
						 ?>
						<button class="btn btn-outline-primary" name="simpan">Simpan</button>
						<?php 
							} else {
						 ?>
						 <button class="btn btn-outline-primary" name="ubah">Ubah</button>
						 <?php } ?>
					</div>
				</div>
			</div>
		</div>
		</div>
	</form>
	<br />

	<form method="post">
	<div class="form-inline col-md-12 justify-content-center">
		<input class="form-control col-md-4 mr-sm-2" type="search" placeholder="Search" name="text_cari" aria-label="Search">
     	<button class="btn btn-outline-success my-2 my-sm-0" name="cari" type="submit">Search</button>
	</div>
	</form>
	<br />

	<div class="row col-md-12" align="center">
		<table  class="table table-hover">
			<thead>
				<tr>
					<th scope="col" class="text-center">#</th>
					<th scope="col" class="text-center">Id Pasok</th>
					<th scope="col" class="text-center">Id Distributor</th>
					<th scope="col" class="text-center">Nama Distributor</th>
					<th scope="col" class="text-center">Id Buku</th>
					<th scope="col" class="text-center">Judul Buku</th>
					<th scope="col" class="text-center">Jumlah</th>
					<th scope="col" class="text-center">Tanggal</th>
					<th scope="col" colspan="2" class="text-center">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$no = 0;
					if(isset($_POST['cari'])) {
					$data = $perintah->cari("query_pasok", $wheree);	
					}else{
					$data = $perintah->tampil("query_pasok", $id);
					}

					if ($data == "") {
						echo "<tr><td align='center' colspan='5'>Tidak ada data</td></tr>";
					} else {
						foreach ($data as $isi) {
							$no++	
				 ?>
				<tr>
					<td class="text-center"><?php echo $no; ?></td>
					<td class="text-center"><?php echo $isi['id_pasok'] ?></td>
					<td class="text-center"><?php echo $isi['id_distributor'] ?></td>
					<td class="text-center"><?php echo $isi['nama_distributor'] ?></td>
					<td class="text-center"><?php echo $isi['id_buku'] ?></td>
					<td class="text-center"><?php echo $isi['judul'] ?></td>
					<td class="text-center"><?php echo $isi['jumlah'] ?></td>
					<td class="text-center"><?php echo $isi['tanggal'] ?></td>
					<td class="text-center"><a href="?menu=pasok&edit&id=<?php echo $isi['id_pasok'] ?>">Edit</a></td>
					<td class="text-center"><a href="?menu=pasok&hapus&id=<?php echo $isi['id_pasok'] ?>">Hapus</a></td>
				</tr>
				<?php 
					}
				}
				 ?>
			</tbody>
		</table>
	</div>
</body>
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>
<?php 
	//	pembuat raka aditya
 ?>