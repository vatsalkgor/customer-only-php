<?php 
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
$bill = $_POST['b_no'];
$res = "";

$date=date('Y.m.d',strtotime($_POST['b_date']));
foreach ($_POST['table'] as $key => $value) {
	$sql = "insert into purchase (pu_b_no,pu_b_date,pu_f_id,pu_i_id,pu_i_qty,pu_i_sold,pu_i_pending,pu_remarks,pu_biled) values($bill,'$date',$value[2],$value[5],$value[6],0,$value[6],'".$_POST['remarks']."',0)";
	if($conn->query($sql) === TRUE){
		$res .= "1";
	}else{
		$res .= "0";
		echo $conn->error;
	}
	echo $res;
}
?>