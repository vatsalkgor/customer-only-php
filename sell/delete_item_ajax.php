<?php 
	include '../database/Database.php';
	$db = new Database();
	$conn = $db->connect();
	$sql = "delete from sell_bill where s_id=".$_POST['id'];
	if($conn->query($sql) == TRUE){
		echo 1;
	}else{
		echo 0;
	}
?>