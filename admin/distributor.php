<?php
	$table = 'distributor';
	$halaman = '?menu=distributor';
	$where = "id_distributor = '$_GET[id]'";
	$wheree = "id_distributor LIKE '%$_POST[text_cari]%' OR nama_distributor LIKE '%$_POST[text_cari]%' OR alamat LIKE '%$_POST[text_cari]%' OR telepon LIKE '%$_POST[text_cari]%'";
	$id = "id_distributor";
	$def_param = "D00001";
	$param = "D";
	$kode = $perintah->kode($id, $table, $def_param, $param);
	

	if (isset($_POST['simpan'])) {
		$field = array('id_distributor' => $kode, 'nama_distributor' => $_POST['nama_distributor'], 'alamat' => $_POST['alamat'], 'telepon' => $_POST['telepon']);
		$perintah->simpan($table, $field, $halaman);
	}

	if (isset($_GET['edit'])) {
		@$edit = $perintah->edit($table, $where);
	}

	if (isset($_POST['ubah'])) {
		$field = array('id_distributor' => $edit['id_distributor'], 'nama_distributor' => $_POST['nama_distributor'], 'alamat' => $_POST['alamat'], 'telepon' => $_POST['telepon']);
		$perintah->ubah($table, $field, $where, $halaman);
	}

	if (isset($_GET['hapus'])) {
		$perintah->hapus($table, $where, $halaman);
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Input Distributor</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
	<form method="post">
		<div class="row justify-content-md-center text-uppercase">
		<div class="col-md-4 align-items-center">
			<div class="card" style="margin-top: 40%;">
				<div class="card-header badge-primary">
					<i></i><center style="font-size: 25px">DISTRIBUTOR</center>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>Nama Distributor</label>
						<input type="text" class="form-control" name="nama_distributor" value="<?php echo $edit['nama_distributor'] ?>" required>
					</div>
					<div class="form-group">
						<label>Alamat</label>
						<input type="text" class="form-control" name="alamat" value="<?php echo $edit['alamat'] ?>" required>
					</div>
					<div class="form-group">
						<label>Telepon</label>
						<input type="number" class="form-control" name="telepon" value="<?php echo $edit['telepon'] ?>" required>
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
					<th scope="col" class="text-center">Id Distributor</th>
					<th scope="col" class="text-center">Nama Distributor</th>
					<th scope="col" class="text-center">Alamat</th>
					<th scope="col" class="text-center">Telepon</th>
					<th scope="col" colspan="2" class="text-center">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$no = 0;
					if(isset($_POST['cari'])) {
					$data = $perintah->cari($table, $wheree);	
					}else{
					$data = $perintah->tampil($table, $id);
					}

					if ($data == "") {
						echo "<tr><td align='center' colspan='5'>Tidak ada data</td></tr>";
					} else {
						while ($isi = mysqli_fetch_array($data)) {
							# code...
						}
						foreach ($data as $isi) {
							$no++	
				 ?>
				<tr>
					<td class="text-center"><?php echo $no; ?></td>
					<td class="text-center"><?php echo $isi[0] ?></td>
					<td class="text-center"><?php echo $isi[1] ?></td>
					<td class="text-center"><?php echo $isi[2] ?></td>
					<td class="text-center"><?php echo $isi[3] ?></td>
					<td class="text-center"><a href="?menu=distributor&edit&id=<?php echo $isi['id_distributor'] ?>">Edit</a></td>
					<td class="text-center"><a href="?menu=distributor&hapus&id=<?php echo $isi['id_distributor'] ?>">Hapus</a></td>
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