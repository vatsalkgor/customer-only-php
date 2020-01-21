<?php 
session_start();
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
$date=date('Y-m-d',strtotime($_POST['date']));
$sql = "select pu_id,pu_i_id, items.i_name from purchase join items where items.i_id=pu_i_id and pu_b_date='$date' and pu_f_id=".$_POST['f_id'];
$res = $conn->query($sql);
echo "<option></option>";
while ($row = $res->fetch_assoc()) {
	?>
	<option value="<?php echo $row['pu_i_id'] ?>"><?php echo $row['i_name'] ?></option>
	<?php
}
?>