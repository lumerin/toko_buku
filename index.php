<?php
	include 'lib/library.php';

	@$table = 'user';
	@$username = "$_POST[username]";
	@$password = "$_POST[password]";
	@$data_akses = mysqli_fetch_array(mysqli_query("SELECT akses from user WHERE id_user = '$_GET[id]'"));
	@$halaman = array('../Toko_Buku/admin/menu.php','../Toko_Buku/kasir/menu.php','../Toko_Buku/manager/menu.php');

	@$perintah = new lib();

	if (isset($_POST['login'])) {
		$perintah->login($table, $username, $password, $halaman);
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<form method="post">
		<div class="row justify-content-md-center">
			<div class="col-md-3 align-items-center">
				<div class="card" style="margin-top:45%;">
					<div class="card-header badge-primary">
						LOGIN
					</div>
					<div class="card-body">
						<div class="form-group">
							<label>Username</label>
							<input type="text" name="username" class="form-control">
						</div>

						<div class="form-group">
							<label>Password</label>
							<input type="Password" class="form-control" name="password">
						</div>

						<div class="form-group">
							<input type="submit" class="btn btn-primary" name="login" value="Login">
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</body>
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>
