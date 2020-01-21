<?php 
session_start();
if(!isset($_SESSION['u_id'])){
	header('location:index.php');
}else{
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Dashboard</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/guj_input.css">
		<style type="text/css">
			.card{
				box-shadow: 0 2px 10px rgba(0,0,0,0.2);
			}
		</style>
		<script src="js/jquery.min.js"></script>
		<script src="js/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<?php 
			if($_SESSION['u_type'] == 2){
				?>
		<link rel="stylesheet" href="css/chart.min.css" />
		<script src="js/chart.min.js"></script>
		<?php
			}
		 ?>
	</head>
	<body>
		<?php include "include/navbar.php"; ?>
		<br>
		<?php 
			if($_SESSION['u_type'] == 2){
		 ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6">
					<div class="card">
						<div class="card-header">Last 6 months commission history</div>
						<div class="card-body">
							<canvas id="comm"></canvas>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card">
						<div class="card-header">Last 6 months income history</div>
						<div class="card-body">
							<canvas id="income"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php 
		}
		 ?>
	</body>
	<script type="text/javascript">
		$(document).ready(function(){
		    $("#comm").click(function(e){
		        if(e.which == 112){
		            alert("F1 pressed")
		        }
		    })
		    
			$.ajax({
				type:"POST",
				url:"charts/charts.php",
				success:function(data){
					console.log(data);
					data = jQuery.parseJSON(data);
					var com = data['com'];
					var income = data['income'];
					var commcontext = $("#comm");
					var c_c = {
						label: "Customer Commission",
						data: com['c_c'],
						lineTension: 0.3,
						fill: false,
						borderColor: 'purple',
						backgroundColor: 'transparent',
						pointBorderColor: 'purple',
						pointBackgroundColor: 'grey',
						pointRadius: 5,
						pointHoverRadius: 7,
						pointHitRadius: 15,
						pointBorderWidth: 2
					}
					var com_data = {
						labels:com['labels'],
						datasets:[c_c]
					}
					var commChart = new Chart(commcontext,{
						type:'line',
						data:com_data
					})
					var i_d = {
						label: "Income",
						data: income['amount'],
						lineTension: 0.3,
						fill: false,
						borderColor: 'red',
						backgroundColor: 'transparent',
						pointBorderColor: 'red',
						pointBackgroundColor: 'grey',
						pointRadius: 5,
						pointHoverRadius: 7,
						pointHitRadius: 15,
						pointBorderWidth: 2,
						pointStyle: 'round'
					}
					var income_data = {
						labels:income['labels'],
						datasets:[i_d]
					}
					var incomeChart = new Chart($("#income"),{
						type:'line',
						data:income_data
					})
				}
			})
			$(".loader").css('display','none');
		})
	</script>
	</html>
	<?php 
}
?>