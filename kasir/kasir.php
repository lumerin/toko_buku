<?php
	$table = 'tmp_penjualan';
    $halaman = '?menu=kasir';
    $where = "id_buku = '$_GET[id]'";
    $id = "id_penjualan";
    $def_param = "TK00001";
    $param = "TK";
    $kode = $perintah->kode($id, "penjualan", $def_param, $param);
    $data = "tmp_penjualan.id_penjualan, tmp_penjualan.id_buku, buku.judul, tmp_penjualan.jumlah_beli, tmp_penjualan.total_harga";
    $inner1 = "tmp_penjualan ON buku.id_buku = tmp_penjualan.id_buku";

    @$cariharga = "SELECT *FROM buku WHERE id_buku = '$_POST[id_buku]'";
    @$harganya = mysqli_fetch_array(mysqli_query($this->koneksi,$cariharga));
    @$caribuku =  "SELECT * FROM tmp_penjualan WHERE id_buku = '$_POST[id_buku]'";
    @$final = mysqli_fetch_array(mysqli_query($this->koneksi,$caribuku));

  if (isset($_POST['simpan'])) {
    $field = array('id_penjualan' => $kode, 'id_buku' => $_POST['id_buku'], 'jumlah_beli' => $_POST['jumlah'], 'total_harga' => $_POST['total']);
    if ($harganya['stok'] <= 0) {
        echo "<script>alert('stok buku tidak tersedia !')</script>";
    } elseif ($_POST['jumlah'] < $harganya['stok']) {
        echo "<script>alert('jumlah buku melebihi stok yang ada !')</script>";
    } else {
    $perintah->simpan($table, $field);
    }
  }

    if (isset($_POST['btn_bayar'])) {
        $nyet = array('id_penjualan' => $_POST['id_penjualan'], 'id_user' => $_SESSION['username'], 'jumlah' => $_POST['tojumlah'], 'total' => $_POST['grand'], 'bayar' => $_POST['bayar']);
        if ($_POST['bayar'] == "") {
            echo "<script>alert('harap masukan jumlah uang !')</script>";
        } elseif ($_POST['bayar'] < $_POST['grand']) {
            echo "<script>alert('harap bayar sesuai total pembayaran !')</script>";
        } else {
            $perintah->simpan("penjualan", $nyet, $halaman);
        }
    }

  if (isset($_POST['reset'])) {
    $perintah->hapus($table, "id_penjualan = '$_POST[id_penjualan]'", $halaman);
  }

  if (isset($_GET['hapus'])) {
    $perintah->hapus($table, $where, $halaman);
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Toko Buku</title>
    <script type="text/javascript">
    function kali(){
      var num1 = parseInt(document.getElementById('num1').value);
      var num2 = parseInt(document.getElementById('num2').value);
      document.getElementById('total').value = num1 * num2;
    }

		function mbayar(){
			var num1 = parseInt(document.getElementById('bayar').value);
      var num2 = parseInt(document.getElementById('grand').value);
      document.getElementById('kembali').value = num1-num2;
		}

		function hitung(){
			var jumlah = parseInt(document.getElementById('num1').value);
			var grand = parseInt(document.getElementById('total').value);
			var tmpjum = parseInt(document.getElementById('tmpjumlah').value);
			var tmpgr = parseInt(document.getElementById('tmpgrand').value);
			document.getElementById('finjum').value =jumlah + tmpjum ;
			document.getElementById('fingr').value = grand + tmpgr;
		}
    </script>
  </head>
  <body>
    <form class="" method="post">
      <h3 class="judul">Transaksi</h3>
      <div class="row">
        <div class="col s6 high">
          <div class="card-panel">
            <div class="form-group">
  						<label for="idP">ID Penjualan</label>
  						<input type="text" name="id_penjualan" value="<?php echo $kode; ?>" readonly>
  						<br>
  					</div>
            <div class="form-group">
  						<label for="id_buku">Buku</label>
  						<select class="browser-default" name="id_buku" onchange="submit();">
  							<option value="" selected disabled>Pilih Buku</option>
  							<?php
  							$buku = mysqli_query($this->koneksi,"SELECT * FROM buku WHERE stok > 0 ORDER BY id_buku ASC");
  							while ($baca = mysqli_fetch_array($buku)) {
  							?>
  							<option
  							<?php if (@$_POST['id_buku'] == $baca['id_buku']) {
  								echo "selected";
  							} ?>

  							 value="<?php echo @$baca[0]; ?>"><?php echo $baca[1]; ?></option>
  						<?php } ?>
  						</select>
							<input type="text" name="stok" value="<?php echo $harganya['stok']?>" hidden="">
  						<br>
  					</div>
            <div class="form-group">
  						<label for="harga">Harga</label>
  						<input type="text" name="harga" id="num2" readonly  value="<?php echo $harganya['harga_jual']; ?>">
  						<br>
  					</div>
            <div class="form-group">
  						<label for="jumlah">Jumlah</label>
  						<input type="text" name="jumlah" value="<?php echo @$_POST['jumlah'] ?>" onKeyUp="kali(),hitung();" onKeyPress="return event.charCode >= 48 && event.charCode <= 57" id="num1">
  						<br>
  					</div>
            <div class="form-group">
  					<h5 class="Total">Total :  </h5><input type="text" id="total" readonly name="total" value="" >
  					</div>
						<div class="form-group">
					   		<input type="text" hidden="" id="tmpjumlah" name="tmpjum" value="<?php echo $final['jumlah_beli'] ?>" placeholder="tmpjumlah">
							<input type="text" hidden="" id="tmpgrand" name="tmptotal" value="<?php  echo $final['total_harga'] ?>" placeholder="tmpgrand">
							<input type="text" hidden="" id="finjum" name="finjumlah" value="" placeholder="finaljumlah">
							<input type="text" hidden="" id="fingr" name="fingrand" value="" placeholder="finalgrand">
						</div>
            <div class="form-group">
              <input type="submit" name="simpan" value="Simpan" class="btn waves-effect waves-light high">
            </div>
          </div>
        </div>
        <div class="col s6 high">
          <div class="card-panel">

						<div class="form-group high">
							<label>Grand Total :</label>
							<input type = "text" id="grand" name="grand" readonly value="<?php
							$sql = "SELECT SUM(total_harga) AS grand FROM tmp_penjualan WHERE id_penjualan = '$_POST[id_penjualan]'";
							$query = mysqli_query($this->koneksi,$sql);
							$result = mysqli_fetch_array($query);
							?><?php echo "{$result['grand']}"; ?>">
						</div>
						<div class="form-group">
							<label>Total Item :</label>
							<input type = "text" id="tojumlah" name="tojumlah" readonly value="<?php
							$sql = "SELECT SUM(jumlah_beli) AS jumjum FROM tmp_penjualan WHERE id_penjualan = '$_POST[id_penjualan]'";
							$query = mysqli_query($this->koneksi,$sql);
							$result = mysqli_fetch_array($query);
							?><?php echo "{$result['jumjum']}"; ?>">
						</div>
						<div class="form-group">
							<label for="bayar">Bayar</label>
							<input type="text" name="bayar" onKeyPress="return event.charCode >= 48 && event.charCode <= 57" id="bayar" onkeyup="mbayar();">
						</div>
						<div class="form-group">
							<input type="number" name="kembalian" readonly id="kembali">
							<input type="submit" name="btn_bayar" class="btn waves-effect waves-light" value="Bayar">
							<input type="submit" name="reset" class="btn waves-effect waves-light" value="Reset">
						</div>
            <table class="striped high">
                <thead>
                  <tr>
                    <td class="text-center">ID Penjualan</td>
                    <td class="text-center">ID buku</td>
                    <td class="text-center">Jumlah</td>
                    <td class="text-center">Total Harga</td>
                    <td class="text-center" colspan="2">Option</td>
                  </tr>
                </thead>
                <tbody>
                <?php
                    $no = 0;
                    $data = $perintah->tampilan($table, "id_penjualan = '$kode'");
                    if ($data == "") {
                        echo "<tr><td align='center' colspan='5'>Tidak ada data</td></tr>";
                    } else {
                        foreach ($data as $isi) {
                 ?>
                            <tr>
                                <td class="text-center"><?php echo $isi[0] ?></td>
                                <td class="text-center"><?php echo $isi[1] ?></td>
                                <td class="text-center"><?php echo $isi[2] ?></td>
                                <td class="text-center"><?php echo $isi[3] ?></td>
                                <td class="text-center"><a href="?menu=kasir&hapus&id=<?php echo $isi['id_buku'] ?>">Hapus</a></td>
                            </tr>
                <?php
                        }
                    }
                 ?>
            </tbody>
			</div>
          </div>
        </div>
    </form>
  </body>
</html>
