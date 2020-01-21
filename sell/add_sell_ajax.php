<?php 
session_start();
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
$date = date('Y.m.d',strtotime($_POST['s_date']));
$sql = "insert into sell_bill(s_b_no,s_date,s_c_id,s_i_id,s_qty,s_weight,s_rate,s_o_rate,s_com,s_wage,s_o_e,s_total) values(".$_POST['s_b_no'].",'$date',".$_POST['s_c_name'].",".$_POST['s_item'].",".$_POST['s_qty'].",".$_POST['s_weight'].",".$_POST['s_rate'].",".$_POST['s_o_rate'].",".$_POST['s_comm'].",".$_POST['s_wage'].",".$_POST['s_o_expense'].",".$_POST['s_total'].")";
$last;
if($conn->query($sql) === TRUE ){
		$last = $conn->insert_id;
		$data[0] = "Item Added Successfully.";
		$sql = "select s_id,s_b_no,party.p_name,items.i_name,s_qty,s_weight,s_rate,s_com,s_wage,s_o_e,s_total from sell_bill join party,items where party.p_id = s_c_id and items.i_id = s_i_id and s_id=".$last;
		$row = $conn->query($sql)->fetch_array();
		$data[1] = $row;
}else{
	echo $conn->error;
	$data[0] = "Insert Error. Neither inserted nor updated.";
}
echo json_encode($data);
?>