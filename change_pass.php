<?php 

session_start();

if(!isset($_SESSION['u_id'])){

	header('location:index.php');

}else{

	?>

	<!DOCTYPE html>

	<html>

	<head>

		<title>Change Password</title>

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="css/bootstrap.min.css">

		<script src="js/jquery.min.js"></script>

		<script src="js/popper.min.js"></script>

		<script src="js/bootstrap.min.js"></script>

		<link rel="stylesheet" type="text/css" href="css/guj_input.css">

	</head>

	<body>

		<?php include "include/navbar.php"; ?>

		<div class="container-fluid">

			<div class="row">

				<div class="col-md-4">

					<h1>Change Password</h1>

					<form method="post" id="form">

						<div class="row form-group">

							<div class="col-md-6">

								<label class="control-label">Old Password</label>

								<input type="password" name="old" class="form-control">

							</div>

							<div class="col-md-6">

								<label class="control-label">New Password</label>

								<input type="password" name="new" class="form-control">

							</div>

						</div>

						<div class="row form-group">

							<div class="col-md-6 form-actions">

								<button type="submit" id="change_pass" class="btn btn-primary">Submit</button>

							</div>

						</div>

						</div>

					</form>

				</div>

				<div class="col-md-8">

					<h1>Change Caret Settings</h1>

					<form method="post" id="rsform">

						<div class="row form-group">

							<div class="col-md-6">

								<label class="control-label">Rs for a caret</label>

								<input type="text" name="rs" class="form-control">

							</div>

						</div>

						<div class="row form-group">

							<div class="col-md-6 form-actions">

								<button type="submit" id="change_rs" class="btn btn-primary">Submit</button>

							</div>

						</div>

						</div>

					</form>

				</div>

			</div>

		</div>

		<script type="text/javascript">

			$(document).ready(function(){

				$(".loader").css('display','none');

				$("#change_pass").click(function(e){

					$(".loader").css('display','block');

					e.preventDefault();

					var str = $("#form").serialize();

					$.ajax({

						type:"post",	

						data:str,

						url:"settings/change_rs.php",

						success:function(data){

							$(".loader").css('display','none');

							alert(data)

						}

					})

				})

				$("#change_rs").click(function(e){

					$(".loader").css('display','block');

					e.preventDefault();

					var str = $("#rsform").serialize();

					$.ajax({

						type:"post",	

						data:str,

						url:"settings/change_rs.php",

						success:function(data){

							$(".loader").css('display','none');

							alert(data)

						}

					})

				})

			})

		</script>

	</body>

	</html>

	<?php 

}

?>