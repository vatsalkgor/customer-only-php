<?php 
session_start();
if(!isset($_SESSION['u_id'])){
	header('location:index.php');
}else{
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Buying Details</title>
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
					<h2>Buying Details</h2>
					<?php 
					include 'database/Database.php';
					$db = new Database();
					$conn = $db->connect();
					$sql = "select max(pu_b_no) as bill from purchase";
					$row['bill'] = $conn->query($sql)->fetch_array();	
					$sql = "select p_id,p_name from party where p_type=1 order by p_name";
					$row['farmers'] = $conn->query($sql);
					$sql = "select g_id,g_name from groups";
					$row['groups'] = $conn->query($sql);	
					?>
					<div id="saveResult">
						
					</div>
					<form method="post" action="">
						<div class="row">
							<div class="col-md-6">
								<label class="">Bill Number</label>
								<div class="form-group">
									<input type="text" value="<?php echo is_null($row['bill'])? 1: $row['bill']['bill'] + 1 ?>" name="buy_b_no" readonly class="form-control guj">
								</div>
							</div>
							<div class="col-md-6">
								<label class="control-label">Date</label>
								<div class="form-group">
									<input type="text" value="<?php echo isset($row['e'][1])?$row['e'][1] : ""?>" name="buy_start_date" class="form-control guj datepicker">
								</div>
							</div>
						</div>

						<label class="control-label">Farmer Name</label>
						<div class="form-group">
							<select name="buy_farmer_name" class="form-control guj select2">
								<?php 
								while ($res = $row['farmers']->fetch_assoc()) {
									?>
									<option class="guj" value="<?php echo $res['p_id'] ?>"><?php echo $res['p_name'] ?></option>
									<?php
								}
								?>
							</select>
						</div>
						<label class="control-label">Item Category</label>
						<div class="form-group">
							<select type="text" id="buy_i_cat" class="form-control guj select2">
								<option></option>
								<?php 
								while ($res = $row['groups']->fetch_assoc()) {
									?>
									<option class="guj" value="<?php echo $res['g_id'] ?>"><?php echo $res['g_name'] ?></option>
									<?php
								}
								?>
							</select>
						</div>
						<div id="i_name">
							<label class="control-label">Item Name</label>
							<div class="form-group">
								<select type="text" id="buy_i_name" class="form-control guj select2">

								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="control-label">Dagina</label>
								<div class="form-group">
									<input type="text" name="buy_qty" class="form-control guj">
								</div>
							</div>
							<div class="col-md-6">
								<label class="control-label">Remarks</label>
								<div class="form-group">
									<input type="text" name="buy_remarks" class="form-control guj">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="form-actions">
								<button id="buyButton" class="btn btn-primary">Buy</button>
								<button class="btn btn-primary" id="saveButton">Save</button>
								<button class="btn btn-primary" id="updateButton">Update</button>
								<button type="reset" class="btn btn-default pull-right">Cancel</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-8">
					<table class="table table-striped table-bordered">
						<thead>
							<th>Sr. No</th>
							<th>Name</th>
							<th>Item Name</th>
							<th>Dagina</th>
							<th>Edit</th>
							<th>Delete</th>
						</thead>
						<tbody id="body">

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<script type="text/javascript">	
			function editItem(id){
				$("#buyButton").prop('disabled',true);
				$("#saveButton").prop('disabled',true);
				$("#updateButton").prop('disabled',false);
				$("#saveUpdate").prop('disabled',false);
				var i = 0;
				var array = new Array();
				$("#"+id.toString()).find('td').each(function(){
					array[i] = $(this).text();
					i++;
				})
				$('select[name=buy_farmer_name]').val(array[2]);
				$('#buy_i_cat option[value='+parseInt(array[4])+']').prop('selected','selected');
				onCatChange();
				$('#buy_i_name').val(array[5]);
				$('input[name=buy_qty]').val(array[6]);
				$("#updateButton").val(id);
				$("select[name=buy_farmer_name]").prop('disabled',true);
				$("#buy_i_cat").prop('disabled',true);
				$("#buy_i_name").prop('disabled',true);
			}
			function validateForm() {
				var x = $('input[name=buy_qty]').val();
				if (x == "") {
					alert("Quantity must be filled out");
					return false;
				}
				return true;
			}
			var n = 0;

			function buy(){
				n = $("#body tr").length+1;
				var qty = $('input[name=buy_qty]').val();
				var name = $('select[name=buy_farmer_name] option:selected').text();
				var name_val = $('select[name=buy_farmer_name] option:selected').val();
				var i_name = $('#buy_i_name option:selected').text();
				var i_val = $('#buy_i_name option:selected').val();
				var g_val = $('#buy_i_cat option:selected').val();
				$("#body").append('<tr id='+n+'>');
				$('#'+n).append('<td class="guj">'+n+'</td>');
				$('#'+n).append('<td class="guj">'+name+'</td>');
				$('#'+n).append('<td style="display:none" class="guj">'+name_val+'</td>');
				$('#'+n).append('<td class="guj">'+i_name+'</td>');
				$('#'+n).append('<td style="display:none;" class="guj">'+g_val+'</td>');
				$('#'+n).append('<td style="display:none;"class="guj">'+i_val+'</td>');
				$('#'+n).append('<td class="guj">'+qty+'</td>');
				$('#'+n).append('<td><button class="btn btn-primary" onclick="editItem('+n+')">Edit</button></td>');
				$('#'+n).append('<td><button onclick="deleteItem('+n+')" class="btn btn-danger">Delete</button></td>');
				$("#body").append("</tr>");
				n++;
				$('#buy_i_cat').focus();
			}
			function deleteItem(id){
				$("#"+id.toString()).remove();
			}
			function onCatChange(){
				$(".loader").css('display','block')
				var cat = $("#buy_i_cat").val();
				$.ajax({
					type:"POST",
					url:"php/buy_item_add_ajax.php",
					data:{i_group_id:cat},
					success:function(data){
						$('#buy_i_name').html(data);
						$('#i_name').show();
						$(".loader").css('display','none');
					}
				});
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
				$('#buy_i_cat').on('change',function(){
					onCatChange();
				});
				$('#buyButton').click(function(e){
					e.preventDefault();
					if(validateForm()){
						buy();
					}
				});
				$('#buyButton').on('keypress',function(e){
					e.preventDefault();
					if(e.which == 13 && validateForm()){
						buy();
					}	
				});
				$("#saveButton").click(function(e){
					$(".loader").css('display','block');
					e.preventDefault();
					var array = new Array();
					var i = 0;
					var t = $('#body > tr').each(function(){
						array[i] = new Array();
						var j = 0;
						$(this).find('td').each(function(){
							array[i][j] = $(this).text();
							j++;
						});
						i++;
					});
					// console.log(array);
					var date = $("input[name=buy_start_date]").val();
					var bill = $("input[name=buy_b_no]").val();
					var rem = $("input[name=buy_remarks]").text();
					if(rem == undefined){
						rem ="";
					}
					$.ajax({
						type:"POST",
						url:"buy/add_buy_details.php",
						data:{table:array,b_date:date,b_no:bill,remarks:rem},
						success:function(data){
							$(".loader").css('display','none');
							if(data.includes("0")){
								$("#saveResult").html('<p class="text-danger">Something went Wrong. Please Try Again.');
							}else{
								$("#saveResult").html('<p class="text-success">Data Successfully Entered.');
							}
						}
					});
					n = 1;
					$('select[name=buy_farmer_name]').focus();
					$("#body").html('');
					$('input[name=buy_b_no').val(parseInt($('input[name=buy_b_no').val())+1);
					$("#buy_i_cat").val($("#buy_i_cat option:first").val());
					$('input[name=buy_qty').val('');
					// $("select[name=buy_i_name]").html('');
					onCatChange();
				})
				$("#updateButton").click(function(e){
					e.preventDefault();
					var n = $(this).val();
					var n_qty = $('input[name=buy_qty]').val();
					var tds = $("#"+n).find('td');
					tds[6].innerHTML= n_qty;
					$("#buyButton").prop('disabled',false);
					$("#saveButton").prop('disabled',false);
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