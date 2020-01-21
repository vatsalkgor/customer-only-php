<?php 
include "../database/Database.php";
$db = new Database();
$conn = $db->connect();
$sql = "select items.i_name,items.i_id,groups.g_name from items join groups where items.i_group_id = groups.g_id and i_group_id=".$_POST['i_group_id'];
echo $sql;
$res = $conn->query($sql);
while ($row = $res->fetch_assoc()) {
	?>
	<tr>
		<td class="guj"><?php echo $row['i_name'] ?></td>
		<td class="guj"><?php echo $row['g_name'] ?></td>
		<td><button class="btn btn-primary" onclick="itemEdit(<?php echo $row['i_id']; ?>)">Edit</button></td>
		<td><button class="btn btn-secondary" onclick="itemDelete(<?php echo $row['i_id'] ?>)">Delete</button></td>
	</tr>
	<?php		
}
?>