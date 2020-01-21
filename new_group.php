<?php 
session_start();
if(!isset($_SESSION['u_id'])){
	header('location:index.php');
}else{
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>New Group</title>
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
					<h2>New Group</h2>
					<?php 
					if(isset($_SESSION['new_group_added'])){
						echo '<p class="text-success">'.$_SESSION['new_group_added'].'</p>';
						unset($_SESSION['new_group_added']);
					}
					if(isset($_SESSION['new_group_not_added'])){
						echo '<p class="text-danger">'.$_SESSION['new_group_not_added'].'</p>';
						unset($_SESSION['new_group_not_added']);
					}
					if(isset($_SESSION['group_update_success'])){
						echo '<p class="text-success">'.$_SESSION['group_update_success'].'</p>';
						unset($_SESSION['group_update_success']);
					}
					if(isset($_SESSION['group_update_unsuccess'])){
						echo '<p class="text-danger">'.$_SESSION['group_update_unsuccess'].'</p>';
						unset($_SESSION['group_update_unsuccess']);
					}
					if(isset($_SESSION['group_delete'])){
						echo '<p class="text-danger">'.$_SESSION['group_delete'].'</p>';
						unset($_SESSION['group_delete']);
					}
					?>
					<form class="form-horizontal" method="post" action="php/group_add.php">
						<label class="control-label">Group Name</label>
						<div class="">
							<input type="text" name="g_g_name" class="form-control guj">
						</div>
						<label class="control-label">Customer Commission</label>
						<div class="">
							<input type="text" name="g_customer_com" class="form-control guj">
						</div>
						<label class="control-label">Customer Majuri</label>
						<div class="">
							<input type="text" name="g_customer_wage" class="form-control guj">
						</div>
						<br>
						<div class="form-group">
							<div class="form-actions">
								<button type="submit" id="saveButton" class="btn btn-primary pull-left">Save</button>
								<!-- <button class="btn btn-primary" id="showButton">Show</button> -->
								<button class="btn btn-primary" id="updateButton" disabled>Update</button>
								<button type="reset" class="btn btn-default pull-right">Cancel</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-8">
					<table class="table table-bordered table-striped" style="width: 100%">
						<thead>
							<th>Group Name</th>
							<th>Customer Commission</th>
							<th>Customer Majuri</th>
							<th>Edit</th>
							<th>Delete</th>
						</thead>
						<?php 
						include 'database/Database.php';
						$db = new Database();
						$conn = $db->connect();
						$sql = "select * from groups";
						$res = $conn->query($sql);
						?> 
						<tbody id="tbody">	
							<?php while ($row = $res->fetch_assoc()) {
								?>
								<tr>
									<td class="guj"><?php echo $row['g_name'] ?></td>
									<td class="guj"><?php echo $row['g_customer_com'] ?></td>
									<td class="guj"><?php echo $row['g_customer_wage'] ?></td>
									<td><button class="btn btn-primary" onclick="groupEdit(<?php echo $row['g_id']; ?>)">Edit</button></td>
									<td><button class="btn btn-secondary" onclick="groupDelete(<?php echo $row['g_id']; ?>)">Delete</button></td>
								</tr>
								<?php
							} ?>
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
		function groupEdit(id){
			$(".loader").css('display','block');
			$.ajax({
				type:"post",
				url:'php/group_edit.php',
				data:{g_id:id},
				success:function(data){
					$(".loader").css('display','none');
					data = jQuery.parseJSON(data);
					$('input[name=g_g_name]').val(data['g_name']);
					$('input[name=g_farmer_com]').val(data['g_farmer_com']);
					$('input[name=g_farmer_wage]').val(data['g_farmer_wage']);
					$('input[name=g_customer_com]').val(data['g_customer_com']);
					$('input[name=g_customer_wage]').val(data['g_customer_wage']);
					$('#saveButton').prop('disabled',true);
					$('#updateButton').prop('disabled',false);
					$('#updateButton').prop('value',data['g_id']);

				}
			});
		}
		function groupDelete(id){
			if(confirm("Are you sure you want to Delete??")){
				$(".loader").css('display','block');
				$.ajax({
					type:"post",
					url:"php/group_delete.php",
					data:{g_id:id},
					success:function(){
						$(".loader").css('display','none');
						location.reload(true);
					}
				})
			}
		}
		// $('#showButton').click(function(e){
		// 	e.preventDefault();
		// 	var type = $('#p_type').val();
		// 	$.ajax({
		// 		type:"post",
		// 		url:"php/party_show.php",
		// 		data:{p_type:type},
		// 		success: function(data){
		// 			$('#tbody').html('');
		// 			$('#tbody').html(data);
		// 		}
		// 	})
		// })
		$('#updateButton').click(function(e){
			$(".loader").css('display','block');
			e.preventDefault();
			var id = $('#updateButton').val();
			var name = $('input[name=g_g_name]').val();
			var farmer_com = $('input[name=g_farmer_com]').val();
			var farmer_wage = $('input[name=g_farmer_wage]').val();
			var customer_com = $('input[name=g_customer_com]').val();
			var customer_wage = $('input[name=g_customer_wage]').val();
			$.ajax({
				type:"post",
				url:"php/group_update.php",
				data:{g_id:id,g_name:name,g_farmer_com:farmer_com,g_farmer_wage:farmer_wage,g_customer_com:customer_com,g_customer_wage:customer_wage},
				success:function(data){
					$(".loader").css('display','none');
					location.reload(true);
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
        // Get all focusable elements on the page
        var $canfocus = $(':focusable');
        var index = $canfocus.index(document.activeElement) + 1;
        if (index >= $canfocus.length) index = 0;
        $canfocus.eq(index).focus();
    }		
});
</script>
</html>
<?php 
}
?>