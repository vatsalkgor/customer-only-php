<?php 
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
$date= date('Y.m.d',strtotime($_POST['date']));
$sql = "select a_v_no,party.p_name,a_date,a_amount from account join party where party.p_id=account.p_id and a_date='$date' order by a_v_no desc";
$res = $conn->query($sql);
while($row = $res->fetch_assoc()){
?>
<tr>
	<td class="guj"><?php echo $row['a_v_no'] ?></td>
	<td class="guj"><?php echo $row['p_name'] ?></td>
	<td class="guj"><?php echo date('d.m.Y',strtotime($row['a_date'])) ?></td>
	<td class="guj"><?php echo $row['a_amount'] ?></td>
</tr>
<?php
}
?>
