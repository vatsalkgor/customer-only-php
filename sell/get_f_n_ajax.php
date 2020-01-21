<?php 
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
print_r($_POST);
$date=date('Y-m-d',strtotime($_POST['date']));
$sql = "SELECT pu_f_id, party.p_name from purchase join party where party.p_id = pu_f_id and pu_b_date='$date' group by pu_f_id order by party.p_name";
$res = $conn->query($sql);
?>
<option></option>
<?php
while ($row = $res->fetch_assoc()) {
	?>
	<option value="<?php echo $row['pu_f_id'] ?>"><?php echo $row['p_name'] ?></option>
	<?php
}
?>