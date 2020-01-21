<?php 
session_start();
if(!isset($_SESSION['u_id'])){
	header('location:index.php');
}else{
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Account Information</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script src="js/jquery.min.js"></script>
		<script src="js/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/guj_input.css">
		<link rel="stylesheet" href="css/jquery-ui.min.css">
		<script src="js/jquery-ui.min.js"></script>
	</head>
	<body>
		<?php include "include/navbar.php"; ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4">
					<div class="row form-group">
						<div class="col-md-6">
							<label class="control-label">From Date</label>
							<input type="text" name="f_date" class="form-control datepicker">
						</div>
						<div class="col-md-6">
							<label class="control-label">To Date</label>
							<input type="text" name="t_date" class="form-control datepicker">
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12">
							<button id="go" class="btn btn-primary">Go</button>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<table class="table table-striped table-bordered">
						<thead>
							<th>Date</th>
							<th>Total Income</th>
							<th>Customer Commission</th>
						</thead>
						<tbody id="body">
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".loader").css('display','none');
				$('.datepicker').datepicker({
					dateFormat:'dd.mm.yy'
				}).datepicker('setDate',new Date);
				$("#go").click(function(e){
					$(".loader").css('display','block');
					e.preventDefault();
					var f_date = $("input[name=f_date]").val();
					var t_date = $("input[name=t_date]").val();
					$.ajax({
						type:"post",
						url:"account/get_info.php",
						data:{f_date:f_date,t_date:t_date},
						success:function(data){
							$("#body").html(data);
							$(".loader").css('display','none');
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