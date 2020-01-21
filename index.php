<?php 
session_start();
if(isset($_SESSION['u_id'])){
	header('location:dashboard.php');
}else{
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script src="js/jquery.min.js"></script>
		<script src="js/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3 offset-md-4">
					<br>
					<br>
					<h2>Login</h2>
					<?php 
						if(isset($_SESSION['wrong_id_pass'])){
							echo '<p class="text-danger">'.$_SESSION['wrong_id_pass'].'</p>';
							unset($_SESSION['wrong_id_pass']);
						}
					 ?>
					<form method="post" action="php/login_submit.php">
						<div class="form-group">
							<label for="exampleInputEmail1">Username</label>
							<input type="text" class="form-control" name="username" placeholder="Enter Username">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Password</label>
							<input type="password" name="password" class="form-control" placeholder="Password">
						</div>
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</body>
	</html>
	<?php 
}
?>