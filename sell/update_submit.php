<?php 
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
$sql = "update sell_bill set s_qty=".$_POST['s_qty']." ,s_weight=".$_POST['s_weight'].", s_rate=".$_POST['s_rate'].",s_o_rate=".$_POST['s_o_rate'].",s_wage=".$_POST['s_wage'].",s_com=".$_POST['s_comm'].",s_o_e=".$_POST['s_o_expense'].",s_total=".$_POST['s_total']." where s_b_no=".$_POST['s_b_no'];
if($conn->query($sql) === TRUE){
	header('location:../new_sell.php');
}
else{
	echo "un";
	echo $conn->error;
			// header('location:update_sell_details.php');
}
?>