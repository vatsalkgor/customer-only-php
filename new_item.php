<?php 
session_start();
if(!isset($_SESSION['u_id'])){
	header('location:index.php');
}else{
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>New Item</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script src="js/jquery.min.js"></script>
		<script src="js/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/guj_input.css">
		<link href="css/select2.min.css" rel="stylesheet" />
		<script src="js/select2.min.js"></script>
	</head>
	<body>
		<?php include "include/navbar.php"; ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4">
					<h2>New Item</h2>
					<?php 
					if(isset($_SESSION['new_item_added'])){
						echo '<p class="text-success">'.$_SESSION['new_item_added'].'</p>';
						unset($_SESSION['new_item_added']);
					}
					if(isset($_SESSION['new_item_not_added'])){
						echo '<p class="text-danger">'.$_SESSION['new_item_not_added'].'</p>';
						unset($_SESSION['new_item_not_added']);
					}
					if(isset($_SESSION['item_update_success'])){
						echo '<p class="text-success">'.$_SESSION['item_update_success'].'</p>';
						unset($_SESSION['item_update_success']);
					}
					if(isset($_SESSION['item_update_unsuccess'])){
						echo '<p class="text-danger">'.$_SESSION['item_update_unsuccess'].'</p>';
						unset($_SESSION['item_update_unsuccess']);
					}
					if(isset($_SESSION['item_delete'])){
						echo '<p class="text-danger">'.$_SESSION['item_delete'].'</p>';
						unset($_SESSION['item_delete']);
					}
					?>
					<form class="form-horizontal" method="post" action="php/item_add.php">
						<label class="control-label">Item Name</label>
						<div class="">
							<input type="text" name="i_item_name" class="form-control guj">
						</div>
						<label class="control-label">Item Group</label>
						<div class="">
							<select name="i_item_group" class="form-control guj select2">
								<?php 
								include 'database/Database.php';
								$db = new Database();
								$conn = $db->connect();
								
								$sql = "select g_id,g_name from groups";
								$res = $conn->query($sql);
								while ($row = $res->fetch_assoc()) {
									?>
									<option class="guj" value="<?php echo $row['g_id'] ?>"><?php echo $row['g_name']; ?></option>
									<?php
								}
								?>
							</select>
						</div>
						<br>
						<div class="form-group">
							<div class="form-actions">
								<button type="submit" id="saveButton" class="btn btn-primary pull-left">Save</button>
								<button class="btn btn-primary" id="showButton">Show</button>
								<button class="btn btn-primary" id="updateButton" disabled>Update</button>
								<button type="reset" class="btn btn-default pull-right">Cancel</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-8">
					<table class="table table-bordered table-striped" style="width: 100%">
						<thead>
							<th>Item Name</th>
							<th>Group Name</th>
							<th>Edit</th>
							<th>Delete</th>
						</thead>
						<?php 
						$sql = "select items.i_name,items.i_id,groups.g_name from items join groups where items.i_group_id = groups.g_id";
						$res = $conn->query($sql);
						?> 
						<tbody id="tbody">	
							<?php while ($row = $res->fetch_assoc()) {
								?>
								<tr>
									<td class="guj"><?php echo $row['i_name'] ?></td>
									<td class="guj"><?php echo $row['g_name']  ?></td>
									<td><button class="btn btn-primary" onclick="itemEdit(<?php echo $row['i_id']; ?>)">Edit</button></td>
									<td><button class="btn btn-secondary" onclick="itemDelete(<?php echo $row['i_id']; ?>)">Delete</button></td>
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
			$(".select2").select2();
		})
		function itemEdit(id){
			$(".loader").css('display','block');
			$.ajax({
				type:"post",
				url:'php/item_edit.php',
				data:{i_id:id},
				success:function(data){
					$(".loader").css('display','none');
					data = jQuery.parseJSON(data);
					$('input[name=i_item_name]').val(data['i_name']);
					$('select[name=i_item_group]').val(data['i_group_id']);
					$('#saveButton').prop('disabled',true);
					$('#updateButton').prop('disabled',false);
					$('#updateButton').prop('value',data['i_id']);

				}
			});
		}
		function itemDelete(id){
			if(confirm("Are you sure you want to Delete??")){
				$(".loader").css('display','block');
				$.ajax({
					type:"post",
					url:"php/item_delete.php",
					data:{i_id:id},
					success:function(){
						$(".loader").css('display','none');
						location.reload(true);
					}
				})
			}
		}
		$('#showButton').click(function(e){
			$(".loader").css('display','block');
			e.preventDefault();
			var type = $('select[name=i_item_group]').val();
			$.ajax({
				type:"post",
				url:"php/item_show.php",
				data:{i_group_id:type},
				success: function(data){
					$(".loader").css('display','none');
					$('#tbody').html('');
					$('#tbody').html(data);
				}
			})
		})
		$('#updateButton').click(function(e){
			$(".loader").css('display','block');
			e.preventDefault();
			var id = $('#updateButton').val();
			var name=$('input[name=i_item_name]').val();
			var group = $('select[name=i_item_group]').val();
			$.ajax({
				type:"post",
				url:"php/item_update.php",
				data:{i_id:id,i_name:name,i_group_id:group},
				success:function(data){
					$(".loader").css('display','none');
					location.reload(true);
				}
			})
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