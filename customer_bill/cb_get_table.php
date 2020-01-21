<?php 
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
$finalData = array();
$i = 0;
$sql;
$f_date = date('Y.m.d',strtotime($_POST['f_date']));
$t_date = date('Y.m.d',strtotime($_POST['t_date']));
if($_POST['c_name'] == 0 && $_POST['i_name'] == 0){
	$sql = "select s_b_no, s_date, party.p_name,items.i_name, s_qty, s_weight, s_rate, s_com, s_wage, s_o_e, s_total from sell_bill join party,items where party.p_id = s_c_id and items.i_id = s_i_id and s_date between '$f_date' and '$t_date' order by party.p_name ";
}
else if($_POST['c_name'] !=0 && $_POST['i_name'] == 0){
	$sql = "select s_b_no, s_date, party.p_name,items.i_name, s_qty, s_weight, s_rate, s_com, s_wage, s_o_e, s_total from sell_bill join party,items where party.p_id = s_c_id and items.i_id = s_i_id and s_date between '$f_date' and '$t_date' and s_c_id=".$_POST['c_name']." order by party.p_name ";
}
else if($_POST['c_name'] ==0 && $_POST['i_name'] != 0){
	$sql = "select s_b_no, s_date, party.p_name,items.i_name, s_qty, s_weight, s_rate, s_com, s_wage, s_o_e, s_total from sell_bill join party,items where party.p_id = s_c_id and items.i_id = s_i_id and s_date between '$f_date' and '$t_date' and s_i_id=".$_POST['i_name']." order by party.p_name ";
}
else if($_POST['c_name'] !=0 && $_POST['i_name'] != 0){
	$sql = "select s_b_no, s_date, party.p_name,items.i_name, s_qty, s_weight, s_rate, s_com, s_wage, s_o_e, s_total from sell_bill join party,items where party.p_id = s_c_id and items.i_id = s_i_id and s_date between '$f_date' and '$t_date' and s_c_id=".$_POST['c_name']." and s_i_id=".$_POST['i_name']." order by party.p_name ";
}
$data = array();
$res = $conn->query($sql);
while($row = $res->fetch_assoc()){
	$temp = array();
	$temp['b_no'] = $row['s_b_no'];
	$temp['b_date'] = $row['s_date'];
	$temp['c_name'] = $row['p_name'];
	$temp['i_name'] = $row['i_name'];
	$temp['qty'] = $row['s_qty'];
	$temp['weight'] = $row['s_weight'];
	$temp['rate'] = $row['s_rate'];
	$temp['com'] = $row['s_com'];
	$temp['wage'] = $row['s_wage'];
	$temp['other'] = $row['s_o_e'];
	$temp['total'] = $row['s_total'];
	array_push($data, $temp);
}
// $bill_no = array();
// foreach ($data as $key => $value) {
// 	$bill_no[$key] = $value['b_no'];
// }
// array_multisort($bill_no,SORT_ASC,$data);
foreach ($data as $key => $value) {
?>
<tr class="guj">
	<td><input style="margin-left: 10px;" type="checkbox" name="check" value="<?php echo $value['b_no'] ?>" class="form-check-input"></td>
	<td><?php echo $value['b_no'] ?></td>
	<td><?php echo str_replace('-', '.', date('d-m-Y',strtotime($value['b_date']))) ?></td>
	<td><?php echo $value['c_name'] ?></td>
	<td><?php echo $value['i_name'] ?></td>
	<td><?php echo $value['qty'] ?></td>
	<td><?php echo $value['weight'] ?></td>
	<td><?php echo $value['rate'] ?></td>
	<td><?php echo $value['com'] ?></td>
	<td><?php echo $value['wage'] ?></td>
	<td><?php echo $value['other'] ?></td>
	<td><?php echo $value['total'] ?></td>
</tr>
<?php
}
?>
