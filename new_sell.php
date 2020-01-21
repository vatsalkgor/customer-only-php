<?php 
session_start();
if(!isset($_SESSION['u_id'])){
	header('location:index.php');
}else{
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>New Sell</title>
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
					<!-- <h2>New Sell</h2> -->
					<div id="res">
					</div>
					<form method="post" id="sellForm" action="">
						<div class="row">
							<div class="col-md-3">
								<label class="control-label">Bill No.</label>
								<div class="form-group">
									<?php 
									include 'database/Database.php';
									$db = new Database();
									$conn = $db->connect();
									$sql = "select max(s_b_no) from sell_bill";
									$row = $conn->query($sql)->fetch_array();

									?>
									<input type="text" readonly value="<?php echo isset($row[0]) ? $row[0]+1:1 ?>" name="s_b_no" id="s_b_no" class="form-control guj">
								</div>
							</div>
							<div class="col-md-4">
								<label class="control-label">Sell Date</label>
								<input type="text" name="s_date" id="s_date" class="form-control guj datepicker">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="control-label">Customer Name</label>
								<select class="form-control guj select2" name="s_c_name">
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
							<div class="col-md-6">
								<label class="control-label">Item Name</label>
								<div class="form-group">
									<select class="form-control guj select2" name="s_item">
										<option></option>
										<?php 
										$sql = "select * from items";
										$res = $conn->query($sql);
										while($row=$res->fetch_assoc()){
										?>
											<option value="<?php echo $row['i_id'] ?>"><?php echo $row['i_name'] ?></option>
										<?php	
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label class="control-label">Qty</label>
								<input type="text" required name="s_qty" class="form-control guj">
							</div>
							<div class="col-md-3">
								<label class="control-label">Weight</label>
								<div class="form-group">
									<input type="text" required name="s_weight" class="form-control">
								</div>
							</div>
							<div class="col-md-3">
								<label class="control-label">Rate/Kg</label>
								<input type="text" required name="s_rate" class="form-control guj">
							</div>
							<div class="col-md-3">
								<label class="control-label">Total</label>
								<div class="form-group">
									<!-- <p><span id="s_o_rate" name="s_o_rate"></span></p> -->
									<input type="text" readonly="" name="s_o_rate" id="s_o_rate" class="form-control guj">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="control-label">Commission</label>
								<div class="form-group">
									<input type="text" name="s_comm" class="form-control guj">
								</div>
							</div>
							<div class="col-md-6">
								<label class="control-label">Majuri</label>
								<input type="text" name="s_wage" class="form-control guj">
							</div>
						</div>
						<!-- <div class="row">
							
						</div> -->
						<div class="row">
							<div class="col-md-6">
								<label class="control-label">Other Expense</label>
								<div class="form-group">
									<input type="text" required name="s_o_expense" class="form-control guj">
								</div>
							</div>
							<div class="col-md-6">
								<label class="control-label">Net Total</label>
								<div class="form-group">
									<input type="text" name="s_total" readonly class="form-control guj">
								</div>
							</div>
						</div>
						<!-- <div class="row">
							
						</div> -->
						<div class="form-group">
							<div class="">
								<div class="form-actions">
									<button id="sellButton" class="btn btn-primary pull-left">Sell</button>
									<button class="btn btn-primary" id="showButton">Show</button>
									<button class="btn btn-primary" id="updateButton" disabled>Update</button>
									<button type="reset" class="btn btn-default pull-right">Cancel</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12">
							<p id="add"></p>
						</div>
					</div>
					<table class="table table-striped table-bordered">
						<thead>
							<th>Bill No</th>
							<th>Name</th>
							<th>Item Name</th>
							<th>Qty</th>
							<th>Weight</th>
							<th>Rate</th>
							<th>Commission</th>
							<th>Majuri</th>
							<th>Other</th>
							<th>Total</th>
							<th>Delete</th>
						</thead>
						<tbody id="body">
							<?php 
							$date = date('Y.m.d');
							$sql = "select s_id,s_b_no,party.p_name,items.i_name,s_qty,s_weight,s_rate,s_com,s_wage,s_o_e,s_total from sell_bill join party,items where party.p_id = s_c_id and items.i_id = s_i_id and s_date='$date'";
							$res = $conn->query($sql);
							while ($row = $res->fetch_assoc()) {
								?>
								<tr id="<?php echo $row['s_id'] ?>">
									<td class="guj"><?php echo $row['s_b_no'] ?></td>
									<td class="guj"><?php echo $row['p_name'] ?></td>
									<td class="guj"><?php echo $row['i_name'] ?></td>
									<td class="guj"><?php echo $row['s_qty'] ?></td>
									<td class="guj"><?php echo $row['s_weight'] ?></td>
									<td class="guj"><?php echo $row['s_rate'] ?></td>
									<td class="guj"><?php echo $row['s_com'] ?></td>
									<td class="guj"><?php echo $row['s_wage'] ?></td>
									<td class="guj"><?php echo $row['s_o_e'] ?></td>
									<td class="guj"><?php echo $row['s_total'] ?></td>
									<td><button class="btn btn-danger" onclick="deleteItem(<?php echo $row['s_id'] ?>)">Delete</button></td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			var per_com = 0
			var wage = 0;
			function show(){
				$(".loader").css('display','block');
				var date=$("#s_date").val();
				$.ajax({
					type:"POST",
					url:"sell/get_f_bill.php",
					data:{date:date},
					success:function(data){
						$(".loader").css('display','none');
						$("#body").html('');
						$("#body").append(data);
					}
				})
			}
			
			$(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
				$(this).closest(".select2-container").siblings('select:enabled').select2('open');
			});

            // steal focus during close - only capture once and stop propogation
            $('select.select2').on('select2:closing', function (e) {
            	$(e.target).data("select2").$selection.one('focus focusin', function (e) {
            		e.stopPropagation();
            	});
            });

            function deleteItem(id){
            	$(".loader").css('display','block');
            	$.ajax({
            		type:"POST",
            		url:"sell/delete_item_ajax.php",
            		data:{id:id},
            		success:function(data){
            			$(".loader").css('display','none');
            			if(data == 1){
            				alert("Successfully Deleted.");
							//location.reload();
							show();
						}else{
							alert("Something Went Wrong.");
						}
					}
				})
            }
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

                $("#showButton").click(function(e){
                	e.preventDefault();
                	show();
                })

                $("select[name=s_f_name]").change(function(){
                	$(".loader").css('display','block');
                	$("#body").html('');
                	var id = $(this).val();
                	var date = $('#s_p_date').val();
                	$.ajax({
                		type:"POST",
                		url:"sell/get_item_name_ajax.php",
                		data:{f_id:id,date:date},
                		success:function(data){
                			$(".loader").css('display','none');
                			$('select[name=s_item]').html(data)
                			show();
                		}
                	});
                })
                $("select[name=s_item]").change(function(){
                	$(".loader").css('display','block');
                	var i_id = $(this).val();
                	$.ajax({
                		type:"POST",
                		url:"sell/g_left_ajax.php",
                		data:{i_id:i_id},
                		success:function(data){
                			data = jQuery.parseJSON(data)
                			console.log(data)
                			$(".loader").css('display','none');
							// alert($("#s_q_left").html())
							per_com = data[0];
							// $("input[name=s_wage]").val(data[2]);
							wage = data[1];
						}
					});
                });
                $("input[name=s_weight]").focusout(function(e){
					// if(e.which == 13){
						var text = $(this).val();
						var qtys = text.split('+');
						if(qtys.length > 1){
							var res=0;
							var str = "";
							for (var i = 0; i <qtys.length; i++) {
								res = res + parseFloat(qtys[i]);
								str = str + "+" + qtys[i];
							}
							$(this).val(res);
							$("#add").html(str + " :: " + qtys.length);
						}else{
							qtys = text.split('*');
							var res=1;
							var str = "";
							for (var i = 0; i <qtys.length; i++) {
								res = res * parseFloat(qtys[i]);
								str = str + "*" + qtys[i];
							}
							$(this).val(res);
							$("#add").html(str + " :: " + qtys.length);
						}
						
						// $(this).val(res);
						e.preventDefault();
					// }
				});
                $("input[name=s_rate]").focusout(function(e){

					// if(e.which==13){
						if($(this).val() == ''){
							alert('Enter price')
						}else{
							$("input[name=s_o_expense]").val("0");
							$("input[name=s_wage]").val(wage*$("input[name=s_qty]").val());
							$("#s_o_rate").val(Math.ceil(parseFloat($(this).val())*parseFloat($("input[name=s_weight]").val())));
							var comm = Math.ceil((per_com*parseInt($("#s_o_rate").val()))/100)
							$('input[name=s_comm]').val(comm);
						// alert(parseInt($("input[name=s_o_expense]")))
						calcTotal()
					// }
				}
			});

                $("input[name=s_o_expense]").focusout(function(e){
					// if(e.which == 13){
						calcTotal();
					// }
				})

                function calcTotal(){
                	$("input[name=s_total]").val(Math.ceil(parseInt($("#s_o_rate").val()) + parseFloat($("input[name=s_comm]").val()) + parseInt($("input[name=s_wage]").val()) + parseInt($("input[name=s_o_expense]").val())))
                }

                $("#sellButton").click(function(e){
                	$(".loader").css('display','block');
                	e.preventDefault();
					// if(parseInt(parseInt($("input[name=s_q_left]").val())- $("input[name=s_qty]").val()) >=0 ){
						var str = $("#sellForm").serialize();
						$.ajax({
							type:"POST",
							url:"sell/add_sell_ajax.php",
							data:str,
							success:function(data){
								$(".loader").css('display','none');
								// location.reload(true);
								data = jQuery.parseJSON(data);
								console.log(data)
								if(data[0].includes("Success")){
									$("#res").html('<p class="text-success">'+data[0]+'</p>');
								}else{
									$("#res").html('<p class="text-danger">'+data[0]+'</p>');
								}
								var append = '<tr id='+data[1]['s_id']+'>'+
								'<td class="guj">'+data[1]['s_b_no']+'</td>'+
								'<td class="guj">'+data[1]['p_name']+'</td>'+
								'<td class="guj">'+data[1]['i_name']+'</td>'+
								'<td class="guj">'+data[1]['s_qty']+'</td>'+
								'<td class="guj">'+data[1]['s_weight']+'</td>'+
								'<td class="guj">'+data[1]['s_rate']+'</td>'+
								'<td class="guj">'+data[1]['s_com']+'</td>'+
								'<td class="guj">'+data[1]['s_wage']+'</td>'+
								'<td class="guj">'+data[1]['s_o_e']+'</td>'+
								'<td class="guj">'+data[1]['s_total']+'</td>'+
								'<td><button class="btn btn-danger" onclick="deleteItem('+data[1]['s_id']+')">Delete</button></td>'+
								'</tr>';
								$('#body').prepend(append);
								$("#s_b_no").val(parseInt($("#s_b_no").val()) + 1);
								$("select[name=s_c_name]").focus();
								$("#s_q_left").html(data[1]['pu_i_pending']);
								$("input[name=s_comm]").val(per_com);

								// Reset Values
								$("input[name=s_qty").val('');
								$("input[name=s_weight").val('');
								$("input[name=s_rate").val('');
								$("input[name=s_comm").val('');
								$("input[name=s_wage").val('');
								$("input[name=s_o_rate]").val('');
								$("input[name=s_total]").val('');
								$("input[name=s_o_expense]").val('');
								
								//show table
								show();
							}
						});
					// }else{
						// alert("Qty should be less than Left.");
					// }
				});
            });
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