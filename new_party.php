<?php 
session_start();
if(!isset($_SESSION['u_id'])){
	header('location:index.php');
}else{
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>New Party</title>
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
					<h2>New Party</h2>
					<?php 
					if(isset($_SESSION['new_party_added'])){
						echo '<p class="text-success">'.$_SESSION['new_party_added'].'</p>';
						unset($_SESSION['new_party_added']);
					}
					if(isset($_SESSION['new_party_not_added'])){
						echo '<p class="text-danger">'.$_SESSION['new_party_not_added'].'</p>';
						unset($_SESSION['new_party_not_added']);
					}
					if(isset($_SESSION['party_update_success'])){
						echo '<p class="text-success">'.$_SESSION['party_update_success'].'</p>';
						unset($_SESSION['party_update_success']);
					}
					if(isset($_SESSION['party_update_unsuccess'])){
						echo '<p class="text-danger">'.$_SESSION['party_update_unsuccess'].'</p>';
						unset($_SESSION['party_update_unsuccess']);
					}
					if(isset($_SESSION['party_delete'])){
						echo '<p class="text-danger">'.$_SESSION['party_delete'].'</p>';
						unset($_SESSION['party_delete']);
					}
					?>
					<form method="post" action="php/new_party_add.php">
						<label class="control-label">Party Name</label>
						<div class="">
							<input required type="text" name="p_name" class="form-control guj">
						</div>
						<div class="form-group">
							<label class="control-label">Pending Amount</label>
							<div class="">
								<div class="input-group">
									<input required="" type="text" name="p_pending_amount" class="form-control guj"><span class="input-group-addon"></span>
								</div>
							</div>
						</div>                  
						<div class="form-group">
							<div class="">
								<div class="form-actions">
									<button type="submit" id="saveButton" class="btn btn-primary pull-left">Save</button>
									<button class="btn btn-primary" id="showButton">Show</button>
									<button class="btn btn-primary" id="updateButton" disabled>Update</button>
									<button type="reset" class="btn btn-default pull-right">Cancel</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-8">
					<table class="table table-bordered table-striped" style="width: 100%">
						<thead>
							<th>Name</th>
							<th>Pending Amount</th>
							<th>Edit</th>
							<th>Delete</th>
						</thead>
						<?php 
						include 'database/Database.php';
						$db = new Database();
						$conn = $db->connect();
						$sql = "select * from party order by p_name";
						$res = $conn->query($sql);
						?> 
						<tbody id="tbody">	
							<?php while ($row = $res->fetch_assoc()) {
								?>
								<tr>
									<td class="guj"><?php echo $row['p_name'] ?></td>
									<td class="guj"><?php echo $row['p_pending_amount'] ?></td>
									<td><button class="btn btn-primary" onclick="partyEdit(<?php echo $row['p_id']; ?>)">Edit</button></td>
									<td><button class="btn btn-secondary" onclick="partyDelete(<?php echo $row['p_id']; ?>)">Delete</button></td>
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
		function partyEdit(id){
			$(".loader").css('display','block');
			$.ajax({
				type:"post",
				url:'php/party_edit.php',
				data:{p_id:id},
				success:function(data){
					$(".loader").css('display','none');
					data = jQuery.parseJSON(data);
					$('input[name=p_name]').val(data['p_name']);
					$('input[name=p_pending_amount]').val(data['p_pending_amount']);
					$('#saveButton').prop('disabled',true);
					$('#updateButton').prop('disabled',false);
					$('#updateButton').prop('value',data['p_id']);

				}
			});
		}
		function partyDelete(id){
			if(confirm("Are you sure you want to Delete??")){
				$(".loader").css('display','block');
				$.ajax({
					type:"post",
					url:"php/party_delete.php",
					data:{p_id:id},
					success:function(){
						$(".loader").css('display','none');
						location.reload(true);
					}
				});
			}
		}
		$('#showButton').click(function(e){
			$(".loader").css('display','block');
			e.preventDefault();
			var type = $('#p_type').val();
			$.ajax({
				type:"post",
				url:"php/party_show.php",
				data:{p_type:type},
				success: function(data){
					$(".loader").css('display','none');
					$('#tbody').html('');
					$('#tbody').html(data);
				}
			});
		});
		$('#updateButton').click(function(e){
			$(".loader").css('display','block');
			e.preventDefault();
			var id = $('#updateButton').val();
			var name = $('input[name=p_name]').val();
			var pamount = $('input[name=p_pending_amount]').val();
			$.ajax({
				type:"post",
				url:"php/party_update.php",
				data:{p_id:id,p_name:name,p_pending_amount:pamount},
				success:function(data){
					$(".loader").css('display','none');
					location.reload(true);
				}
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