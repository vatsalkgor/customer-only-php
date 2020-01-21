<?php 
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
// $date =  Date('d.m.Y');
$f_date =date('Y.m.d',strtotime($_POST['f_date']));
$t_date =date('Y.m.d',strtotime($_POST['t_date']));
$sql = "select pu_id,`pu_b_date`,`pu_b_no`,party.p_name,SUM(`pu_i_pending`) as pu_i_pending,pu_biled from purchase JOIN party where party.p_id = pu_f_id and pu_b_date BETWEEN '$f_date' and '$t_date' group by pu_b_no,pu_biled";
$res = $conn->query($sql);
while ($row = $res->fetch_assoc()) {
	?>
	<tr>
		<td class="guj" value="<?php echo $row['pu_b_date'] ?>"><?php echo date('d.m.Y',strtotime($row['pu_b_date']))?></td>
		<td class="guj" value="<?php echo $row['pu_b_no'] ?>"><?php echo $row['pu_b_no'] ?></td>
		<td class="guj" value="<?php echo $row['p_name'] ?>"><?php echo $row['p_name'] ?></td>
		<td class="guj" value="<?php echo $row['pu_i_pending'] ?>"><?php echo $row['pu_i_pending'] ?></td>
		<td value="<?php echo $row['pu_biled'] == 0 ? 'NO':'YES' ?>"><?php echo $row['pu_biled'] == 0? "NO":"YES" ?></td>
		<td><a target="_blank" href="buy/post.php?id=<?php echo $row['pu_b_no'] ?>"><button class="btn btn-primary">Edit</button></a></td>
		<td><a target="_blank" href="farmer/post.php?id=<?php echo $row['pu_b_no']?>"><button class="btn btn-secondary" <?php echo $row['pu_biled'] ==1 ? 'disabled':'' ?>>Make Bill</button></a></td>
	</tr>
	<?php
}
?>