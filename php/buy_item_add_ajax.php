<?php 
	include '../database/Database.php';
	$db = new Database();
	$conn = $db->connect();
	$sql = "select i_id,i_name from items where i_group_id ='".$_POST['i_group_id']."' order by i_name";
	$res = $conn->query($sql);
	while ($row = $res->fetch_assoc()) {
?>
<option class="guj" value="<?php echo $row['i_id'] ?>"><?php echo $row['i_name'] ?></option>
<?php
	}
?>