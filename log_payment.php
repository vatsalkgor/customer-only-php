<?php 
session_start();
if(($_SESSION['u_id'])!=1 && $_SESSION['u_id']!=2){
	header('location:index.php');
}else{
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Login Log</title>
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
					<table class="table table-striped table-bordered">
						<thead>
							<th>Log for Payment</th>
						</thead>
						<tbody>
							<?php include "database/Database.php" ;
							$db = new Database();
							$conn = $db->connect();
							$query = "Select user, time,amt,customer from logs where type='payment' ORDER BY time DESC";
							$result = $conn->query($query);
							while($row = $result->fetch_assoc()){
								?>
								<tr>
									<td>User <b><?php echo $row['user'] ?></b> added payment for <span class="guj"><?php echo $row['customer'] ?></span> at time <?php echo $row['time'] ?> of Rupees <b><?php echo $row['amt'] ?></b></td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
				<div class="col-md-4">
					<table class="table table-striped table-bordered">
						<thead>
							<th>Collection Log for today.</th>
							<th></th>
						</thead>
						<tbody>
							<?php
							$sql = "select SUM(amt) as total, user from logs where type=\"payment\" and DATE(time)=CURDATE() group by user";
							$res = $conn->query($sql);
							while($row = $res->fetch_assoc()){
								?>
								<tr>
									<td><?php echo $row['user'] ?></td>
									<td><?php echo $row['total'] ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".loader").css('display','none');
		})
	</script>
	</html>
	<?php 
}
?>