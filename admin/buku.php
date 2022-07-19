<?php
	$table = 'buku';
	$halaman = '?menu=buku';
	$where = "id_buku = '$_GET[id]'";
	$wheree = "id_buku LIKE '%$_POST[text_cari]%' OR judul LIKE '%$_POST[text_cari]%' OR noisbn LIKE '%$_POST[text_cari]%' OR penulis LIKE '%$_POST[text_cari]%' OR penerbit LIKE '%$_POST[text_cari]%' OR tahun LIKE '%$_POST[text_cari]%'";
	$diskon = $_POST['diskon']."%";
	$tempat = "../foto";
	$foto = $_FILES['foto'];
	$id = "id_buku";
	$def_param = "B00001";
	$param = "B";
	$kode = $perintah->kode($id, $table, $def_param, $param);
	$stok = $perintah->edit($table, $where);



	if (isset($_POST['simpan'])) {
		$upload = $perintah->upload($foto, $tempat);
		$field = array('id_buku' => $kode, 'judul' => $_POST['judul'], 'noisbn' => $_POST['noisbn'], 'penulis' => $_POST['penulis'], 'penerbit' => $_POST['penerbit'], 'tahun' => $_POST['tahun'], 'stok' => $stok['stok'], 'harga_pokok' => $_POST['harga_pokok'], 'harga_jual' => $_POST['harga_jual'], 'ppn' => "10%", 'diskon' => $diskon, 'foto' => $upload);
		$perintah->simpan($table, $field, $redirect);
	}

	if (isset($_GET['edit'])) {
		@$edit = $perintah->edit($table, $where);
	}

	if (isset($_POST['ubah'])) {
		$upload = $perintah->upload($foto, $tempat);
		$field = array('id_buku' => $edit['id_buku'], 'judul' => $_POST['judul'], 'noisbn' => $_POST['noisbn'], 'penulis' => $_POST['penulis'], 'penerbit' => $_POST['penerbit'], 'tahun' => $_POST['tahun'], 'stok' => $stok['stok'], 'harga_pokok' => $_POST['harga_pokok'], 'harga_jual' => $_POST['harga_jual'], 'ppn' => "10%", 'diskon' => $diskon, 'foto' => $upload);
		$perintah->ubah($table, $field, $where, $halaman);
	}

	if (isset($_GET['hapus'])) {
		$perintah->hapus($table, $where, $halaman);
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Input Buku</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
	<form method="post" enctype="multipart/form-data">
		<div class="row justify-content-md-center text-uppercase">
		<div class="col-md-4 align-items-center">
			<div class="card" style="margin-top: 40%;">
				<div class="card-header badge-primary">
					<i></i><center style="font-size: 25px">Buku</center>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>judul Buku</label>
						<input type="text" class="form-control" name="judul" value="<?php echo $edit['judul'] ?>" required>
					</div>
					<div class="form-group">
						<label>No ISBN</label>
						<input type="number" class="form-control" name="noisbn" value="<?php echo $edit['noisbn'] ?>" required>
					</div>
					<div class="form-group">
						<label>Penulis</label>
						<input type="text" class="form-control" name="penulis" value="<?php echo $edit['penulis'] ?>" required>
					</div>
					<div class="form-group">
						<label>Penerbit</label>
						<input type="text" class="form-control" name="penerbit" value="<?php echo $edit['penerbit'] ?>" required>
					</div>
					<div class="form-group">
						<label>Tahun</label>
						<input type="number" class="form-control" name="tahun" value="<?php echo $edit['tahun'] ?>" required>
					</div>
					<div class="form-group">
						<label>Harga Pokok</label>
						<input type="number" class="form-control" name="harga_pokok" value="<?php echo $edit['harga_pokok'] ?>" required>
					</div>
					<div class="form-group">
						<label>Harga Jual</label>
						<input type="number" class="form-control" name="harga_jual" value="<?php echo $edit['harga_jual'] ?>" required>
					</div>
					<div class="form-group">
						<label>Diskon</label>
						<?php $dis = rtrim($edit['diskon'], '%'); ?>
						<input type="number" class="form-control" name="diskon" value="<?php  echo $dis; ?>" required>
					</div>
					<div>
						<label>Foto</label>
						<br>
						<input type="file" name="foto">
					</div>
					<br>
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
					<th scope="col" class="text-center">Id Buku</th>
					<th scope="col" class="text-center">Judul Distributor</th>
					<th scope="col" class="text-center">No ISBN</th>
					<th scope="col" class="text-center">Penulis</th>
					<th scope="col" class="text-center">Penerbit</th>
					<th scope="col" class="text-center">Tahun</th>
					<th scope="col" class="text-center">Stok</th>
					<th scope="col" class="text-center">Harga Pokok</th>
					<th scope="col" class="text-center">Harga Jual</th>
					<th scope="col" class="text-center">PPN</th>
					<th scope="col" class="text-center">Diskon</th>
					<th scope="col" class="text-center">Foto</th>
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
						foreach ($data as $isi) {
							$no++
				 ?>
				<tr>
					<td class="text-center"><?php echo $no; ?></td>
					<td class="text-center"><?php echo $isi[0] ?></td>
					<td class="text-center"><?php echo $isi[1] ?></td>
					<td class="text-center"><?php echo $isi[2] ?></td>
					<td class="text-center"><?php echo $isi[3] ?></td>
					<td class="text-center"><?php echo $isi[4] ?></td>
					<td class="text-center"><?php echo $isi[5] ?></td>
					<td class="text-center"><?php echo $isi[6] ?></td>
					<td class="text-center"><?php echo $isi[7] ?></td>
					<td class="text-center"><?php echo $isi[8] ?></td>
					<td class="text-center"><?php echo $isi[9] ?></td>
					<td class="text-center"><?php echo $isi[10] ?></td>
					<td><img src="../foto/<?php echo $isi[11] ?>" width="50" height="50" /></td>
					<td class="text-center"><a href="?menu=buku&edit&id=<?php echo $isi['id_buku'] ?>">Edit</a></td>
					<td class="text-center"><a href="?menu=buku&hapus&id=<?php echo $isi['id_buku'] ?>">Hapus</a></td>
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
