<?php 
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
$date=date('Y.m.d',strtotime($_POST['date']));
$sql = "select s_id,s_b_no,party.p_name,items.i_name,s_qty,s_weight,s_rate,s_com,s_wage,s_o_e,s_total from sell_bill join party,items where party.p_id=s_c_id and items.i_id=s_i_id and s_date='$date' order by s_b_no desc";

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