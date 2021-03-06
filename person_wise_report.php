<?php 
session_start();
if(!isset($_SESSION['u_id'])){
	header('location:index.php');
}else{
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Farmer Bill Reports</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script src="js/jquery.min.js"></script>
		<script src="js/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/guj_input.css">
		<link rel="stylesheet" href="css/jquery-ui.min.css">
		<script src="js/jquery-ui.min.js"></script>
		<link href="css/select2.min.css" rel="stylesheet" />
		<script src="js/select2.min.js"></script>
	</head>
	<body>
		<?php include "include/navbar.php"; ?>
		<div class="container-fluid">
			<form id="form">
				<div class="row">
					<h2>Person Wise Report</h2>

					<div class="col-md-12 row">
						<div class="form-group col-md-2">
							<label class="control-label">From Date</label>
							<input type="text" name="f_date" id="f_date" class="form-control guj datepicker">
						</div>
						<div class="form-group col-md-2">
							<label class="control-label">To Date</label>
							<input type="text" name="t_date" id="t_date" class="form-control guj datepicker">
						</div>
						<div class="form-group col-md-2">
							<label class="control-label">Customer Name</label>
							<select class="form-control guj select2" name="f_name" id="f_name">
								<option value="0"></option>
								<?php 
								include 'database/Database.php';
								$db = new Database();
								$conn = $db->connect();
								$sql = "select p_id,p_name from party order by p_name";
								$res = $conn->query($sql);
								while($row = $res->fetch_assoc()){
									?>
									<option value="<?php echo $row['p_id'] ?>"><?php echo $row['p_name'] ?></option>
									<?php
								}
								?>
							</select>
						</div>
					</div>
				</div>
			</form>
			<div class="row">
				<div class="col-md-1">
					<button class="btn btn-primary" id="show">Show</button>
				</div>
				
				<div class="col-md-1">
					<button class="btn btn-primary" id="print">Print</button>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-6">
					<p class="guj">AagaLanaa baakI: <span id="previous-pending"></span></p>
					<table class="guj table table-bordered table-striped">
						<thead>
							<th>taarIKa</th>
							<th>Javak</th>
							<th>Aavak</th>
						</thead>
						<tbody id="table">
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".loader").css('display','none');
				$(".select2").select2();
				$('.datepicker').datepicker({
					dateFormat:'dd.mm.yy'
				}).datepicker('setDate',new Date);

				$("#show").click(function(e){
					$(".loader").css('display','block');
					e.preventDefault();
					$("#details").html('');
					var str = $("#form").serialize();
					$.ajax({
						type:"post",
						url:"person-wise/show_table.php",
						data:str,
						success:function(data){
							$(".loader").css('display','none');
							var data = jQuery.parseJSON(data);
							$("#previous-pending").html(data['pending']);
							console.log(data);
							var str="";
							// for (var i=0; i<data['table'].length;i++){

							// 	str += "<tr><td>"+data['table']['date'][i]+"</td>"+
							// 			"<td>"+data['table']['debit'][i]+"</td>"+
							// 			"<td>"+data['table']['credit'][i]+"</td>"+
							// 			"</tr>";
							// }
							for(var d in data['table']){
								console.log(typeof(data['table'][d][0]))
								if(parseInt(data['table'][d][0])>0 || parseInt(data['table'][d][1])>0){
									str += "<tr><td>"+d+"</td>"+
										"<td>"+data['table'][d][0]+"</td>"+
										"<td>"+data['table'][d][1]+"</td>"+
										"</tr>";
								}
							}
							$("#table").html(str);
						}
					})
				})

				$("#print").click(function(e){
					$(".loader").css('display','block');
					e.preventDefault();
					var str = $("#form").serialize();
					$.ajax({
						type:"post",
						url:"person-wise/show_table.php?p=1",
						data:str,
						success:function(data){
							$(".loader").css('display','none');
							// alert(data);
							window.location = "person-wise/bill_template.php";
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