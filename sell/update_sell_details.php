<?php 
session_start();
if(!isset($_SESSION['u_id'])){
	header('location:index.php');
}else{
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Update Sell</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/guj_input.css">
		<link rel="stylesheet" href="../css/jquery-ui.min.css">
		<script src="../js/jquery-ui.min.js"></script>
	</head>
	<body>
		
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4">
					<h2>Update Sell</h2>
					<div id="res">
					</div>
					<form method="post" id="sellForm">
						<div class="row">
							<div class="col-md-6">
								<label class="control-label">Bill No.</label>
								<div class="form-group">
									<?php 
									include '../database/Database.php';
									$db = new Database();
									$conn = $db->connect();
									$sql = "select s_id,s_b_no,s_f_id,purchase.pu_i_pending,s_i_id,purchase.pu_b_date,party.p_name,items.i_name, items.i_id,(select distinct g_customer_wage from groups where g_id in (select i_group_id from items join sell_bill on s_i_id=items.i_id and s_id=".$_SESSION['s_id'].")) as wage,(select distinct g_customer_com from groups where g_id in (select i_group_id from items join sell_bill on s_i_id=items.i_id and s_id=".$_SESSION['s_id'].")) as com,s_qty, s_weight, s_rate, s_o_rate, s_com,s_wage,s_o_e,s_total from sell_bill join party, items, purchase where party.p_id = s_c_id and items.i_id = s_i_id and purchase.pu_id=pu_b_id and s_id=".$_SESSION['s_id'];

									$row = $conn->query($sql)->fetch_array();
									?>
									<input type="text" readonly value="<?php echo $row['s_b_no'] ?>" name="s_b_no" id="s_b_no" class="form-control guj">
								</div>
							</div>
							<div class="col-md-6">
								<label class="control-label">Buy Date</label>
								<input type="text" name="s_p_date" readonly value="<?php echo str_replace('-', '.', $row['pu_b_date']) ?>" id="s_p_date" class="form-control guj datepicker">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<?php 
								$sql1 = "select p_name from party where p_id=".$row['s_f_id'];
								$f = $conn->query($sql1)->fetch_array();
								?>
								<label class="control-label">Farmer Name</label>
								<div class="form-group">
									<input type="text" class="form-control guj" readonly name="s_f_name" value="<?php echo $f['p_name'] ?>">
								</div>
							</div>

							<div class="col-md-6">
								<label class="control-label">Customer Name</label>
								<input type="text" class="form-control guj" readonly name="s_f_name" value="<?php echo $row['p_name'] ?>">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="control-label">Item Name</label>
								<?php 
								$sql1 = "select i_name from items where i_id=".$row['s_i_id'];
								$i = $conn->query($sql1)->fetch_array();
								?>
								<div class="form-group">
									<input type="text" name="s_i_name" class="form-control guj" readonly value="<?php echo $i['i_name'] ?>">
								</div>
							</div>
							<div class="col-md-3">
								<label class="control-label">Qty</label>
								<input type="text" required name="s_qty" value="<?php echo $row['s_qty'] ?>" class="form-control guj">
							</div>
							<div class="col-md-3">
								<label class="control-label">Left</label>
								<input type="text" value="<?php echo $row['pu_i_pending'] ?>" readonly name="s_q_left" class="form-control guj">
							</div>
						</div>
						<div class="row">
							<div class="col-md-5">
								<label class="control-label">Weight</label>
								<div class="form-group">
									<input type="text" required  value="<?php echo $row['s_weight'] ?>" name="s_weight" class="form-control">
								</div>
							</div>
							<div class="col-md-4">
								<label class="control-label">Items in Weight</label>
								<input type="text" readonly="" name="s_w_qty" class="form-control guj">
							</div>
							<div class="col-md-3">
								<label class="control-label">Rate/Kg</label>
								<input type="text" required name="s_rate" value="<?php echo $row['s_rate'] ?>" class="form-control guj">
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<label class="control-label">Overall Rate</label>
								<div class="form-group">
									<input type="text" readonly="" value="<?php echo $row['s_o_rate'] ?>" name="s_o_rate" class="form-control guj">
								</div>
							</div>
							<div class="col-md-4">
								<label class="control-label">Commission</label>
								<div class="form-group">
									<input type="text" name="s_comm" value="<?php echo $row['s_com'] ?>" class="form-control guj">
								</div>
							</div>
							<div class="col-md-4">
								<label class="control-label">Majuri</label>
								<input type="text" name="s_wage" value="<?php echo $row['s_wage'] ?>" class="form-control guj">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="control-label">Other Expense</label>
								<div class="form-group">
									<input type="text" required value="<?php echo $row['s_o_e'] ?>" name="s_o_expense" class="form-control guj">
								</div>
							</div>
							<div class="col-md-6">
								<label class="control-label">Total</label>
								<div class="form-group">
									<input type="text" readonly="" value="<?php echo $row['s_total'] ?>" name="s_total" readonly class="form-control guj">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="">
								<div class="form-actions">
									<button class="btn btn-primary" id="updateButton">Update</button>
									<button type="reset" class="btn btn-default pull-right">Cancel</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-8">
					
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				console.log($("#updateButton"));
				$("#updateButton").click(function(e){
					e.preventDefault();
					$.ajax({
						type:"post",
						url:"update_submit.php",
						data:$("#sellForm").serialize(),
						success:function(data){
							alert("Data Changed Successfully");
							window.top.close();
						}
					})
				})
				$("input[name=s_weight]").on('keypress',function(e){
					if(e.which == 13){
						var text = $(this).val();
						var qtys = text.split("+");
						var res = 0;
						for (var i = 0; i <qtys.length; i++) {
							res = res + parseFloat(qtys[i]);
						}
						$("input[name=s_w_qty]").val(qtys.length);
						$(this).val(res);
						e.preventDefault();
					}
				});
				$("input[name=s_rate]").on('keypress',function(e){
					if(e.which==13){
						$("input[name=s_o_rate]").val(parseFloat($(this).val())*parseFloat($("input[name=s_weight]").val()));
						$("input[name=s_total]").val(parseFloat($("input[name=s_o_rate]").val())+parseFloat($("input[name=s_comm]").val())+parseFloat($("input[name=s_wage]").val()));
					}
				});
				$("input[name=s_o_expense]").on('keypress',function(e){
					if(e.which == 13){
						$("input[name=s_total]").val(parseInt($(this).val())+parseFloat($("input[name=s_total]").val()));
					}
				});
				$("input[name=s_qty]").on('keypress',function(e){
					if(e.which == 13){
						var wage = <?php echo $row['wage']; ?>;
						$("input[name=s_wage]").val(wage*parseInt($("input[name=s_qty]").val()));
					}
				});
			})
			jQuery.extend(jQuery.expr[':'], {
				focusable: function (el, index, selector) {
					return $(el).is('a, :input, [tabindex]');
				}
			});

			$(document).on('keypress', 'input,select', function (e) {
				if (e.which == 13) {
					e.preventDefault();
					var $canfocus = $(':focusable');
					var index = $canfocus.index(document.activeElement) + 1;
					if (index >= $canfocus.length) index = 0;
					$canfocus.eq(index).focus();
					$canfocus.eq(index).select();
				}
			});
		</script>
	</body>
	</html>
	<?php 
}
?>