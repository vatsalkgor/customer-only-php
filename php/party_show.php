<?php 
include "../database/Database.php";
$db = new Database();
$conn = $db->connect();
$sql = "select * from party order by p_name";
$res = $conn->query($sql);
while ($row = $res->fetch_assoc()) {
	?>
	<tr>
		<td class="guj"><?php echo $row['p_name'] ?></td>
		<td class="guj"><?php echo $row['p_pending_amount'] ?></td>
		<td><button class="btn btn-primary" onclick="partyEdit(<?php echo $row['p_id']; ?>)">Edit</button></td>
		<td><button class="btn btn-secondary" onclick="partyDelete(<?php echo $row['p_id']; ?>)">Delete</button></td>
	</tr>
	<?php		
}
?>