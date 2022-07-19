<?php
	class lib{
		function __construct() {
			$this->koneksi = mysqli_connect('localhost', 'root', '','db_toko_buku');
		}

		function simpan($table, array $field, $halaman) {
			$sql = "INSERT INTO $table SET";
			foreach ($field as $key => $value) {
				$sql.=" $key = '$value',";
			}
			$sql = rtrim($sql, ',');
			$jalan = mysqli_query($this->koneksi,$sql);
			if ($jalan) {
				echo "<script>alert('Berhasil !');document.location.href='$halaman'</script>";
			}else{
				echo mysqli_error();
			}
		}

		function tampil($table, $id) {
			$sql = "SELECT * FROM $table ORDER BY $id ASC";
			$tampil = mysqli_query($this->koneksi,$sql);
			while ($data = mysqli_fetch_array($tampil))
				$isi[] = $data;
			return $isi;
		}

		function tampilkan($table, $data, $inner1, $inner2, $id) {
			$sql = "SELECT $data FROM $table INNER JOIN $inner1 INNER JOIN $inner2 ORDER BY $id ASC";
			$tampil = mysqli_query($this->koneksi,$sql);
			while ($data = mysqli_fetch_array($tampil))
				$isi[] = $data;
			return $isi;
		}

		function cari($table, $where, $id) {
			$sql = "SELECT * FROM $table WHERE $where ORDER BY $id ASC";
			$tampil = mysqli_query($this->koneksi,$sql);
			while ($data = mysqli_fetch_array($tampil))
				$isi[] = $data;
			return $isi;
		}


		function hapus($table, $where, $halaman){
			$sql = "DELETE FROM $table WHERE $where";
			$jalan = mysqli_query($this->koneksi,$sql);
			if ($jalan) {
				echo "<script>alert('Berhasil');document.location.href='$halaman'</script>";
			}else{
				echo mysqli_error();
			}
		}

		function edit($table, $where){
			$sql = "SELECT * FROM $table WHERE $where";
			$jalan = mysqli_fetch_array(mysqli_query($this->koneksi,$sql));
			return $jalan;
		}


		function ubah($table, array $field, $where, $halaman){
			$sql = "UPDATE $table SET";
			foreach ($field as $key => $value) {
				$sql.=" $key = '$value',";

			}
			$sql = rtrim($sql, ',');
			$sql.="WHERE $where";
			$jalan = mysqli_query($this->koneksi,$sql);
			if ($jalan) {
				echo "<script>alert('Berhasil');document.location.href='$halaman'</script>";

			}else{
				echo mysqli_error();
			}
		}

		function upload($foto, $tempat){
			$alamat = $foto['tmp_name'];
			$namafile = $foto['name'];
			move_uploaded_file($alamat, "$tempat/$namafile");
			return $namafile;
		}

		function kode($id, $table, $def_param, $param) {
			$sql = "SELECT $id FROM $table ORDER BY $id DESC LIMIT 0,1";
			$query = mysqli_query($this->koneksi,$sql);
			list ($no_temp) = mysqli_fetch_row($query);

			if ($no_temp == '') {
				$no_urut = $def_param;
				} else {
				$jum = substr($no_temp,2,6);
				$jum++;
				if($jum <= 9) {
					$no_urut = $param.'0000'.$jum;
				} elseif ($jum <= 99) {
					$no_urut = $param.'000'.$jum;
				} elseif ($jum <= 999) {
					$no_urut = $param.'00'.$jum;
				} elseif ($jum <= 9999) {
					$no_urut = $param.'0'.$jum;
				} elseif ($jum <= 99999) {
					$no_urut = $param.$jum;
				} else {
					die("Nomor urut melebih batas");
				}
			}
				return $no_urut;
		}

		function login($table, $username, $password,array $halaman){
			@session_start();
			$sql = "SELECT username, password, akses, status FROM user WHERE username = '$username' AND password = '$password' AND (status = 'aktif' OR status = 'Aktif' OR status = 'AKTIF')";
			$data_akses = mysqli_fetch_array(mysqli_query($this->koneksi,"SELECT akses FROM user WHERE username = '$username'"));
			$perintah = mysqli_query($this->koneksi,$sql);
			$data = mysqli_fetch_array($perintah);
			$jalan = mysqli_num_rows($perintah);
			if ($jalan > 0) {
				if ($data_akses['akses'] == 'Admin') {
					$_SESSION['username'] = $username;
					$_SESSION['akses'] = $data_akses['akses'];
					echo "<script>alert('Selamat Datang Admin');document.location.href='$halaman[0]';</script>";
				} elseif($data_akses['akses'] == 'Kasir') {
					$_SESSION['username'] = $username;
					$_SESSION['akses'] = $data_akses['akses'];
					echo "<script>alert('Selamat Datang Kasir');document.location.href='$halaman[1]';</script>";
				} else {
					$_SESSION['username'] = $username;
					$_SESSION['akses'] = $data_akses['akses'];
				echo "<script>alert('Selamat Datang Manager');document.location.href='$halaman[2]';</script>";
				}
			} else {
				echo "<script>alert('Gagal Login');</script>";
			}
		}
	}
 ?>
