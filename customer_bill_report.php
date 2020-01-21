<?php 
session_start();
if(!isset($_SESSION['u_id'])){
	header('location:index.php');
}else{
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Customer Bill Reports</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
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
					<h2>Customer Bill Report</h2>

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
							<select class="form-control guj select2" name="c_name" id="c_name">
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
						<div class="form-group col-md-2">
							<label class="control-label">Item Name</label>
							<select class="form-control guj select2" name="i_name" id="i_name">
								<option value="0"></option>
								<?php 
								$sql = "select i_id,i_name from items";
								$res = $conn->query($sql);
								while($row = $res->fetch_assoc()){
									?>
									<option value="<?php echo $row['i_id'] ?>"><?php echo $row['i_name'] ?></option>
									<?php
								}
								?>
							</select>
						</div>
						<div class="form-group col-md-1">
							<label class="control-label">&nbsp;</label>
							
						</div>
						<div class="form-group col-md-1">
							<label class="control-label">&nbsp;</label>
							<!-- <button type="submit" class="btn btn-primary form-control" id="print">Print</button> -->
						</div>
					</div>
				</div>
			</form>
			<div class="row">
				<div class="col-md-1">
					<button type="submit" class="btn btn-primary form-control" id="go">GO</button>
				</div>
				<div class="col-md-1">
					<button class="btn btn-primary" id="select-all" data="uncheck">Select All</button>
				</div>
				<div class="col-md-2">
					<button type="submit" class="btn btn-primary form-control" id="print-large-selected">Print</button>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-12">
					<table class="table table-striped table-bordered">
						<thead>
							<th>Checkbox</th>
							<th>Bill No</th>
							<th>Date</th>
							<th>Customer</th>
							<th>Item</th>
							<th>Qty</th>
							<th>Weight</th>
							<th>Rate</th>
							<th>Comm</th>
							<th>Majuri</th>
							<th>Other</th>
							<th>Total</th>
						</thead>
						<tbody id="body"></tbody>
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

				$("#go").click(function(e){
					$(".loader").css('display','block');
					e.preventDefault();
					$("#body").html('');
					var str = $("#form").serialize();
					$.ajax({
						type:"post",
						url:"customer_bill/cb_get_table.php",
						data:str,
						success:function(data){
							$(".loader").css('display','none');
							$("#body").append(data);	
						}
					})
				})

				$('#select-all').click(function(){
					if($(this).attr('data') == 'uncheck'){
						$.each($("input[name='check'"),function(){
							$(this).prop('checked',true);
						})
						$(this).attr('data','checked')
					}else{
						$.each($("input[name='check'"),function(){
							$(this).prop('checked',false);
						})
						$(this).attr('data','uncheck')
					}
				})

				$("#print-large-selected").click(function(e){
					$(".loader").css('display','block');
					e.preventDefault();
					var selected = [];
					$.each($("input[name='check']:checked"), function(){
						selected.push($(this).val());
					})
					var f_date = $("#f_date").val();
					var t_date = $("#t_date").val();
					$.ajax({
						type:"POST",
						url:"customer_bill/print_selected.php",
						data:{a:selected,f_date:f_date,t_date:t_date},
						success:function(data){
							// alert(data);
							// console.log(data)
							$(".loader").css('display','none');
							window.location = "customer_bill/dipa_template.php";
						}
					})
				})
			});
		</script>
	</body>
	</html>
	<?php 
}
?>