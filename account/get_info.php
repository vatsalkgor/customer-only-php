	<?php 
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
$f_date = date('Y-m-d',strtotime($_POST['f_date']));
$t_date = date('Y-m-d',strtotime($_POST['t_date']." +1 day"));
$data = array();
$i=0;
while(strcmp($f_date,$t_date) !=0){
	$data[$i] = array();
	array_push($data[$i], date('d-m-Y',strtotime($f_date)));
	$income = "select IFNULL(ROUND(SUM(a_amount)),0) from account where a_date='$f_date'";
	array_push($data[$i], $conn->query($income)->fetch_array()[0]);
	$c_com = "select IFNULL(ROUND(SUM(s_com)),0) from (select * from sell_bill where s_date='$f_date' group by s_b_no) t1";
	array_push($data[$i], $conn->query($c_com)->fetch_array()[0]);
	$f_date = date('Y-m-d',strtotime($f_date." +1 day"));
	$i++;
}
// $data[$i] = array();
// array_push($data[$i], $f_date);
// $expense = "select((select IFNULL(ROUND(SUM(f_net)),0) from farmer where f_b_date='$f_date') - (select IFNULL(ROUND(SUM(f_bhado)),0) from farmer where f_b_date='$f_date')) as expense";
// array_push($data[$i], $conn->query($expense)->fetch_array()[0]);
// $income = "select IFNULL(ROUND(SUM(s_total)),0) from sell_bill where s_date='$f_date'";
// array_push($data[$i], $conn->query($income)->fetch_array()[0]);
// $f_com = "select IFNULL(ROUND(SUM(f_com)),0) from farmer where f_b_date='$f_date'";
// array_push($data[$i], $conn->query($f_com)->fetch_array()[0]);
// $c_com = "select IFNULL(ROUND(SUM(s_com)),0) from sell_bill where s_date='$f_date'";
// array_push($data[$i], $conn->query($c_com)->fetch_array()[0]);
// $f_date = date('Y-m-d',strtotime($f_date." +1 day"));
$t_expense = 0;
$t_income = 0;
$t_f_com = 0;
$t_c_com = 0;
foreach ($data as $key => $value) {
	$t_income += $value[1];
	$t_c_com += $value[2];
	?>
	<tr>
		<td><?php echo $value[0]?></td>
		<td><?php echo $value[1]?></td>
		<td><?php echo $value[2]?></td>
	</tr>
	<?php
}
?>
<tr>
	<td></td>
	<td>Total</td>
	<td>Total</td>
</tr>
<tr>
	<td></td>
	<td><?php echo $t_income ?></td>
	<td><?php echo $t_c_com ?></td>
</tr>
	