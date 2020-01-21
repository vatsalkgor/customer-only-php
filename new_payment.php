<?php 
session_start();
if(!isset($_SESSION['u_id'])){
	header('location:index.php');
}else{
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>New Payment</title>
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
				<div class="col-md-4">
					<h2>New Payment</h2>
					<form method="post" action="">
						<div class="form-group">
							<label class="control-label">Voucher No</label>	
							<?php 
							include 'database/Database.php';
							$db = new Database();
							$conn = $db->connect();
							$sql = "select MAX(a_v_no) as v_no from account";
							$row = $conn->query($sql)->fetch_array();
							?>
							<input class="form-control guj" type="text" id="v_no" name="v_no" value="<?php echo is_null($row[0])? 1: $row[0] + 1 ?>" readonly>						
						</div>
						<div class="form-group row">
							<div class="col-sm-6">
								<label class="control-label">Date</label>
								<input type="text" id="date" class="form-control guj datepicker">
							</div>
							<div class="col-sm-6">
								<label class="control-label">Party Name</label>
								<select class="form-control guj select2" id="p_name">
									<option></option>
									<?php 
									$sql = "select p_id,p_name from party order by p_name";
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
						<div class="form-group row">
							<div class="col-sm-6">
								<label class="control-label">Total Pending</label>
								<p><span class="guj" id="pending"></span></p>
								<!-- 	<input type="text" id="pending" readonly class="form-control guj"> -->
							</div>
							<div class="col-sm-6">
								<label class="control-label">Amount</label>
								<input type="text" id="amount" class="form-control guj">
							</div>
						</div>
					</form>
					<div class="form-group">
						<div class="">
							<div class="form-actions">
								<button id="addButton" class="btn btn-primary pull-left">Add</button>
								<button class="btn btn-primary" id="showButton">Show</button>
								<button type="reset" class="btn btn-default pull-right">Cancel</button>
							</div>
						</div>
					</div>

				</div>
				<div class="col-md-8">
					<table class="table table-bordered table-striped" style="width: 100%">
						<thead>
							<th>Voucher No</th>
							<th>Name</th>
							<th>Date</th>
							<th>Amount</th>
						</thead>
						<tbody id="tbody">	

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		function doAJAX(){
			if(confirm("Are you sure??")){
				$(".loader").css('display','block');
				var d = $('#date').val();
				var v_no = $('#v_no').val();
				var amount = $('#amount').val();
				var p_id = $('#p_name').val();
				$.ajax({
					type:"post",
					url:"payment/add_payment.php",
					data:{date:d,amt:amount,v_no:v_no,p_id:p_id},
					success: function(data){
						$(".loader").css('display','none');
						data = jQuery.parseJSON(data);
						if(data['success'] == 1){
							if(data['message_res'] != undefined){
								if(data['message_res']['type'] != "success"){
									alert('Message Not sent');
								}else{
									alert('Message Sent successfully.');
								}
							}
						// alert("Added successfully.");
						$('#v_no').val(parseInt($('#v_no').val())+1);
						$("#pending").html(parseFloat($("#pending").html())-parseFloat($("#amount").val()))
						$("#amount").val('')	
					}else{
						alert("Something Went wrong. Contact Admin.")
					}
					showButton();
				}
			});
			}
		}
		$("#sms").click(function(){
			if($(this).val() == "1"){
				$(this).attr('checked',false);
				$(this).val("0");
			}else{
				$(this).attr('checked',true);
				$(this).val("1");
			}
		})
		$("#bad_debt").click(function(){
			if($(this).val() == "1"){
				$(this).attr('checked',false);
				$(this).val("0");
			}else{
				$(this).attr('checked',true);
				$(this).val("1");
			}
		})

		function showButton(){
			$(".loader").css('display','block');
			var d = $('#date').val();
			var id = $('#p_name').val();
			$.ajax({
				type:"post",
				url:"payment/payment_table.php",
				data:{date:d},
				success: function(data){
					$(".loader").css('display','none');
					$('#tbody').html('');
					$('#tbody').html(data);
				}
			});
		}

		$('#showButton').click(function(e){
			e.preventDefault();
			showButton();
		})
		$("#amount").on('keypress',function(e){
			if(e.which == 13){
				doAJAX();
				$("#p_name").focus();
			}
		})

		$('#addButton').click(function(e){
			e.preventDefault();
			doAJAX();
		})
		$(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
			$(this).closest(".select2-container").siblings('select:enabled').select2('open');
		});

            // steal focus during close - only capture once and stop propogation
            $('select.select2').on('select2:closing', function (e) {
            	$(e.target).data("select2").$selection.one('focus focusin', function (e) {
            		e.stopPropagation();
            	});
            });
            $(document).ready(function(){
            	var configParamsObj = {
                    placeholder: 'Select an option...', // Place holder text to place in the select
                    minimumResultsForSearch: 3, // Overrides default of 15 set above
                    matcher: function (params, data) {
                        // If there are no search terms, return all of the data
                        if ($.trim(params.term) === '') {
                        	return data;
                        }

                        // `params.term` should be the term that is used for searching
                        // `data.text` is the text that is displayed for the data object
                        if (data.text.toLowerCase().startsWith(params.term.toLowerCase())) {
                        	var modifiedData = $.extend({}, data, true);
                            // You can return modified objects from here
                            // This includes matching the `children` how you want in nested data sets
                            return modifiedData;
                        }
                        // Return `null` if the term should not be displayed
                        return null;
                    }
                };
                $(".loader").css('display','none');
                $(".select2").select2(configParamsObj);
                $('.datepicker').datepicker({
                	dateFormat:'dd.mm.yy'
                }).datepicker('setDate',new Date);
                $("#bad_debt").attr('checked',false)
                $("#p_name").change(function(e){
                	$(".loader").css('display','block');
                	e.preventDefault();
                	$.ajax({
                		type:"post",
                		url:"payment/get_pending_payment.php",
                		data:{id:$(this).val()},
                		success:function(data){
                			$(".loader").css('display','none');
                			$("#pending").html(parseFloat(data));
                		}
                	})
                })
                $("#p_name").on('keypress',function(e){
                	console.log(e.which);
                	if(e.which==13){
                		e.preventDefault();
                		$("#amount").focus();
                	}
                })
            });
        </script>
        </html>
        <?php 
    }
    ?>