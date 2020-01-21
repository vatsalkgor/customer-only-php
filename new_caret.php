<?php 
session_start();
if(!isset($_SESSION['u_id'])){
	header('location:index.php');
}else{
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Caret Entry</title>
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
			<div class="row">
				<div class="col-md-3">
					<h2>Customer Caret Entry</h2>
					<form>
						<div class="row">
							<div class="col-md-6">
								<label class="control-label">Date</label>
								<div class="form-group">
									<?php 
									include 'database/Database.php';
									$db = new Database();
									$conn = $db->connect();
									?>
									<input type="text" name="c_date" id="c_date" class="form-control guj datepicker">
								</div>
							</div>
							<div class="col-md-6">
								<label class="control-label">Customer Name</label>
								<div class="form-group">
									<select class="form-control select2 guj" name="c_name">
										<option></option>
										<?php 
										$sql = "select * from party order by p_name";
										$res = $conn->query($sql);
										while ($row = $res->fetch_assoc()) {
											?>
											<option value="<?php echo $row['p_id'] ?>"><?php echo $row['p_name'] ?></option>
											<?php
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="control-label">Pending Caret</label>
								<div class="form-group">
									<input type="text" id="c_p_c" readonly class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<label class="control-label">Caret</label>
								<div class="form-group">
									<input type="text" id="c_caret" class="form-control">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<button class="btn btn-primary" id="csubmit">Submit</button>
							</div>
							<div class="col-md-3">
								<button class="btn btn-primary" id="cshow">Show</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-3">
				</div>
				<div class="col-md-6">
					<table class="table table-striped table-bordered">
						<thead>
							<th width="35%">Customer</th>
							<th>Date</th>
							<th>Caret</th>
							<th>Total</th>
						</thead>
						<tbody id="body">
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".loader").hide();
				$('.datepicker').datepicker({
					dateFormat:'dd.mm.yy'
				}).datepicker('setDate',new Date);
				$(".select2").select2();
			})
			$("select[name=c_name]").change(function(){
				$(".loader").show();
				change_pending("select[name=c_name]","c_p_c")
			})
			$("#csubmit").click(function(e){
				e.preventDefault();
				$(".loader").show();
				$.ajax({
					type:"post",
					url:"caret/insert.php",
					data:{date: $("#c_date").val(),id:$("select[name=c_name]").val(),caret:$("#c_caret").val()},
					success:function(data){
						$(".loader").hide()
						if(data == 1){
							alert("success")
							change_pending("select[name=c_name]","c_p_c")
						}else{
							alert("failure")
						}
					}
				})
			})
			
			$("#cshow").click(function(e){
				e.preventDefault();
				$(".loader").show();
				show($("#c_date").val(),0)
			})

			function show(date,cf){
				$.ajax({
					type:"post",
					url:"caret/table.php",
					data:{date:date,cf:cf},
					success:function(data){
						$(".loader").hide();
						$("#body").html(data);
					}
				})
			}

			function change_pending(elem,change_elem){
				$.ajax({
					url:"caret/pending.php",
					type:"post",
					data:{id: $(elem).val()},
					success:function(data){
						$(".loader").hide()
						$("#"+change_elem).val(data);
					}
				})
			}
		</script>
	</body>
	</html>
	<?php 
}
?>